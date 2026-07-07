<?php
include 'dashboard.php';
include 'databaseConnection.php';
?>

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

    <h2 class="mb-4 text-center"><i class="bi bi-journal-bookmark"></i> Booking Records</h2>

    <table class="table table-hover table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                <th>Reservation ID</th>
                <th>User ID</th>
                <th>Guest Name</th>
                <th>Room Type</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM reservations ORDER BY created_at DESC";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)):
            ?>
                <tr>
                    <td class="text-center"><?= htmlspecialchars($row['reservation_id']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['name']) ?: '<span class="text-muted">N/A</span>' ?></td>
                    <td><?= htmlspecialchars($row['room_type']) ?></td>
                    <td>
                        <?php
                        $status = $row['status'];
                        $badgeColor = match($status) {
                            'pending' => 'warning',
                            'confirmed' => 'success',
                            'cancelled' => 'danger',
                            default => 'secondary'
                        };
                        ?>
                        <span class="badge bg-<?= $badgeColor ?>"><?= ucfirst($status) ?></span>
                    </td>
                    <td class="text-center"><?= htmlspecialchars($row['created_at']) ?></td>
                    <td class="text-center"><?= htmlspecialchars($row['updated_at']) ?></td>
                </tr>
            <?php
                endwhile;
            else:
            ?>
                <tr>
                    <td colspan="7" class="text-center text-muted">No bookings found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
