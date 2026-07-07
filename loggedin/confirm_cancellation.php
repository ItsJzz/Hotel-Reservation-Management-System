<?php
include("databaseConnection.php");

if (!isset($_GET['token'])) {
    die("Invalid access.");
}

$token = $_GET['token'];

// Check if token exists and is not expired
$stmt = $conn->prepare("SELECT * FROM cancellation_requests WHERE token = ? AND is_confirmed = 0 AND created_at >= (NOW() - INTERVAL 1 DAY)");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Invalid or expired cancellation link.");
}

$request = $result->fetch_assoc();
$reservationId = $request['reservation_id'];

// Cancel the reservation
$updateReservation = $conn->prepare("UPDATE reservations SET status = 'cancelled', updated_at = NOW() WHERE reservation_id = ?");
$updateReservation->bind_param("i", $reservationId);
$updateReservation->execute();

// Mark the cancellation request as confirmed
$markConfirmed = $conn->prepare("UPDATE cancellation_requests SET is_confirmed = 1 WHERE token = ?");
$markConfirmed->bind_param("s", $token);
$markConfirmed->execute();

echo "<h2 style='font-family: sans-serif; color: #2ecc71;'>✅ Your reservation has been successfully cancelled.</h2>";
?>
