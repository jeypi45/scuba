<?php
session_start();
require 'config.inc.php';
require_once 'vendor/autoload.php';

// Error logging for debugging
error_log("Payment success page loaded");

// Verify payment was successful
if (!isset($_GET['session_id'])) {
    $_SESSION['error'] = "Invalid payment session.";
    header("Location: index.php");
    exit;
}

// Set your Stripe API key
$stripe_secret_key = "sk_test_51Qx5JoG8viYQv2tVeXXLLa5pjIfYKlAYtWcYfuEyGWM202WP2uOgucZVsH55FWLqcjn3iECJbqUYY8vWKAMcsqRh009qz3gfxT";

\Stripe\Stripe::setApiKey($stripe_secret_key);

try {
    // Retrieve the session to verify payment
    $session = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
    error_log("Payment status: " . $session->payment_status);

    if ($session->payment_status == 'paid') {
        // Payment was successful, process the reservation
        if (!isset($_SESSION['reservation_data'])) {
            $_SESSION['error'] = "Reservation data not found.";
            header("Location: index.php");
            exit;
        }

        // Get form data from session
        $data = $_SESSION['reservation_data'];
        error_log("Reservation data: " . print_r($data, true));

        // Extract reservation data
        $firstname = $data['firstname'];
        $middlename = $data['middlename'];
        $lastname = $data['lastname'];
        $address = $data['address'];
        $contactno = $data['contactno'];
        $email = isset($data['email']) ? $data['email'] : '';
        $extra_dive = $data['extra_dive'];
        $room_id = $data['room_id'];
        $checkin = $data['checkin'];
        $checkout = $data['checkout'];
        $reservation_id = isset($data['reservation_id']) ? $data['reservation_id'] : 'SCUBA-' . uniqid();
        $num_guests = isset($data['num_guests']) ? intval($data['num_guests']) : 1;

        // Calculate days
        $checkinDate = new DateTime($checkin);
        $checkoutDate = new DateTime($checkout);
        $days = $checkinDate->diff($checkoutDate)->days;
        $days = max($days, 1); // Ensure at least 1 day

        // Get room details
        $query = $con->query("SELECT * FROM `room` WHERE `room_id` = '$room_id'");
        $fetch = $query->fetch_array();
        $room_type = $fetch['room_type'];

        // Determine room_no range based on room type
        if ($room_type === "Regular Room") {
            $roomStart = 1;
            $roomEnd = 15;
        } elseif ($room_type === "Family Room") {
            $roomStart = 16;
            $roomEnd = 17;
        } else {
            $_SESSION['error'] = "Invalid room type!";
            header("Location: index.php");
            exit;
        }

        // Fetch occupied rooms for the selected date range
        $roomQuery = $con->query("
            SELECT room_no FROM `transaction` 
            WHERE room_no BETWEEN $roomStart AND $roomEnd 
            AND status IN ('Pending', 'Check In')
            AND (
                ('$checkin' BETWEEN checkin AND checkout) 
                OR ('$checkout' BETWEEN checkin AND checkout) 
                OR (checkin BETWEEN '$checkin' AND '$checkout')
            )
        ") or die(mysqli_error($con));

        // Store occupied room numbers
        $occupiedRooms = [];
        while ($row = $roomQuery->fetch_assoc()) {
            $occupiedRooms[] = $row['room_no'];
        }

        // Find the first available room in the range
        $room_no = null;
        for ($i = $roomStart; $i <= $roomEnd; $i++) {
            if (!in_array($i, $occupiedRooms)) {
                $room_no = $i;
                break;
            }
        }

        if ($room_no !== null) {
            // Check if the email column exists in the guest table
            $emailColumn = "";
            $emailValue = "";

            $result = $con->query("SHOW COLUMNS FROM `guest` LIKE 'email'");
            if ($result->num_rows > 0) {
                $emailColumn = ", email";
                $emailValue = ", '$email'";
            }

            // Insert guest into database
            $con->query("INSERT INTO `guest` (firstname, middlename, lastname, address, contactno$emailColumn) 
                        VALUES ('$firstname', '$middlename', '$lastname', '$address', '$contactno'$emailValue)")
                or die(mysqli_error($con));

            $guest_id = $con->insert_id;
            error_log("Inserted guest ID: $guest_id");

            // Calculate total bill
            $room_price = $fetch['price'];
            $price_per_night = $room_price * $num_guests;
            $extra_dive_cost = 0;
            if ($extra_dive == 'morning') {
                $extra_dive_cost = 12600;
            } elseif ($extra_dive == 'night') {
                $extra_dive_cost = 25200;
            }
            $total_amount = ($price_per_night * $days) + $extra_dive_cost;

            // Check if payment_status and reservation_id columns exist
            $paymentStatusColumn = "";
            $paymentStatusValue = "";
            $reservationIdColumn = "";
            $reservationIdValue = "";

            $result = $con->query("SHOW COLUMNS FROM `transaction` LIKE 'payment_status'");
            if ($result->num_rows > 0) {
                $paymentStatusColumn = ", payment_status";
                $paymentStatusValue = ", 'Paid'";
            }

            $result = $con->query("SHOW COLUMNS FROM `transaction` LIKE 'reservation_id'");
            if ($result->num_rows > 0) {
                $reservationIdColumn = ", reservation_id";
                $reservationIdValue = ", '$reservation_id'";
            }

            // Build the query dynamically based on which columns exist
            $query = "INSERT INTO `transaction` (guest_id, room_id, room_no, num_guests, 
                     extra_dive, days, status, checkin, checkout, bill$paymentStatusColumn$reservationIdColumn) 
                     VALUES (?, ?, ?, ?, ?, ?, 'Pending', ?, ?, ?$paymentStatusValue$reservationIdValue)";

            // Remove prepared statements for the dynamic fields and use this simpler approach
            $stmt = $con->prepare($query);
            $stmt->bind_param(
                "iiiisissd",
                $guest_id,
                $room_id,
                $room_no,
                $num_guests,
                $extra_dive,
                $days,
                $checkin,
                $checkout,
                $total_amount
            );
            $stmt->execute();

            error_log("Transaction inserted successfully");

            // Include the email sending function
            require_once('send_reservation_email.php');

            // Get guest full name
            $guestName = $firstname . ' ' . $lastname;

            // Send the reservation confirmation email with QR code
            $emailSent = sendReservationEmail(
                $email,
                $reservation_id,
                $guestName,
                $checkin,
                $checkout,
                $room_type,
                $data['num_guests'] // Use the actual number of guests
            );

            // Store email status in session for the success page
            $_SESSION['email_sent'] = $emailSent;

            // If email failed, log the error
            if (!$emailSent) {
                error_log("Failed to send reservation confirmation email to $email for reservation $reservation_id");
            }

            // Clear session data
            unset($_SESSION['reservation_data']);

            // Set success message
            $_SESSION['success'] = "Reservation completed successfully! Your reservation ID is: " . $reservation_id;
            header("Location: reservation_success.php?reservation_id=" . urlencode($reservation_id));
            exit;
        } else {
            // No available rooms
            $_SESSION['error'] = "No available rooms for this type. Please try another type or date.";
            header("Location: reservation.php");
            exit;
        }
    } else {
        // Payment was not successful
        $_SESSION['error'] = "Payment was not completed. Status: " . $session->payment_status;
        header("Location: index.php");
        exit;
    }
} catch (Exception $e) {
    error_log("Payment error: " . $e->getMessage());
    $_SESSION['error'] = "Payment verification error: " . $e->getMessage();
    header("Location: index.php");
    exit;
}
?>