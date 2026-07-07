<?php
include("databaseConnection.php");
session_start();

// Get the user's ID (optional if you want only user's reservations)
$userEmail = $_SESSION['emailAddress'];

// Fetch reservations from reservation_details
$query = "SELECT arrival_date, arrival_time, departure_date, guests FROM reservation_details
          JOIN reservations ON reservation_details.reservation_id = reservations.reservation_id
          JOIN login_credentials ON reservations.user_id = login_credentials.user_id
          WHERE login_credentials.emailAddress = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

$events = [];

while ($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['guests'] . " Guests",
        'start' => $row['arrival_date'],
        'end' => $row['departure_date'],
        'description' => $row['arrival_time'],
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
