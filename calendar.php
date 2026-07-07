<?php
include('sidebar.php');
include('databaseConnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reservation Calendar</title>

  <!-- FullCalendar CSS and JS -->
  <link href="https://unpkg.com/@fullcalendar/daygrid@6.1.8/main.min.css" rel="stylesheet">
  <script src="https://unpkg.com/@fullcalendar/core@6.1.8/index.global.min.js"></script>
  <script src="https://unpkg.com/@fullcalendar/daygrid@6.1.8/index.global.min.js"></script>

  <style>
    * {
      box-sizing: border-box;
    }

    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      font-family: Arial, Helvetica, sans-serif;
    }

    .contents {
      margin-left: 250px; /* width of your sidebar */
      height: 100vh;
      padding: 20px;
      background-color: #f8f9fa;
      overflow-y: auto;
    }

    #calendar {
      height: calc(100vh - 40px); /* full height minus padding */
    }

    .fc-event-title {
      display: none !important;
    }
  </style>
</head>
<body>

<div class="contents">
  <div id="calendar"></div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    <?php
    $sql = "SELECT r.status, d.arrival_date FROM `reservations` r 
            JOIN `reservation_details` d ON r.id = d.reservation_id";
    $result = $conn->query($sql);

    $events = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $status = $row['status'];
            $arrival_date = $row['arrival_date'];
            $event = [
                'title' => '',
                'start' => $arrival_date,
                'status' => $status,
                'backgroundColor' => ($status == 'pending') ? '#FF5733' : '#4CAF50',
                'borderColor' => ($status == 'pending') ? '#FF5733' : '#4CAF50',
                'textColor' => '#ffffff'
            ];
            $events[] = $event;
        }
    }

    echo "var eventsData = " . json_encode($events) . ";";
    ?>

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: eventsData
    });

    calendar.render();
  });
</script>

</body>
</html>
