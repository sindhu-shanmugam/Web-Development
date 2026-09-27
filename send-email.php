<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Invalid request.");
}


// Get form data
$name = trim($_POST["name"] ?? "");
$company = trim($_POST["company"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$service = trim($_POST["service"] ?? "");
$message = trim($_POST["message"] ?? "");


// Check required fields
if (
    empty($name) ||
    empty($company) ||
    empty($email) ||
    empty($phone) ||
    empty($service) ||
    empty($message)
) {
    exit("Please complete all required fields.");
}


// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit("Please enter a valid email address.");
}


// Create PHPMailer
$mail = new PHPMailer(true);

try {

    // SMTP settings
    $mail->isSMTP();

    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;

    // YOUR GMAIL ADDRESS
    $mail->Username   = 'sin.2296@gmail.com';

    // YOUR GOOGLE APP PASSWORD
    $mail->Password   = 'gaek wtvs kqbr dizz';

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;


    // Sender
    $mail->setFrom(
        'sin.2296@gmail.com',
        'Sun Automations Website'
    );


    // Receiver
    $mail->addAddress(
        'sin.2296@gmail.com',
        'Sun Automations'
    );


    // Reply to customer
    $mail->addReplyTo(
        $email,
        $name
    );


    // Email content
    $mail->isHTML(false);

    $mail->Subject = 'New Website Enquiry - Sun Automations';

    $mail->Body =
        "New enquiry received from the Sun Automations website.\n\n" .

        "----------------------------------------\n" .
        "CONTACT DETAILS\n" .
        "----------------------------------------\n\n" .

        "Full Name: " . $name . "\n" .
        "Company Name: " . $company . "\n" .
        "Email Address: " . $email . "\n" .
        "Phone Number: " . $phone . "\n" .
        "Product / Service: " . $service . "\n\n" .

        "----------------------------------------\n" .
        "PROJECT / REQUIREMENT DETAILS\n" .
        "----------------------------------------\n\n" .

        $message . "\n";


    // Send
    $mail->send();


    // Success
    echo "
    <!DOCTYPE html>
    <html>
    <head>
        <title>Enquiry Sent</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f4f6f8;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
            }

            .message-box {
                background: white;
                padding: 40px;
                text-align: center;
                border-radius: 10px;
                box-shadow: 0 5px 25px rgba(0,0,0,0.1);
                max-width: 500px;
            }

            h1 {
                color: #0b2942;
            }

            a {
                display: inline-block;
                margin-top: 20px;
                padding: 12px 25px;
                background: #0b2942;
                color: white;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>

    <body>

        <div class='message-box'>

            <h1>Thank You!</h1>

            <p>
                Your enquiry has been sent successfully.
                Our team will get back to you soon.
            </p>

            <a href='contact.html'>
                Back to Contact Page
            </a>

        </div>

    </body>
    </html>
    ";


} catch (Exception $e) {

    echo "
    <h2>Sorry, there was a problem sending your enquiry.</h2>
    <p>Please try again later.</p>
    ";

    // For testing only:
    echo "<p>Error: " . htmlspecialchars($mail->ErrorInfo) . "</p>";
}

?>