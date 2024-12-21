<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);
    $randomTime = date('Y-m-d H:i:s', strtotime('+' . rand(1, 1000) . ' seconds')); // Random date and time

    try {
        // Send email to site owner
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'handsomed679@gmail.com';
        $mail->Password   = 'rbdpmecuurfodgot';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('handsomed679@gmail.com', 'Daniel Amos');
        $mail->addAddress('favouramos2024@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Us Message from ' . $name . ' at ' . $randomTime;
        $mail->Body    = "
            <h2>Contact Us Form Submission</h2>
            <p><strong>Name:</strong> {$name}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Phone:</strong> {$phone}</p>
            <p><strong>Message:</strong> {$message}</p>
        ";
        $mail->AltBody = "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nMessage: {$message}";

        $mail->send();

       // Send thank you email to the user
$mail->clearAddresses();
$mail->addAddress($email);
$mail->Subject = 'Thank You for Contacting Us!';

$mail->Body    = "
    <html>
    <head>
        <style>
            /* Email body style */
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 0;
                width: 100%;
            }
            .container {
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .logo {
                text-align: center;
                margin-bottom: 20px;
            }
            .content {
                text-align: center;
            }
            .content h2 {
                color: #333;
                margin-bottom: 20px;
            }
            .content p {
                color: #555;
                font-size: 16px;
                line-height: 1.6;
            }
            .footer {
                text-align: center;
                color: #999;
                font-size: 14px;
                margin-top: 30px;
            }
            /* Responsive design */
            @media (max-width: 600px) {
                .container {
                    padding: 15px;
                }
                .content h2 {
                    font-size: 20px;
                }
                .content p {
                    font-size: 14px;
                }
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <!-- Company Logo -->
            <div class='logo'>
                <img src='https://nestofhopesupport.com/assets/img/logo/banner.png' alt='Company Logo' width='150'>
            </div>
            
            <!-- Email Content -->
            <div class='content'>
                <h2>Thank You, {$name}!</h2>
                <p>We deeply appreciate your message and your interest in supporting cancer prevention, awareness, and advocacy.</p>
                <p>Our team is dedicated to raising awareness and providing vital information to help individuals and families affected by cancer. We will review your message and respond as soon as possible.</p>
                <p>Thank you for being a part of our mission to make a difference.</p>
            </div>

            <!-- Footer -->
            <div class='footer'>
                <p>Best regards,<br>Nest Of Hope Support Team</p>
            </div>
        </div>
    </body>
    </html>
";

$mail->AltBody = "Thank You, {$name}!\n\nWe deeply appreciate your message and your interest in supporting cancer prevention, awareness, and advocacy.\n\nOur team is dedicated to raising awareness and providing vital information to help individuals and families affected by cancer. We will review your message and respond as soon as possible.\n\nThank you for being a part of our mission to make a difference.\n\nBest regards,\nNest Of Hope Support Team";



        $mail->send();

        // Redirect to success page
        header("Location: success.html");
    } catch (Exception $e) {
        // Redirect to error page
        header("Location: error.html?error=" . urlencode($mail->ErrorInfo));
    }
}
?>
