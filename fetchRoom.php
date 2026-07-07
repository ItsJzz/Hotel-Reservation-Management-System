<?php
include("databaseConnection.php"); // DB connection

$query = "SELECT name, image_path FROM hotel_rooms LIMIT 3"; // Fetch at least 3
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hotel Rooms</title>
    <style>
        .room-container {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }
        .room-box {
            border: 1px solid #ccc;
            padding: 10px;
            width: 30%;
            text-align: center;
        }
        .room-box img {
            width: 100%;
            height: auto;
        }
        .room-name {
            margin-top: 10px;
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Available Hotel Rooms</h2>

    <div class="room-container">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="room-box">
                <img src="<?php echo $row['image_path']; ?>" alt="Hotel Room Image">
                <div class="room-name"><?php echo $row['name']; ?></div>
            </div>
        <?php } ?>
    </div>
</body>
</html>
