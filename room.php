<?php
include 'dashboard.php';
include 'databaseConnection.php';

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    if (!empty($_POST['room_ids'])) {
        $idsToDelete = implode(",", array_map('intval', $_POST['room_ids']));
        $deleteQuery = "DELETE FROM hotel_rooms WHERE id IN ($idsToDelete)";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<p style='color: green; text-align:center;'>Selected room(s) deleted successfully!</p>";
        } else {
            echo "<p style='color: red; text-align:center;'>Error deleting room(s): " . mysqli_error($conn) . "</p>";
        }
    } else {
        echo "<p style='color: orange; text-align:center;'>No rooms selected for deletion.</p>";
    }
}
?>

<!-- Floating Panel for Room Management -->
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

    <!-- Minimalist Navigation Buttons -->
    <div class="d-flex justify-content-center gap-3 mb-4" style="flex-wrap: wrap;">
        <button onclick="showCreateForm()" class="btn btn-outline-dark px-4 py-2 d-flex align-items-center gap-2 shadow-sm rounded-3">
            <i class="bi bi-plus-circle"></i> Create
        </button>
        <button onclick="showRoomDisplay()" class="btn btn-outline-dark px-4 py-2 d-flex align-items-center gap-2 shadow-sm rounded-3">
            <i class="bi bi-house-door"></i> Rooms
        </button>
        <button onclick="showUpdateForm()" class="btn btn-outline-dark px-4 py-2 d-flex align-items-center gap-2 shadow-sm rounded-3">
            <i class="bi bi-pencil-square"></i> Update
        </button>
        <button onclick="showDeleteForm()" class="btn btn-outline-dark px-4 py-2 d-flex align-items-center gap-2 shadow-sm rounded-3">
            <i class="bi bi-trash3"></i> Delete
        </button>
    </div>


    <!-- Filter Section -->
    <div id="filterSection" class="mb-4" style="padding: 15px;">
        <h5 class="d-flex align-items-center">
            <i class="bi bi-funnel-fill" style="font-size: 1.5rem; margin-right: 10px;"></i> Filter
        </h5>
        <div class="d-flex gap-2">
            <button onclick="filterRooms('all')" class="btn btn-outline-info w-20">All</button>
            <button onclick="filterRooms('Luxury Stay')" class="btn btn-outline-info w-20">Luxury Stay</button>
            <button onclick="filterRooms('Unique Stay')" class="btn btn-outline-info w-20">Unique Stay</button>
            <button onclick="filterRooms('Business Stay')" class="btn btn-outline-info w-20">Business Stay</button>
            <button onclick="filterRooms('Premium Stay')" class="btn btn-outline-info w-20">Premium Stay</button>
        </div>
    </div>

    <!-- Room Display Section -->
    <div id="roomDisplay">
        <h4>All Rooms</h4>
        <div class="row" id="roomCards">
            <?php
            $sql = "SELECT * FROM hotel_rooms ORDER BY id DESC";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0):
                while ($room = $result->fetch_assoc()):
            ?>
            <div class="col-md-4 mb-4 room-card" data-category="<?= htmlspecialchars($room['category']) ?>">
                <div class="card h-100">
                    <img src="<?= '../' . htmlspecialchars($room['image_path']) ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Room Image">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($room['name']) ?></h5>
                        <p class="text-muted mb-1"><?= htmlspecialchars($room['category']) ?></p>
                        <p class="card-text"><?= htmlspecialchars($room['description']) ?></p>
                    </div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div class="col-12">
                <p class="text-center">No rooms found.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Create Room Form Container -->
    <div id="createRoomForm" style="display:none; padding: 20px;">
        <h2>Add a New Room</h2>
        <form action="uploadRoom.php" method="post" enctype="multipart/form-data">
            <label>Room Name:</label><br>
            <input type="text" name="name" required><br><br>

            <label>Description:</label><br>
            <textarea name="description" rows="4" cols="50" required></textarea><br><br>

            <label>Category:</label><br>
            <select name="category" required>
                <option value="Luxury Stay">Luxury Stay</option>
                <option value="Unique Stay">Unique Stay</option>
                <option value="Business Stay">Business Stay</option>
                <option value="Premium Stay">Premium Stay</option>
            </select><br><br>

            <label>Upload Image:</label><br>
            <input type="file" name="image" accept="image/*" required><br><br>

            <input type="submit" name="submit" value="Add Room">
        </form>
    </div>

    <!-- Update Form Container -->
    <div id="updateForm" style="display:none; padding: 20px;"></div>

    <!-- Delete Room Form -->
    <div id="deleteForm" style="display:none;">
        <form method="POST">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)"></th>
                        <th>Room Name</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Image</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rooms = mysqli_query($conn, "SELECT * FROM hotel_rooms");
                    while ($row = mysqli_fetch_assoc($rooms)):
                    ?>
                    <tr>
                        <td><input type="checkbox" name="room_ids[]" value="<?= $row['id'] ?>"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['description']) ?></td>
                        <td>
                            <?php if (!empty($row['image_path']) && file_exists('../' . $row['image_path'])): ?>
                                <img src="<?= '../' . $row['image_path'] ?>" width="100" alt="Room Image">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <div style="text-align: center;">
                <input type="submit" name="delete" value="Delete Selected Rooms" class="btn btn-danger">
            </div>
        </form>
    </div>

</div>

<script>
// Toggle display for Create, Update, Room, and Delete
function hideAllSections() {
    document.getElementById('roomDisplay').style.display = 'none';
    document.getElementById('createRoomForm').style.display = 'none';
    document.getElementById('updateForm').style.display = 'none';
    document.getElementById('deleteForm').style.display = 'none';
    document.getElementById('filterSection').style.display = 'none';
}

function showCreateForm() {
    hideAllSections();
    document.getElementById('createRoomForm').style.display = 'block';
}

function showUpdateForm() {
    hideAllSections();
    document.getElementById('updateForm').style.display = 'block';
    fetch('updateRoom.php')
        .then(response => response.text())
        .then(html => {
            document.getElementById('updateForm').innerHTML = html;
        })
        .catch(err => {
            document.getElementById('updateForm').innerHTML = '<div class="alert alert-danger">Error loading update form.</div>';
        });
}

function showDeleteForm() {
    hideAllSections();
    document.getElementById('deleteForm').style.display = 'block';
}

function showRoomDisplay() {
    hideAllSections();
    document.getElementById('roomDisplay').style.display = 'block';
    document.getElementById('filterSection').style.display = 'block';
}

// Filter rooms by category
function filterRooms(category) {
    let rooms = document.querySelectorAll('.room-card');
    if (category === 'all') {
        rooms.forEach(room => room.style.display = 'block');
    } else {
        rooms.forEach(room => {
            room.style.display = room.getAttribute('data-category') === category ? 'block' : 'none';
        });
    }
}

// Select All checkbox
function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('input[name="room_ids[]"]');
    checkboxes.forEach(checkbox => checkbox.checked = source.checked);
}
</script>
