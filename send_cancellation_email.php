<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// Replace with your domain and route
$baseUrl = "http://localhost/finalProject"; // Adjust based on your environment

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@gmail.com'; // Your Gmail
    $mail->Password = 'your-app-password'; // Your Gmail app password
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('your-email@gmail.com', 'Your Hotel Name');
    $mail->addAddress($email, $name);  // Use variables from previous file

    $mail->isHTML(true);
    $mail->Subject = 'Confirm Reservation Cancellation';

    $confirmationLink = $baseUrl . "/confirm_cancellation.php?token=" . $token;

    $mail->Body = "
        <h2>Confirm Your Cancellation</h2>
        <p>Hello <strong>{$name}</strong>,</p>
        <p>You requested to cancel your reservation. To confirm this cancellation, please click the button below:</p>
        <p><a href='{$confirmationLink}' style='padding: 10px 20px; background-color: #e74c3c; color: white; text-decoration: none; border-radius: 5px;'>Confirm Cancellation</a></p>
        <p>If you did not request this, you can ignore this message.</p>
    ";

    $mail->send();
} catch (Exception $e) {
    error_log("Email sending failed: {$mail->ErrorInfo}");
}
?>
