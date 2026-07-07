<?php include 'databaseConnection.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
</head>
<body>
    <h2>Register New Admin</h2>
    <form method="post" enctype="multipart/form-data">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Profile Image:</label><br>
        <input type="file" name="img_profile" required><br><br>

        <input type="submit" name="register" value="Register">
    </form>

<?php
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $img_name = $_FILES['img_profile']['name'];
    $img_tmp = $_FILES['img_profile']['tmp_name'];
    $img_path = "uploads/" . basename($img_name);

    if (move_uploaded_file($img_tmp, $img_path)) {
        $stmt = $conn->prepare("INSERT INTO Admin_Account (username, password, img_profile) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $img_name);

        if ($stmt->execute()) {
            echo "<p>✅ Registration successful!</p>";
        } else {
            echo "<p>❌ Error: " . $stmt->error . "</p>";
        }

        $stmt->close();
    } else {
        echo "<p>❌ Failed to upload profile image.</p>";
    }
}
?>
</body>
</html>
