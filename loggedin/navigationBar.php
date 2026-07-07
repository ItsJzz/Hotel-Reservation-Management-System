<?php
include("databaseConnection.php");


$userGreeting = "Hello, Guest";
$profilePicture = isset($_SESSION['profile_pictures']) && $_SESSION['profile_pictures'] != '' 
    ? $_SESSION['profile_pictures'] 
    : './pictures/default-profile.png';


// If a user is logged in
if (isset($_SESSION['emailAddress'])) {
    $email = $_SESSION['emailAddress'];

    $stmt = $conn->prepare("SELECT firstName, profile_pictures FROM login_credentials WHERE emailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($firstName, $profilePicPath);

    if ($stmt->fetch()) {
        $userGreeting = "Hello, " . htmlspecialchars($firstName);
        if (!empty($profilePicPath)) {
            $profilePicture = $profilePicPath;
        }
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BigBrew</title>
    <link rel="stylesheet" href="./navigationBar1.css">
</head>
<body>
    <header>
        <div class="logo" onclick="window.location.href='index.php'">
            <img src="../pictures/logo2.png" alt="BigBrew Logo">
        </div>

        <!-- Greeting & Profile Picture Button -->
        <button onclick="goToProfile()" class="greeting-button">
            <img src="<?php echo $profilePicture; ?>" class="user-icon" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
            <?php echo $userGreeting; ?>
        </button>
    </header>

    <script>
        function goToProfile() {
            window.location.href = "./profile.php";
        }
    </script>
</body>
</html>
