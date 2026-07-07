<?php
    include("databaseConnection.php");
?>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./bookss.css">
</head>
<body>
    <form action="" method="POST">
    <div class="container">
        <div class="back-button">
            <a href="products.php"><button class="back-btn"></a>            
            <i class="fas fa-arrow-left"></i> <!-- FontAwesome back arrow icon -->
            </button>
        </div>
        <div>
            <img src="./pictures/bookingPic.png" alt="">
        </div>
        <center>
            <h1>Hotel Booking</h1>
            <p>Experience something new every moment</p>
        </center>
        <div class="container-table">
            <table>
                <tr>
                    <td><h2>Name</h2></td>
                </tr>
                <tr>
                    <td><input type="text" name="firstName"></td>
                    <td><input type="text" name="lastName"></td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td>Last Name</td>
                </tr>
                <tr>
                    <td><h2>Room Type</h2></td>
                </tr>
                <tr>
                    <td colspan="2"><select id="roomType" name="roomType">
                        <option value="" disabled selected>Please Select</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td><h2>Arrival Date & Time</h2></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="date" name="arrivalDate"></td>
                    <td><input type="text" name="arrivalTime"></td>
                    <td><select name="arrivalPeriod" id="arrivalPeriod">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select></td>
                </tr>
                <tr>
                    <td colspan="2">Date</td>
                    <td>Hour Minutes</td>
                </tr>
            </table>
            <table class="container-table2">
                <tr>
                    <td><h2>Departure Date</h2></td>
                </tr>
                <tr>
                    <td><select name="departureMonth" class="Month">
                    <option value="" disabled selected>Please select a month</option>
                    </select></td>
                    <td><select name="departureDay" class="Day">
                    <option value="" disabled selected>Please select a day</option>
                    </select></td>
                    <td><select name="departureYear" class="Year">
                    <option value="" disabled selected>Please select a year</option>
                    </select></td>
                </tr>
                <tr>
                    <td>Month</td>
                    <td>Day</td>
                    <td>Year</td>
                </tr>
                <tr>
                    <td><h2>Food Request</h2></td>
                </tr>
            </table>
            <div class="container-table3">
                <table>
                    <tr>
                        <td><h2>E-mail</h2></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="email"></td>
                    </tr>
                    <tr>
                        <td>Example@gmail.com</td>
                    </tr>
                    <tr>
                        <td><h2>Number of Guests</h2></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="guests" class="text"></td>
                    </tr>
                </table>
            </div>
            <td><textarea id="FoodRequest" name="foodRequest" rows="10" cols="125"></textarea>
        </div>

        <!-- Submit Button -->
        <div class="submit-container">
            <input type="submit" value="Book Now" class="submit-btn">
        </div>

    </div>
    </form>
</body>
