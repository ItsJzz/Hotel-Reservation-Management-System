<?php
// You can include your profile.css here if needed for styles
echo '<link rel="stylesheet" href="./profile.css">';
?>

<div class="navigation">
    <div class="logo" onclick="window.location.href='index.php'" style="text-align: center; padding: 20px;">
        <img src="../pictures/logo2.png" alt="BigBrew Logo" style="width: 100px; cursor: pointer;">
    </div>
    <a href="profile.php" onclick="window.location.href='profile.php'">👤 Account Settings</a>
    <a href="change_password.php" onclick="window.location.href='change_password.php'">🔒 Change Password</a>
    <a href="list_reservation.php" onclick="window.location.href='list_reservation.php'">📅 Reservations</a>
    <a href="calendar.php" onclick="window.location.href='calendar.php'">🗓 Calendar</a>
    <button class="back-button" onclick="history.back()">← Back</button>
</div>
