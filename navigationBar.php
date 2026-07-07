<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function goToHome(){
            window.location.href = "./index.php";
        }
        function goToSignin(){
            window.location.href = "./login.php";
        }
        function goToProducts(){
            
        }
        function goToAbout(){
            
        }
        function goToContact(){
            
        }
        // function goToHome(){
            
        // }
        // function goToHome(){
            
        // }
    </script>
    <link rel="stylesheet" href="./navigationBar1.css">
</head>
<body>

    <header>
    <div class="logo">
        <img src="./pictures/logo2.png" alt="BigBrew Logo" onclick="goToHome()">
    </div>
    <button onclick="window.location.href='login.php'">Sign in</button>
    </header>
</header>
</body>
</html>


