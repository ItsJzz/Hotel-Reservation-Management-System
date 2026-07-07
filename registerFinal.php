<?php
    include("databaseConnection.php");
    include ("navigationBarLogoOnly.php");
    session_start();
    $firstName = $_SESSION['first_name'];
    $lastName  =  $_SESSION['last_name'];
    $emailAddress = $_SESSION['email_address'];
    $password =  $_SESSION['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO login_credentials (firstName, lastName,emailAddress,Password) VALUES ('$firstName', '$lastName','$emailAddress', '$hash')";
    mysqli_query($conn, $sql);
    session_destroy();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP</title>
    <link rel="stylesheet" href="./registerFinal.css">
    <script>
        function goToLogin(){
            window.location.href = "./login.php";
        }
    </script>

</head>

<body>
<center>
    <div class="container">
        <h1>Successfully Registered</h1>
        <p>You are now a member of BigBrew Community and can now login. <br> <br>
            <span>You will be automatically sent to login in 10 seconds.</span>
        </p>
       

        <button onclick="goToLogin()">
            GO TO LOGIN
        </button>
    </div>

</center>
</body> 

</html>

