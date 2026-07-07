<?php
include 'dashboard.php';
include 'databaseConnection.php'; // Make sure this contains your DB connection

// Fetch dashboard data
$totalBookings = $conn->query("SELECT COUNT(*) AS total FROM reservations")->fetch_assoc()['total'];
$pendingBookings = $conn->query("SELECT COUNT(*) AS pending FROM reservations WHERE status = 'pending'")->fetch_assoc()['pending'];
$totalUsers = $conn->query("SELECT COUNT(*) AS users FROM login_credentials")->fetch_assoc()['users']; // Make sure 'users' table exists
?>

<!-- Floating Panel -->
<div style="
    position: absolute;
    top: 5px;
    left: 5px;
    right: 5px;
    bottom: 0;
    background: white;
    z-index: 10;
    box-shadow: 0 0 20px rgba(0,0,0,0.15);
    padding: 30px;
    border-radius: 10px;
    overflow-y: auto;
">
    <h2 class="mb-4">Hotel Room Booking Management System</h2>

    <div class="row g-4">
        <?php
        $cards = [
            ["title" => "Total Bookings", "count" => $totalBookings, "color" => "#007bff", "icon" => "bi-journal-check"],
            ["title" => "Available Rooms", "count" => 8, "color" => "#28a745", "icon" => "bi-door-open-fill"],
            ["title" => "Pending Approvals", "count" => $pendingBookings, "color" => "#ffc107", "icon" => "bi-hourglass-split"],
            ["title" => "Users", "count" => $totalUsers, "color" => "#6f42c1", "icon" => "bi-people-fill"],
        ];

        foreach ($cards as $card): ?>
            <div class="col-md-3">
                <div class="d-flex flex-column justify-content-between h-100 rounded shadow-sm text-white" style="background-color: <?= $card['color'] ?>; padding: 20px;">
                    <div>
                        <h5><?= $card['title'] ?></h5>
                        <p class="mb-4"><?= $card['count'] ?></p>
                    </div>
                    <a href="#" class="btn btn-sm text-white mt-auto" style="background-color: rgba(0,0,0,0.3); width: 100%;">
                        <i class="bi <?= $card['icon'] ?> me-1"></i> More info
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
