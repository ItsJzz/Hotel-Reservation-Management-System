<?php
session_start();
include('databaseConnection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit();
}
echo "Reservation ID: " . $reservation_id . "<br>";
echo "User ID: " . $user_id . "<br>";

$user_id = $_SESSION['user_id'];
$reservation_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Update reservation status to 'cancelled'
$sql = "UPDATE reservations SET status = 'cancelled' WHERE reservation_id = ? AND id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $reservation_id, $user_id);


if ($stmt->execute()) {
    // Optional: send cancellation email here
    header("Location:list_reservation.php?cancel=success");
    exit();
} else {
    echo "Error cancelling reservation.";
}
?>
