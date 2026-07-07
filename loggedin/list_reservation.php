<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You need to log in first!";
    exit();
}

include('databaseConnection.php');

// Pagination setup
$limit = 6; // Show 6 reservations per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $limit;

$user_id = $_SESSION['user_id'];

// Count total reservations
$countQuery = "SELECT COUNT(*) AS total FROM reservations r 
               JOIN reservation_details d ON r.reservation_id = d.reservation_id 
               WHERE r.id = ? AND d.id = ? AND d.arrival_date != '0000-00-00'";
$countStmt = $conn->prepare($countQuery);
$countStmt->bind_param("ii", $user_id, $user_id);
$countStmt->execute();
$countResult = $countStmt->get_result();
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch paginated reservations
$sql = "SELECT d.reservation_id, r.name, r.status, d.arrival_date, d.guests
        FROM reservations r
        JOIN reservation_details d ON r.reservation_id = d.reservation_id
        WHERE r.id = ? AND d.id = ? AND d.arrival_date != '0000-00-00'
        ORDER BY d.arrival_date DESC
        LIMIT ?, ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiii", $user_id, $user_id, $offset, $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Reservations</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="./profile.css">

  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
    }
    .main-content {
      margin-left: 250px;
      padding: 30px;
      width: 100%;
    }
    h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 40px;
      color: #2c3e50;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 6px 20px rgba(0,0,0,0.08);
      transition: all 0.3s ease;
      position: relative;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }
    .reservation-status {
      padding: 5px 12px;
      border-radius: 50px;
      font-weight: bold;
      font-size: 0.85rem;
      display: inline-block;
    }
    .pending { background-color: #f39c12; color: white; }
    .confirmed { background-color: #2ecc71; color: white; }
    .cancelled { background-color: #e74c3c; color: white; }
    .btn-info { background-color: #3498db; border: none; }
    .btn-info:hover { background-color: #2980b9; }
    .no-reservations {
      text-align: center;
      margin-top: 60px;
      font-size: 1.2rem;
      color: #888;
    }
    .btn-danger {
      background-color: #dc3545;
      color: white;
      border: none;
    }
    .btn-danger:hover {
      background-color: #bd2130;
    }
    .view-details-hover {
      position: absolute;
      bottom: 15px;
      right: 15px;
      background-color: rgba(0, 0, 0, 0.75);
      color: #fff;
      padding: 6px 12px;
      border-radius: 5px;
      font-size: 0.9rem;
      opacity: 0;
      transition: opacity 0.3s ease;
    }
    .card:hover .view-details-hover {
      opacity: 1;
    }
    @media (max-width: 768px) {
      .main-content {
        margin-left: 0;
        padding: 20px;
      }
    }
  </style>
</head>

<body>

<?php include('sidebar.php'); ?>

<div class="main-content">
  <h2>Your Reservations</h2>

  <div class="row">
    <?php
    if ($stmt->execute()) {
      $result = $stmt->get_result();
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            switch ($row['status']) {
                case 'pending': $statusClass = 'pending'; break;
                case 'confirmed': $statusClass = 'confirmed'; break;
                case 'cancelled': $statusClass = 'cancelled'; break;
                default: $statusClass = '';
            }

            $formattedDate = date('F j, Y', strtotime($row['arrival_date']));
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card p-3">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p class="card-text">
                      <strong>Arrival:</strong> <?php echo $formattedDate; ?><br>
                      <strong>Guests:</strong> <?php echo $row['guests']; ?><br>
                      <span class="reservation-status <?php echo $statusClass; ?>">
                          <?php echo ucfirst($row['status']); ?>
                      </span>
                    </p>
                    <a href="cancel_reservation.php?id=<?php echo $row['reservation_id']; ?>" class="btn btn-danger ml-2" onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</a>
                    <div class="view-details-hover">View Details</div>
                </div>
            </div>
            <?php
        }

        if (isset($_GET['cancel']) && $_GET['cancel'] === 'success') {
            echo "<div class='alert alert-warning col-12'>Reservation has been cancelled.</div>";
        }
      } else {
        echo "<div class='col-12 no-reservations'>You don't have any upcoming reservations yet. 🌿</div>";
      }
    } else {
      echo "<div class='alert alert-danger col-12'>Error loading reservations.</div>";
    }
    ?>
  </div>

  <!-- Pagination -->
  <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center mt-4">
        <?php if ($page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
          </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?php echo ($i === $page) ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
