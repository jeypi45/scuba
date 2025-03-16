<?php
require_once('config.inc.php');

if (isset($_POST['add_guest'])) {
	$firstname = $_POST['firstname'];
	$middlename = $_POST['middlename'];
	$lastname = $_POST['lastname'];
	$address = $_POST['address'];
	$contactno = $_POST['contactno'];
	$checkin = $_POST['checkin'];
	$checkout = $_POST['checkout'];
	$room_id = $_REQUEST['room_id']; // Room ID from the form

	// Retrieve extra dive selection
	$extra_dive = isset($_POST['extra_dive']) ? $_POST['extra_dive'] : "none";

	// Calculate number of days (Ensure it's at least 1)
	$checkinDate = new DateTime($checkin);
	$checkoutDate = new DateTime($checkout);
	$days = $checkinDate->diff($checkoutDate)->days;
	$days = max($days, 1); // Prevent 0-day stays

	// Insert guest details
	$con->query("INSERT INTO `guest` (firstname, middlename, lastname, address, contactno) 
                 VALUES('$firstname', '$middlename', '$lastname', '$address', '$contactno')")
		or die(mysqli_error($con));

	// Retrieve guest ID
	$query = $con->query("SELECT guest_id FROM `guest` 
                          WHERE `firstname` = '$firstname' 
                          AND `lastname` = '$lastname' 
                          AND `contactno` = '$contactno' 
                          ORDER BY guest_id DESC LIMIT 1")
		or die(mysqli_error($con));
	$fetch = $query->fetch_array();
	$guest_id = $fetch['guest_id'];

	// Get room type from the room table
	$queryRoomType = $con->query("SELECT room_type FROM `room` WHERE `room_id` = '$room_id'")
		or die(mysqli_error($con));
	$fetchRoomType = $queryRoomType->fetch_array();
	$roomType = $fetchRoomType['room_type'];

	// Determine room_no range based on room type
	if ($roomType === "Regular Room") {
		$roomStart = 1;
		$roomEnd = 15;
	} elseif ($roomType === "Family Room") {
		$roomStart = 16;
		$roomEnd = 17;
	} else {
		die("<script>alert('Invalid room type!'); window.location.href='reservation.php';</script>");
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
	    FOR UPDATE;
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
		// Insert transaction (Reservation) with extra_dive and days
		$con->query("INSERT INTO `transaction`(guest_id, room_id, room_no, status, checkin, checkout, extra_dive, days) 
		VALUES('$guest_id', '$room_id', '$room_no', 'Pending', '$checkin', '$checkout', '$extra_dive', '$days')")
			or die(mysqli_error($con));

		echo "<script>alert('Reservation Successful! Room No: $room_no for $days nights.'); window.location.href='reservation.php';</script>";
	} else {
		echo "<script>alert('No available rooms for this type. Please try another type or date.'); window.location.href='reservation.php';</script>";
	}

	// Create Stripe Checkout session
	require_once 'vendor/autoload.php';

	// Set your Stripe secret key
	\Stripe\Stripe::setApiKey('sk_test_51Qx5JoG8viYQv2tVeXXLLa5pjIfYKlAYtWcYfuEyGWM202WP2uOgucZVsH55FWLqcjn3iECJbqUYY8vWKAMcsqRh009qz3gfxT');

	try {
		// Create checkout session
		$checkout_session = \Stripe\Checkout\Session::create([
			'payment_method_types' => ['card'],
			'line_items' => [
				[
					'price_data' => [
						'currency' => 'krw',
						'product_data' => [
							'name' => $fetch['room_type'],
							'description' => $stayDuration . ' nights stay',
						],
						'unit_amount' => $room_price * 100, // Amount in cents
					],
					'quantity' => $_POST['days'],
				]
			],
			'mode' => 'payment',
			'success_url' => 'https://yourdomain.com/success.php?session_id={CHECKOUT_SESSION_ID}',
			'cancel_url' => 'https://yourdomain.com/cancel.php',
			'client_reference_id' => $reservation_id, // Add your reservation ID here
			'metadata' => [
				'reservation_id' => $reservation_id,
				'guest_name' => $_POST['firstname'] . ' ' . $_POST['lastname'],
				'room_type' => $fetch['room_type']
			],
		]);

		// Redirect to Stripe Checkout
		header("HTTP/1.1 303 See Other");
		header("Location: " . $checkout_session->url);
		exit();

	} catch (Exception $e) {
		// Display error message
		$_SESSION['error'] = "Payment Error: " . $e->getMessage();
		header("Location: add_reserve.php");
		exit();
	}
}
?>