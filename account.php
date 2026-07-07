<?php
// Enable error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
ini_set('display_errors', 1);

include 'databaseConnection.php';
include 'dashboard.php'; // Keep the dashboard layout

// Handle actions securely with prepared statements
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $action = $_GET['action'];

    $status = null;
    switch ($action) {
        case 'block':
            $status = 'blocked';
            break;
        case 'unblock':
            $status = 'active';
            break;
        case 'delete':
            $status = 'deleted';
            break;
    }

    if ($status !== null) {
        $stmt = $conn->prepare("UPDATE login_credentials SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
        $stmt->close();
        header("Location:account.php");
        exit;
    }
}

// Fetch all users that are not deleted
$result = $conn->query("SELECT * FROM login_credentials WHERE status != 'deleted'");
?>

<div class="main-content container mt-4">
    <h2>User Account Management</h2>
    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th scope="col">Profile</th>
                <th scope="col">Full Name</th>
                <th scope="col">Email</th>
                <th scope="col">Status</th>
                <th scope="col" style="width: 240px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <?php
                            $imagePath = $row['profile_pictures']; // e.g., ./pictures/image.png

                            // Resolve real file system path
                            $fileCheckPath = realpath(__DIR__ . '/../' . ltrim($imagePath, './'));

                            // Create browser-compatible path
                            $browserPath = '../' . ltrim($imagePath, './');

                            if (!empty($imagePath) && file_exists($fileCheckPath)):
                        ?>
                            <img src="<?= $browserPath ?>" alt="Profile" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['firstName'] . ' ' . $row['lastName']) ?></td>
                    <td><?= htmlspecialchars($row['emailAddress']) ?></td>
                    <td>
                        <span class="badge bg-<?= $row['status'] === 'active' ? 'success' : 'warning' ?>">
                            <?= ucfirst($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] === 'active'): ?>
                            <a href="account.php?action=block&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Block</a>
                        <?php elseif ($row['status'] === 'blocked'): ?>
                            <a href="account.php?action=unblock&id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Unblock</a>
                        <?php endif; ?>
                        <a href="account.php?action=delete&id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this account?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
