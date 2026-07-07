<?php
    include ("navigationBarLogoOnly.php");
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
        <h1>Password Reset Successful</h1>
        <p>Your password has been successfully updated. You can now log in with your new password. <br> <br>
            <span>You will be automatically sent to login in 10 seconds.</span>
        </p>
       

        <button onclick="goToLogin()">
            GO TO LOGIN
        </button>
    </div>

</center>
</body> 

</html>

