<?php
session_start();
include 'databaseConnection.php';

// Assuming you store the admin ID or username in session:
$adminUsername = $_SESSION['admin_username'] ?? null;
$adminImage = 'default-profile.png'; // fallback/default image

if ($adminUsername) {
    $query = "SELECT img_profile FROM Admin_Account WHERE username = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $adminUsername);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $imgPath);
    if (mysqli_stmt_fetch($stmt) && !empty($imgPath) && file_exists($imgPath)) {
        $adminImage = $imgPath;
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .wrapper {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 200px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }

        .sidebar .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar h5 {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar a {
            color: white;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #495057;
        }

        .content-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: rgb(19, 102, 185);
            color: white;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content {
            flex-grow: 1;
            position: relative;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .dropdown-menu {
            right: 0;
            left: auto;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
        </div>
        <div class="logo">
        <img src="../<?= $adminImage ?>" alt="Admin Profile" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
        </div>
        <h5>Hello Admin</h5>

        <a href="home.php">Home</a>
        <a href="room.php">Room</a>
        <a href="bookings.php">Bookings</a>
        <a href="index.php">Website</a>
        <a href="account.php">Accounts</a>
        <a href="settings.php">Settings</a>
    </div>

    <!-- Content Area -->
    <div class="content-area">

        <!-- Top Navbar -->
        <div class="topbar">
            <span class="h5 m-0">Dashboard</span>
            <div class="d-flex align-items-center">
                <a href="/" target="_blank" class="me-3 text-white text-decoration-none">Open the website</a>
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle text-white" id="adminDropdown" data-bs-toggle="dropdown">
                        Administrator
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content Placeholder (to be filled by home.php) -->
        <div class="main-content">
