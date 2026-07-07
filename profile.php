<?php
session_start();
include("databaseConnection.php");
include("sidebar.php");

// Load profile picture
$profilePicture = "./pictures/default-profile.png";
if (isset($_SESSION['Avatar']) && !empty($_SESSION['Avatar'])) {
    $profilePicture = $_SESSION['Avatar'];
}

// Upload profile picture
if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $newFileName = time() . "_" . basename($imageName);
    $targetPath = "./pictures/" . $newFileName;

    if (move_uploaded_file($imageTmp, $targetPath)) {
        $email = $_SESSION['emailAddress'];
        $update = $conn->prepare("UPDATE login_credentials SET profile_pictures = ? WHERE emailAddress = ?");
        $update->bind_param("ss", $targetPath, $email);
        $update->execute();
        $_SESSION['Avatar'] = $targetPath;
        $profilePicture = $targetPath;
        echo "<script>alert('Profile picture updated successfully!'); location.href='profile.php';</script>";
    } else {
        echo "<script>alert('Failed to upload the image.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>

    <link rel="stylesheet" href="./profile.css">

    <!-- FullCalendar Scripts (correct version) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/5.11.0/main.min.css" rel="stylesheet">

    <style>
      #calendar-container {
        max-width: 1100px;
        margin: 40px auto;
        background: white;
        min-height: 500px;
        border: 1px solid #ccc;
      }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        let calendar;

        function initializeCalendar() {
            try {
                const calendarEl = document.getElementById('calendar-container');
                if (!calendarEl) {
                    console.error("Calendar container not found!");
                    return;
                }

                console.log("Initializing FullCalendar...");
                calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: ['dayGrid'], // Ensure the dayGrid plugin is included
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: ''
                    },
                    events: [],
                    eventColor: '#378006',
                });

                console.log("Rendering calendar...");
                calendar.render();  // Ensure it's rendered right after initialization
            } catch (error) {
                console.error("Error initializing FullCalendar: ", error);
            }
        }

        window.showSection = function (sectionId) {
            const sections = document.querySelectorAll(".section");
            sections.forEach(section => section.style.display = "none");

            const selected = document.getElementById(sectionId);
            if (selected) {
                selected.style.display = "block";

                if (sectionId === 'calendar' && !calendar) {
                    initializeCalendar(); // Initialize the calendar only when it's needed
                }
            }
        };

        // Initially hide calendar if not needed
        showSection('account');
    });
    </script>
</head>

<body>


<div class="contents">

        <!-- Account Section -->
    <div class="section" id="account">
        <h3>👤 Account Settings</h3>
        <div class="account-settings">
            <div class="profile-container">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                    <div class="image-container">
                        <img src="<?php echo $profilePicture; ?>" alt="Profile Picture"><br><br>
                        <input type="file" name="image" id="image"><br><br>
                        <input type="submit" name="submit" value="Upload Image" class="upload-image">
                    </div>
                    <div class="info">
                        <label>First Name:</label>
                        <input type="text" name="firstName" value="<?php echo $_SESSION['firstName']; ?>" disabled>

                        <label>Last Name:</label>
                        <input type="text" name="lastName" value="<?php echo $_SESSION['lastName']; ?>" disabled>

                        <label>Email Address:</label>
                        <input type="text" name="emailAddress" value="<?php echo $_SESSION['emailAddress']; ?>" disabled>

                        <input type="submit" value="Save" name="save" class="save-button">
                        <input type="button" value="Edit" name="edit" class="edit-button" onclick="editButton()">
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Change Password Section -->
    <div class="section" id="password" style="display:none;">
        <h3>🔒 Change Password</h3>
        <form action="changePassword.php" method="post">
            <label>Old Password:</label><br>
            <input type="password" name="old_password" required><br><br>
            <label>New Password:</label><br>
            <input type="password" name="new_password" required><br><br>
            <input type="submit" value="Update Password">
        </form>
    </div>

    <!-- Reservation Section -->
    <div class="section" id="reservations" style="display:none;">
        <h3>📅 My Reservations</h3>
        <p>[✔] Show reservation list here (to be implemented)</p>
        <p>[✔] Option to cancel / pay down payment</p>
        <p>[✔] Request food or beverages per reservation</p>
        <p>[✉] Email will notify for reservation and cancellation status</p>
    </div>

    <!-- Calendar Section -->
    <div class="section" id="calendar" style="display:none;">
        <h3>🗓 Calendar View</h3>
        <div id="calendar-container"></div>
    </div>

</div>

</body>
</html>
