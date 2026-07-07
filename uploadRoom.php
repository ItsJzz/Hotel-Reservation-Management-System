<?php
include("databaseConnection.php");

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

    $image = $_FILES['image']['name'];
    $image = str_replace(' ', '_', $image);
    $targetDirectory = "pictures/";
    $targetFilePath = $targetDirectory . basename($image);

    if (!file_exists($targetDirectory)) {
        mkdir($targetDirectory, 0777, true);
    }

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
        $query = "INSERT INTO hotel_rooms (name, description, image_path, category)
                  VALUES ('$name', '$description', '$targetFilePath', '$category')";

        if (mysqli_query($conn, $query)) {
            echo "<script>
                alert('Room Successfully Uploaded!');
                window.location.href = 'room.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('Database error: " . addslashes(mysqli_error($conn)) . "'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Failed to upload image.'); window.history.back();</script>";
    }
}
?>
