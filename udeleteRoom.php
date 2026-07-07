<?php
include("databaseConnection.php");

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['room_ids'])) {
        $idsToDelete = implode(",", array_map('intval', $_POST['room_ids']));
        $deleteQuery = "DELETE FROM hotel_rooms WHERE id IN ($idsToDelete)";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<p style='color: green;'>Selected room(s) deleted successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error deleting room(s): " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>No rooms selected for deletion.</p>";
    }
}

// Fetch all rooms
$rooms = mysqli_query($conn, "SELECT * FROM hotel_rooms");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Rooms</title>
    <style>
        table {
            width: 80%;
            margin: 30px auto;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ccc;
            text-align: left;
        }
        input[type="submit"] {
            background-color: #c0392b;
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #922b21;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;">Delete Room(s)</h2>

<form method="POST">
    <table>
        <thead>
            <tr>
                <th>Select</th>
                <th>Room Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($rooms)): ?>
                <tr>
                    <td><input type="checkbox" name="room_ids[]" value="<?= $row['id'] ?>"></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td>
                        <?php if (!empty($row['image_path']) && file_exists($row['image_path'])): ?>
                            <img src="<?= $row['image_path'] ?>" alt="Room Image" width="100">
                        <?php else: ?>
                            No image
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div style="text-align: center;">
        <input type="submit" name="delete" value="Delete Selected Rooms">
    </div>
</form>

</body>
</html>
