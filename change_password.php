<?php
session_start();
include("databaseConnection.php");

if (!isset($_SESSION['emailAddress'])) {
    header("Location: login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_SESSION['emailAddress'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $stmt = $conn->prepare("SELECT password FROM login_credentials WHERE emailAddress = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($current_hash);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($old_password, $current_hash)) {
        if ($new_password === $confirm_password) {
            $new_hash = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE login_credentials SET password = ? WHERE emailAddress = ?");
            $update->bind_param("ss", $new_hash, $email);
            $update->execute();

            $message = "<span style='color: green;'>Password changed successfully!</span>";
        } else {
            $message = "<span style='color: red;'>New passwords do not match.</span>";
        }
    } else {
        $message = "<span style='color: red;'>Old password is incorrect.</span>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="profile.css">
</head>
<body>

<?php include 'sidebar.php'; ?>

<div class="contents">
    <div class="profile-container">
        <h2 style="margin-bottom: 20px;">🔒 Change Password</h2>

        <?php if (!empty($message)) echo "<p>$message</p>"; ?>

        <form method="post" action="change_password.php" class="info">
            <label>Old Password:</label>
            <input type="password" name="old_password" required>

            <label>New Password:</label>
            <input type="password" name="new_password" required>

            <label>Confirm New Password:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" value="Update Password" class="save-button">
        </form>
    </div>
</div>

</body>
</html>
