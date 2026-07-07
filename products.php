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
    <link rel="stylesheet" href="./products.css">
    
</head>
<body>
    <h2 class="Tag">All Hotel</h2>
    <table class="RoomTable">
        <tr>
            <td><button onclick="window.location.href='products.php'" style="background-color:#8b7655; color:white;">All</button></td>
            <td><button onclick="window.location.href='LuxuryHotel.php'">Luxury Stay</button></td>
            <td><button onclick="window.location.href='UniqueStay.php'">Unique Stay</button></td>
            <td><button onclick="window.location.href='PremiumStay.php'">Premium Stay</button></td>
            <td><button onclick="window.location.href='BusinessStay.php'">Business Stay</button></td>
        </tr>
    </table>

    <table class="ImageTable">
        <?php
            $query = "SELECT * FROM hotel_rooms LIMIT 24";
            $result = mysqli_query($conn, $query);
            $counter = 0;

            while ($row = mysqli_fetch_assoc($result)) {
                if ($counter % 3 === 0) echo "<tr>";

                $roomName = htmlspecialchars($row['name'], ENT_QUOTES);
                $roomCategory = htmlspecialchars($row['category'], ENT_QUOTES);
                $roomImage = htmlspecialchars($row['image_path'], ENT_QUOTES);
                $encodedRoomName = urlencode($roomName);

                echo "<td class='RoomCell'>";
                echo "<img src='../$roomImage' alt='$roomName'>";
                echo "<div class='RoomName'>$roomName</div>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<div class='btnText'>$roomCategory</div>";
                echo "<button class='book-now' onclick=\"bookRoom('$roomName', '$roomCategory', '$roomImage', '$encodedRoomName')\">Book Now</button>";
                echo "</td>";

                $counter++;
                if ($counter % 3 === 0) echo "</tr>";
            }

            if ($counter % 3 !== 0) {
                while ($counter % 3 !== 0) {
                    echo "<td class='RoomCell'></td>";
                    $counter++;
                }
                echo "</tr>";
            }
        ?>
    </table>

    <!-- Modal -->
    <div id="bookingModal" class="modal">
        <div class="modal-content">
            <img id="modalImage" src="" alt="Room Image">
            <div id="modalRoomName" style="font-weight: bold; font-size: 18px;"></div>
            <div id="modalCategory" style="color: #666; font-size: 14px; margin-bottom: 12px;"></div>
            <p id="modalText">Would you like to book this room?</p>
            <input type="hidden" id="selectedRoomType">
            <button id="confirmBtn">✅ Confirm Booking</button>
            <button onclick="closeModal()">❌ Cancel</button>
        </div>
    </div>

    <script>
        let selectedRoomEncoded = '';

        function bookRoom(roomName, roomCategory, roomImage, encodedRoomName) {
            selectedRoomEncoded = encodedRoomName;
            document.getElementById("modalRoomName").innerText = roomName;
            document.getElementById("modalCategory").innerText = roomCategory;
            document.getElementById("modalText").innerText = `Would you like to book this room?`;
            document.getElementById("modalImage").src = "../" + roomImage;
            document.getElementById("selectedRoomType").value = roomCategory
            document.getElementById("bookingModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("bookingModal").style.display = "none";
        }

        document.getElementById("confirmBtn").addEventListener("click", function () {
            window.location.href = "booking.php?room=" + selectedRoomEncoded + "&roomType=" + encodeURIComponent(document.getElementById("selectedRoomType").value);
        });

        window.onclick = function(event) {
            const modal = document.getElementById("bookingModal");
            if (event.target === modal) {
                closeModal();
            }
        };
    </script>
</body>
</html>
