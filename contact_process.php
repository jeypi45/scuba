<?php
require('config.inc.php'); // Include database configuration
require 'vendor/autoload.php'; // This is all you need for PHPMailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
// Set headers for JSON response
header('Content-Type: application/json');

// Initialize response array
$response = array(
    'success' => false,
    'message' => 'Something went wrong.'
);

// Check if form was submitted
if (isset($_POST['submit']) || isset($_POST['name'])) {
    // Get form data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['message'] = 'Please enter a valid email address.';
        echo json_encode($response);
        exit;
    }

    // Check for empty fields
    if (empty($name) || empty($email) || empty($message)) {
        $response['message'] = 'Please fill in all required fields.';
        echo json_encode($response);
        exit;
    }

    // Email content
    $email_body = "
    <!DOCTYPE html>
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            h2 { color: #3b5998; }
            .info { margin-bottom: 20px; }
            .label { font-weight: bold; }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>New Contact Form Submission</h2>
            <div class='info'>
                <p><span class='label'>Name:</span> $name</p>
                <p><span class='label'>Email:</span> $email</p>
                <p><span class='label'>Message:</span></p>
                <p>" . nl2br($message) . "</p>
            </div>
            <p>This message was sent from the ScuBaConnect contact form.</p>
        </div>
    </body>
    </html>
    ";

    // Save to database first
    $status = 'unread'; // Default status for new messages
    $current_date = date('Y-m-d H:i:s');

    // Prepare and execute the INSERT query
    $query = "INSERT INTO message (name, email, message, created_at, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("sssss", $name, $email, $message, $current_date, $status);
    $db_success = $stmt->execute();

    if (!$db_success) {
        $response['message'] = 'Failed to save your message to our database. Error: ' . $con->error;
        echo json_encode($response);
        exit;
    }

    // Using PHPMailer instead of mail() function
    try {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'scubaconnect30@gmail.com'; // Your Gmail address
        $mail->Password = 'bqqi pbfk qfnn lpwg'; // Your Gmail app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('scubaconnect30@gmail.com', 'ScuBaConnect');
        $mail->addAddress('scubaconnect30@gmail.com');
        $mail->addReplyTo($email, $name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission from ' . $name;
        $mail->Body = $email_body;
        $mail->AltBody = strip_tags($message);

        $mail->send();

        $response['success'] = true;
        $response['message'] = 'Thank you for your message! We will get back to you soon.';
    } catch (Exception $e) {
        // Even if email fails, we've already saved to database
        $response['success'] = true; // Still consider it a success
        $response['message'] = 'Your message was received! (Email notification failed but our team will still see your message)';
    }
}

// Return JSON response
echo json_encode($response);
exit;
?>