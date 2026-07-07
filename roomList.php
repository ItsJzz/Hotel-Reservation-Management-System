<?php
include 'databaseConnection.php';

$category = $_GET['category'] ?? 'All';

$sql = ($category === 'All') 
    ? "SELECT * FROM hotel_rooms ORDER BY id DESC" 
    : "SELECT * FROM hotel_rooms WHERE category = ? ORDER BY id DESC";

$stmt = $conn->prepare($sql);
if ($category !== 'All') $stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0):
    while ($room = $result->fetch_assoc()):
?>
<div class="col-md-4 mb-4">
    <div class="card h-100">
        <img src="<?= '../' . htmlspecialchars($room['image_path']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Room Image">
        <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($room['name']) ?></h5>
            <p class="text-muted"><?= htmlspecialchars($room['category']) ?></p>
            <p class="card-text"><?= htmlspecialchars($room['description']) ?></p>
        </div>
    </div>
</div>
<?php endwhile; else: ?>
<p class="text-center w-100">No rooms found.</p>
<?php endif; ?>
