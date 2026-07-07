<?php
include("databaseConnection.php"); // ito database ko
session_start();


function ReSendOTP(){ // ito yung method para mag ggenerate ng random code
    $length = 6;
    $characters = '0123456789';
    $_SESSION["otp"] = '';

    for ($x = 0; $x < $length; $x++) {
        $_SESSION["otp"] .=  $characters[random_int(0, strlen($characters) - 1)];
    }
}
ReSendOTP();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\Exception.php'; // need mo palitan yung tatlo na to based sa file path mo
require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\SMTP.php';

$email = $_SESSION['email_address']; //palitan mo to ito yung session na input ng user

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'theresthavens@gmail.com'; // ito palit mo email mo na pang send
    $mail->Password   = 'jqbb tetu xcwv nqso';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;


    $mail->setFrom($email, 'Big Brew Pinagbarilan'); // dito yung email nung nag register saka pangalan nung email address mo
    $mail->addAddress($email, $_SESSION['email_address']); // pati ito 


    $mail->isHTML(true);
    $mail->Subject = 'OTP Verification Code';
    $mail->Body    = 'Your one-time password (OTP) is: <b>['. $_SESSION["otp"]. ']</b>. Please enter it to verify your identity.';
    $mail->AltBody = '';


    $mail->send();
} catch (Exception $e) {
    echo "Failed To Send {$mail->ErrorInfo}";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link rel="stylesheet" href="./mail1.css">
    <script>
        function Validate(){
           
            let userInput = document.getElementById("first").value + document.getElementById("second").value + 
                                    document.getElementById("third").value + document.getElementById("fourth").value + 
                                    document.getElementById("fifth").value + document.getElementById("sixth").value;
                            
            let OTP = "<?php echo $_SESSION['otp']; ?>";
  
          if(userInput == OTP){
                window.location.href = "registerFinal.php";  
            }else{
            alert("Wrong OTP.");
          }
        }

        function moveFocus(currentInput, nextInputId) {
            if (currentInput.value.length >= currentInput.maxLength) {
                const nextInput = document.getElementById(nextInputId);
                if (nextInput) {
                    nextInput.focus();
                }
            }
        }
        
    </script>

</head>

<body>
    <center>
    <div id="container">
        <div id="otp-container">
                <img src="./pictures/otp picture.png" alt="">
                <div class="text-container">
                    <p>Enter the OTP sent to your email.</p>
                </div>
               
                <div id="input-container">
                    <input type="text" maxlength="1" name="first" id="first" oninput="moveFocus(this, 'second')" required>
                    <input type="text" maxlength="1" name="second" id="second" oninput="moveFocus(this, 'third')" required>
                    <input type="text" maxlength="1" name="third" id="third" oninput="moveFocus(this, 'fourth')" required>
                    <input type="text" maxlength="1" name="fourth" id="fourth" oninput="moveFocus(this, 'fifth')" required>
                    <input type="text" maxlength="1" name="fifth" id="fifth" oninput="moveFocus(this, 'sixth')" required>
                    <input type="text" maxlength="1" name="sixth" id="sixth" required>

                    <div id="button-container">
                        <input type="submit" value="VERIFY" onclick="Validate()">
                    </div>
                </div>

                <div class="resend">
                    <a href="./mail.php">Didn't receive the OTP? <span>RESEND OTP</span></a>
                </div>
               
        </div>
    </div>
</center>
</body> 

</html>
