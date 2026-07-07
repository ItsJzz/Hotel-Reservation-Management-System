<?php
    session_start();
    include("navigationBar.php");
    include("databaseConnection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Rooms</title>
    <link rel="stylesheet" href="./hotel.css">
</head>
<body>
    <h2 class="Tag">All Hotel</h2>
    <table class="RoomTable">
        <tr>
            <td><button onclick="window.location.href='products.php'" >All</button></td>
            <td><button onclick="window.location.href='LuxuryHotel.php'">Luxury Stay</button></td>
            <td><button onclick="window.location.href='UniqueStay.php'"style="background-color:#8b7655; color:white;">Unique Stay</button></td>
            <td><button onclick="window.location.href='PremiumStay.php'">Premium Stay</button></td>
            <td><button onclick="window.location.href='BusinessStay.php'">Business Stay</button></td>
        </tr>
    </table>

    <table class="ImageTable">
        <?php
            // Fetch 18 rooms (6 for each of 3 rows = 18)
            $query = "SELECT * FROM hotel_rooms WHERE category='Unique Stay' LIMIT 6";
            $result = mysqli_query($conn, $query);
            $counter = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                if ($counter % 3 === 0) {
                    echo "<tr>"; // Start a new row every 3 items
                }

                echo "<td class='RoomCell'>";
                echo "<img src='../" . htmlspecialchars($row['image_path']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<div class='RoomName'>" . htmlspecialchars($row['name']) . "</div>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<div class='btnText'>" . htmlspecialchars($row['category']) . "</div>";
                echo "<button class='book-now' onclick=\"bookRoom('" . htmlspecialchars($row['name']) . "')\">Book Now</button>";
                echo "</td>";

                $counter++;

                if ($counter % 3 === 0) {
                    echo "</tr>"; // End the row
                }
            }

            // Fill empty <td>s if needed to complete the last row
            if ($counter % 3 !== 0) {
                while ($counter % 3 !== 0) {
                    echo "<td class='RoomCell'></td>";
                    $counter++;
                }
                echo "</tr>";
            }
        ?>
    </table>

    <script>
        function bookRoom(roomName) {
            alert('You have selected ' + roomName + ' for booking!');
            // Implement booking logic later
        }
    </script>
</body>
</html>
