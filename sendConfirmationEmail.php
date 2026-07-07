<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'path/to/PHPMailer/PHPMailer.php';
require 'path/to/PHPMailer/Exception.php';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your-email@example.com';
    $mail->Password = 'your-email-password';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('your-email@example.com', 'Big Brew Pinagbarilan');
    $mail->addAddress($email, $name);  // Send email to the user's email address

    $mail->isHTML(true);
    $mail->Subject = 'Reservation Confirmation - Big Brew Pinagbarilan';
    $mail->Body = "
        <h3>Your Reservation has been Confirmed!</h3>
        <p>Dear $name,</p>
        <p>Thank you for booking with us. Here are the details of your reservation:</p>
        <ul>
            <li><strong>Room Type:</strong> $roomType</li>
            <li><strong>Arrival Date:</strong> $arrivalDate at $arrivalTimeFormatted</li>
            <li><strong>Departure Date:</strong> $departureDate</li>
            <li><strong>Guests:</strong> $guests</li>
            <li><strong>Food Request:</strong> $foodRequest</li>
        </ul>
        <p>If you need to make any changes or have any questions, please contact us at <strong>support@bigbrew.com</strong>.</p>
        <p>We look forward to welcoming you!</p>
        <p>Best regards,<br> Big Brew Pinagbarilan Team</p>
    ";
    $mail->send();
} catch (Exception $e) {
    error_log("Email error: {$mail->ErrorInfo}");
}
?>
