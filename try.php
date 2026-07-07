<?php
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
        <!-- Row 1 -->
        <tr>
            <td class="RoomCell">
                <img src="./pictures/LSrecept.png" alt="Luxury Stay Image">
                <div class="RoomName">The Majestic Hall</div>
                <p>Experience luxury with spacious design, bright interiors, and refined accents, offering a perfect blend of elegance and comfort.</p>
                <div class="btnText">Luxury Stay</div>
                <button class="book-now" onclick="bookRoom('The Majestic Hall')">Book Now</button>
            </td>
            <td class="RoomCell">
                <img src="./pictures/PSrecept.png" alt="Premium Stay Image">
                <div class="RoomName">The Elite Lounge</div>
                <p>Arrive in style at The Elite Lounge, where modern sophistication and comfort blend seamlessly, offering a space for both productivity and relaxation.</p>
                <div class="btnText">Premium Stay</div>
                <button class="book-now" onclick="bookRoom('The Elite Lounge')">Book Now</button>
            </td>
            <td class="RoomCell">
                <img src="./pictures/USbedroom.png" alt="Unique Stay Image">
                <div class="RoomName">The Tranquil Haven</div>
                <p>Immerse in serenity at The Tranquil Haven, where nature meets comfort. Soft tones, inviting textures, and soothing views create a peaceful retreat for the perfect escape.</p>
                <div class="btnText">Unique Stay</div>
                <button class="book-now" onclick="bookRoom('The Tranquil Haven')">Book Now</button>
            </td>
        </tr>

        <!-- Row 2 -->
        <tr>
            <td class="RoomCell">
                <img src="./pictures/USbalcon.png" alt="Unique Stay Balcony Image">
                <div class="RoomName">The Canopy Retreat</div>
                <p>Unwind in The Canopy Retreat, where comfort meets nature. Relax on your private balcony with lush greenery and peaceful vistas for a serene, nature-inspired escape.</p>
                <div class="btnText">Unique Stay</div>
                <button class="book-now" onclick="bookRoom('The Canopy Retreat')">Book Now</button>
            </td>
            <td class="RoomCell">
                <img src="./pictures/LSbedroom.png" alt="Luxury Stay Bedroom">
                <div class="RoomName">The Opal Suite</div>
                <p>Experience elegance in The Opal Suite, where spacious design, luxurious comfort, and soft tones create a tranquil sanctuary for restful luxury.</p>
                <div class="btnText">Luxury Stay</div>
                <button class="book-now" onclick="bookRoom('The Opal Suite')">Book Now</button>
            </td>
            <td class="RoomCell">
                <img src="./pictures/BHpool.png" alt="Business Stay Pool">
                <div class="RoomName">The Executive Oasis</div>
                <p>Relax at The Executive Oasis, where business meets leisure. This stylish pool area offers a refreshing escape, perfect for unwinding or networking.</p>
                <div class="btnText">Business Stay</div>
                <button class="book-now" onclick="bookRoom('The Executive Oasis')">Book Now</button>
            </td>
        </tr>

        <!-- Row 3 -->
        <tr>
            <td class="RoomCell">
                <img src="./pictures/PSbedroom.png" alt="Premium Stay Bedroom">
                <div class="RoomName">The Prestige Chamber</div>
                <p>Step into The Prestige Chamber, a refined bedroom with sophisticated design and premium furnishings, blending comfort and luxury for a tranquil retreat.</p>
                <div class="btnText">Premium Stay</div>
                <button class="book-now" onclick="bookRoom('The Prestige Chamber')">Book Now</button>
            </td>
            <td class="RoomCell">
                <img src="./pictures/BHbedroom.png" alt="Business Stay Bedroom">
                <div class="RoomName">The Corporate Suite</div>
                <p>The Corporate Suite blends comfort and productivity, offering a modern space with sleek furnishings and efficient workspaces for business travelers.</p>
                <div class="btnText">Business Stay</div>
                <button class="book-now" onclick="bookRoom('The Corporate Suite')">Book Now</button>
            </td>
        </tr>
    </table>

    <script>
        function bookRoom(roomName) {
            alert('You have selected ' + roomName + ' for booking!');
            // Replace this alert with actual booking logic or redirect to a booking page
        }
    </script>
</body>
</html>
