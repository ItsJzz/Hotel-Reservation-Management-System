<?php
// Add these at the very top
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\Exception.php';
require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\finalProject\PHPMailer\PHPMailer\src\SMTP.php';

include("databaseConnection.php");
session_start();

$selectedRoomType = isset($_GET['roomType']) ? $_GET['roomType'] : '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = $_POST['firstName'] ?? '';
    $lastName = $_POST['lastName'] ?? '';
    $name = trim($firstName . ' ' . $lastName);

    $roomType = $_GET['roomType'] ?? '';

    $arrivalDate = $_POST['arrivalDate'] ?? '';
    $arrivalTime = $_POST['arrivalTime'] ?? '';
    $arrivalPeriod = $_POST['arrivalPeriod'] ?? '';
    $arrivalTimeFormatted = $arrivalTime . ' ' . $arrivalPeriod;

    $departureMonth = $_POST['departureMonth'] ?? '';
    $departureDay = $_POST['departureDay'] ?? '';
    $departureYear = $_POST['departureYear'] ?? '';
    $departureDate = "$departureYear-$departureMonth-$departureDay";

    $email = $_POST['email'] ?? '';
    $guests = $_POST['guests'] ?? '';
    $foodRequest = $_POST['foodRequest'] ?? '';

    $userId = $_SESSION['user_id'] ?? null;
    $_SESSION['booking_email'] = $email;

    if (!$userId) {
        echo "<script>alert('User is not logged in. Please log in first.'); window.location.href='login.php';</script>";
        exit();
    }

    $errors = [];

    if (empty($arrivalDate)) {
        $errors[] = "Arrival date is required.";
    }
    if (empty($arrivalTime)) {
        $errors[] = "Arrival time is required.";
    }
    if (empty($departureMonth) || empty($departureDay) || empty($departureYear)) {
        $errors[] = "Complete departure date (month, day, and year) is required.";
    }
    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (empty($guests)) {
        $errors[] = "Number of guests is required.";
    } elseif (!is_numeric($guests) || $guests <= 0) {
        $errors[] = "Number of guests must be a positive number.";
    }
    if (empty(trim($foodRequest))) {
        $errors[] = "Food request is required.";
    }

    if (!empty($errors)) {
        $allErrors = implode("\\n", $errors);
        echo "<script>alert('$allErrors');</script>";
        exit();
    }

    $status = 'pending';
    $currentTimestamp = date('Y-m-d H:i:s');

    $stmt1 = $conn->prepare("INSERT INTO reservations (id, name, room_type, status, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt1->bind_param("isssss", $userId, $name, $roomType, $status, $currentTimestamp, $currentTimestamp);
    $stmt1->execute();

    $reservation_id = $conn->insert_id;

    $stmt2 = $conn->prepare("INSERT INTO reservation_details (reservation_id, arrival_date, arrival_time, departure_date, guests, food_request, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt2->bind_param("isssisss", $reservation_id, $arrivalDate, $arrivalTimeFormatted, $departureDate, $guests, $foodRequest, $currentTimestamp, $currentTimestamp);
    $stmt2->execute();

    $stmt1->close();
    $stmt2->close();
    $conn->close();

    // 📧 Send confirmation email
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'theresthavens@gmail.com'; // your sender email
    $mail->Password   = 'jqbb tetu xcwv nqso'; // app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('theresthavens@gmail.com', 'Big Brew Pinagbarilan');
    $mail->addAddress($email, $name);

    $mail->isHTML(true);
    $mail->Subject = 'Reservation Confirmation - Big Brew Pinagbarilan';
    $mail->Body    = "
        <h3>Your Reservation is Confirmed!</h3>
        <p>Dear <strong>$name</strong>,</p>
        <p>Thank you for choosing Big Brew Pinagbarilan! We are happy to confirm your reservation. Here are the details:</p>
        <ul>
            <li><strong>Room Type:</strong> $roomType</li>
            <li><strong>Arrival Date:</strong> $arrivalDate at $arrivalTimeFormatted</li>
            <li><strong>Departure Date:</strong> $departureDate</li>
            <li><strong>Guests:</strong> $guests</li>
            <li><strong>Food Request:</strong> $foodRequest</li>
        </ul>
        <p><strong>What’s next?</strong></p>
        <p>If you need to modify or cancel your reservation, please visit our website or contact us directly. Our team will be happy to assist you.</p>
        <p><strong>Need Help?</strong></p>
        <p>If you have any questions or need assistance, feel free to reach out to us at <strong>support@bigbrew.com</strong> or call our support line at <strong>+123456789</strong>.</p>
        <p>We look forward to welcoming you!</p>
        <p>Best regards, <br> The Big Brew Pinagbarilan Team</p>
    ";
    $mail->AltBody = "Reservation confirmed for $arrivalDate - $departureDate. Guests: $guests. Room: $roomType.";

    $mail->send();
} catch (Exception $e) {
    error_log("Email error: {$mail->ErrorInfo}");
}


    echo "<script>alert('Reservation successful!'); window.location.href='products.php';</script>";
}
?>



<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./bookss.css">
</head>
<body>
    <form action="" method="POST">
        <div class="container">
            
        <div class="image-wrapper">
            <div class="back-button">
                <a href="products.php" class="back-btn">
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
            <img src="../pictures/bookingPic.png" alt="">
        </div>

            <center>
                <h1>Hotel Booking</h1>
                <p>Experience something new every moment</p>
            </center>

    <form action="your-handler.php" method="POST"> <!-- Wrap form elements in a proper <form> -->
        <!-- Name -->
        <div class="form-row">
            <label for="firstName">Name</label>
            <input type="text" name="firstName" placeholder="First Name" required>
            <input type="text" name="lastName" placeholder="Last Name (Optional)">
        </div>

        <!-- Room Type -->
        <div class="form-row full-width">
            <label for="roomType">Room Type</label>
            <select id="roomType" name="roomType" disabled>
                <option value="" disabled <?= $selectedRoomType == '' ? 'selected' : '' ?>>Please Select</option>
                <option value="Unique Stay" <?= $selectedRoomType == 'Unique Stay' ? 'selected' : '' ?>>Unique Stay</option>
                <option value="Premium Stay" <?= $selectedRoomType == 'Premium Stay' ? 'selected' : '' ?>>Premium Stay</option>
                <option value="Luxury Stay" <?= $selectedRoomType == 'Luxury Stay' ? 'selected' : '' ?>>Luxury Stay</option>
                <option value="Business Stay" <?= $selectedRoomType == 'Business Stay' ? 'selected' : '' ?>>Business Stay</option>
            </select>
        </div>

        <!-- Arrival Date & Time -->
        <div class="form-row full-width">
            <label>Arrival Date & Time</label>
            <input type="date" name="arrivalDate" required>
            <input type="text" name="arrivalTime" placeholder="hh:mm" required>
            <select name="arrivalPeriod" id="arrivalPeriod" required>
                <option value="AM">AM</option>
                <option value="PM">PM</option>
            </select>
        </div>

        <!-- Departure Date -->
        <div class="form-row full-width">
            <label>Departure Date</label>
            <select name="departureMonth" required>
                <option value="" disabled selected>Month</option>
                <option value="01">January</option><option value="02">February</option>
                <option value="03">March</option><option value="04">April</option>
                <option value="05">May</option><option value="06">June</option>
                <option value="07">July</option><option value="08">August</option>
                <option value="09">September</option><option value="10">October</option>
                <option value="11">November</option><option value="12">December</option>
            </select>
            <select name="departureDay" required>
                <option value="" disabled selected>Day</option>
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>"><?= $i ?></option>
                <?php endfor; ?>
            </select>
            <select name="departureYear" required>
                <option value="" disabled selected>Year</option>
                <option value="2025">2025</option><option value="2026">2026</option>
                <option value="2027">2027</option><option value="2028">2028</option>
            </select>
        </div>

        <!-- Email and Number of Guests -->
        <div class="form-row">
            <label for="email">E-mail</label>
            <input type="email" name="email" placeholder="example@gmail.com" required>
            <input type="number" name="guests" placeholder="Number of Guests" min="1" required>
        </div>

        <!-- Food Request -->
        <div class="form-row full-width">
            <label for="FoodRequest">Food Request</label>
            <textarea id="FoodRequest" name="foodRequest" rows="5" cols="5" required></textarea>
        </div>

        <!-- Submit Button -->
        <div class="submit-container">
            <input type="submit" value="Book Now" class="submit-btn">
        </div>
    </form>
</div>

    </form>
</body>
