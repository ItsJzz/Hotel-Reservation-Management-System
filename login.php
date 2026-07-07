<?php
    include("databaseConnection.php");
    include("navigationBarLogoOnly.php");

    
    if(isset($_POST['forgot_button'])){
        header("location: forgotPassword.php");
   }

   if(isset($_POST['register_button'])){
    header("location: register.php");
   }

   

   if(isset($_POST['signin_button'])){
    $email = filter_input(INPUT_POST, "email_txt", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password_txt", FILTER_SANITIZE_SPECIAL_CHARS);
    session_start();
    
    try {
        // Check if admin
        $admin_sql = "SELECT * FROM Admin_Account WHERE username = '$email'";
        $admin_result = mysqli_query($conn, $admin_sql);

        if (mysqli_num_rows($admin_result) > 0) {
            $admin_row = mysqli_fetch_assoc($admin_result);
            if (password_verify($password, $admin_row["password"])) {
                $_SESSION['admin_username'] = $admin_row["username"];
                $_SESSION['admin_img'] = $admin_row["img_profile"];
                header("Location: /finalProject/admin/dashboard.php");
                exit;
            }
        }

        // Otherwise, check regular user login
        $sql = "SELECT * FROM login_credentials WHERE emailAddress = '$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row["Password"])) {
                $_SESSION['user_id'] = $row["id"];
                $_SESSION['firstName'] = $row["firstName"];
                $_SESSION['lastName'] = $row["lastName"];
                $_SESSION['emailAddress'] = $row["emailAddress"];
                $_SESSION['Password'] = $row["Password"];
                $_SESSION['Avatar'] = $row["avatar"];
                header("location:./loggedin/index.php");
                exit;
            } else {
                echo "Wrong password.";
            }
        } else {
            echo "Credentials not found.";
        }
    } catch(Exception $e){
        echo "Error: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./login1.css">
    <script>
        function showRegister(){
            window.location.href = 'register.php';
        }

        function forgotPassword(){
            window.location.href = 'forgotPassword.php';
        }
    </script>
</head> 
<body>
    
    
    <center> 
      <div class="register-container" id="register-container">
            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="login-container" id="login-container">
                <div class="text-header">Glad to have <br>you back!</div>
                
                <div class="data" >
                    <input type="email" name="email_txt" placeholder="Email address" required>
                </div>

                <div class="data">
                    <input type="password" name="password_txt" placeholder="Password" required>
                </div>
                
                <div class="button-container">
                    <input type="submit" value="SIGN IN" name="signin_button" class="signin-button">
                </div>

            </form>  
                <div class="data register-container">
                    <a href="./register.php">Don't have an account? <span>Register here!</span></a>
                </div>
                <div class="forgot-container">
                        <a href="./forgotPassword.php">Forgot password?</a>
                </div>
        </div>

       
    </center>
</body>
</html>

   