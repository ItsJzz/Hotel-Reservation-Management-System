<?php
include 'databaseConnection.php';

$currentRoom = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $roomId = $_POST['room_id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "pictures/";
        $targetFile = $targetDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $imagePath = $targetFile;
        }
    }

    $updateQuery = "UPDATE hotel_rooms SET 
                    name = '$name', 
                    category = '$category', 
                    description = '$description'";
    if ($imagePath !== null) {
        $updateQuery .= ", image_path = '$imagePath'";
    }
    $updateQuery .= " WHERE id = $roomId";

    if (mysqli_query($conn, $updateQuery)) {
        echo "<script>
            alert('Room updated successfully!');
            window.location.href = 'room.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('Error updating room: " . addslashes(mysqli_error($conn)) . "');
            window.history.back();
        </script>";
    }
    
}

$rooms = mysqli_query($conn, "SELECT * FROM hotel_rooms");

if (isset($_GET['room_id'])) {
    $roomId = $_GET['room_id'];
    $roomResult = mysqli_query($conn, "SELECT * FROM hotel_rooms WHERE id = $roomId");
    $currentRoom = mysqli_fetch_assoc($roomResult);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Room</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .floating-panel {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            z-index: 10;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 700px;
            overflow-y: auto;
            max-height: 95vh;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 15px;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        label {
            font-weight: bold;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .d-flex {
            display: flex;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
        }

        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="floating-panel">

    <!-- Navigation Buttons -->
    <div class="mb-4 d-flex gap-2">
        <a href="room.php" class="btn btn-primary">Back to Room Management</a>
    </div>

    <!-- Room Selection Form -->
    <form method="GET" action="updateRoom.php" id="roomSelectForm">
        <label for="room_id">Select Room:</label>
        <select name="room_id" id="room_id" class="form-select" onchange="document.getElementById('roomSelectForm').submit()">
            <option value="">-- Select Room --</option>
            <?php while ($row = mysqli_fetch_assoc($rooms)): ?>
                <option value="<?= $row['id'] ?>" <?= ($currentRoom && $currentRoom['id'] == $row['id']) ? 'selected' : '' ?>>
                    <?= $row['name'] ?> (<?= $row['category'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <!-- Update Room Form -->
    <?php if ($currentRoom): ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="room_id" value="<?= $currentRoom['id'] ?>">

        <div class="mb-3">
            <label for="name">Room Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= htmlspecialchars($currentRoom['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="category">Category:</label>
            <select name="category" id="category" class="form-select" required>
                <?php
                    $categories = ["Luxury Stay", "Unique Stay", "Business Stay", "Premium Stay"];
                    foreach ($categories as $cat):
                ?>
                    <option value="<?= $cat ?>" <?= ($currentRoom['category'] == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" rows="4" required><?= htmlspecialchars($currentRoom['description']) ?></textarea>
        </div>

        <?php if (!empty($currentRoom['image_path']) && file_exists($currentRoom['image_path'])): ?>
            <div class="mb-3">
                <label>Current Image:</label><br>
                <img src="<?= $currentRoom['image_path'] ?>" class="mb-2">
            </div>
        <?php endif; ?>

        <div class="mb-3">
            <label for="image">Change Image (optional):</label>
            <input type="file" class="form-control" name="image" id="image">
        </div>

        <button type="submit" name="submit" class="btn btn-success">Update Room</button>
    </form>
    <?php endif; ?>

</div>

</body>
</html>
