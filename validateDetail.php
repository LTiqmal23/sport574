<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: login.php");
    exit();
}

// session
$sessionID = $_SESSION['ID'];

// fetch from previous page
$preSport = $_POST['sport'];
$preDate = $_POST['bookdate'];
$preTimeSlot = $_POST['timeslot'];
$preSportName = '';

// selecting SPORTNAME
include "config.php";
$sqlSportName = "select SPORTNAME FROM SPORT WHERE SPORTID = ?";
$stmt = $conn->prepare($sqlSportName);
$stmt->bind_param("i", $preSport);
$stmt->execute();
$resultSportName = $stmt->get_result();

if ($resultSportName->num_rows > 0) {
    $row = $resultSportName->fetch_assoc();
    $preSportName = $row['SPORTNAME'];
} else {
    echo "<script>alert('No options available');</script>";
}

// selecting user info
$sqlSportName = "select * FROM CUSTOMER WHERE CUSTID = ?";
$stmt = $conn->prepare($sqlSportName);
$stmt->bind_param("i", $sessionID);
$stmt->execute();
$resultSportName = $stmt->get_result();

if ($resultSportName->num_rows > 0) {
    $row = $resultSportName->fetch_assoc();
    $preCustName = $row['CUSTNAME'];
    $preCustAddress = $row['CUSTADDRESS'];
    $preCustPhone = $row['CUSTPHONE'];
} else {
    echo "<script>alert('No options available');</script>";
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        .check-container {
            background-color: #fff;
            width: 80%;
            margin: 20px auto;
            border-radius: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .check-header {
            padding: 15px;
        }

        .check-header h1 {
            display: inline-block;
            position: relative;
            font-family: 'Poppins';
            font-weight: 600;
        }

        .check-header h1::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: #1A307F;
            border-radius: 3px;
        }

        .input-box input,
        .input-box select {
            background-color: #d9d9d9;
            border: none;
            outline: none;
            border-radius: 30px;
            font-size: 16px;
            color: #000000;
            padding: 10px 45px 10px 20px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                SPORTFUSION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="checkTime.php">Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="check-container">
        <div class="check-header">
            <h1>Validate Booking</h1>
        </div>

        <div class="check-wrapper">
            <form class="row g-3" action="addOn.php" method="POST">
                <div class="col-md-6 input-box">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" value="<?php echo $preCustName; ?>" readonly>
                </div>
                <div class="col-md-6 input-box">
                    <label for="phonenumber" class="form-label">Phone Number</label>
                    <input type="text" class="form-control" id="phonenumber" value="<?php echo $preCustPhone; ?>" readonly>
                </div>
                <div class="col-12 input-box">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="UiTM Kuala Terengganu" value="<?php echo $preCustAddress; ?>" readonly>
                </div>
                <div class="col-md-6 input-box">

                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo $preCustPhone; ?>" placeholder="Enter your phone number">
                </div>
                <div class="col-md-6 input-box">
                    <label for="court" class="form-label">Court</label>
                    <select id="court" name="court" class="form-control" required>
                        <option>Select an option</option>
                        <?php
                        // Prepare the SQL query to fetch court details based on selected sport, date, and timeslot
                        $stmt = $conn->prepare("
                    SELECT f.FACID 
                    FROM facility f 
                    LEFT JOIN booking b 
                    ON f.FACID = b.FACID 
                    AND b.BOOKINGDATE = ? 
                    AND b.TIMESLOT = ?
                    WHERE f.SPORTID = ? 
                    AND b.FACID IS NULL
                ");

                        // Bind parameters
                        $stmt->bind_param("sss", $preDate, $preTimeSlot, $preSport);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Fetch available courts and display
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['FACID'] . "'>" . $row['FACID'] . "</option>";
                            }
                        } else {
                            echo "<option value=''>No options available</option>";
                            echo "<script>alert('No courts available');</script>";
                            echo "<script>window.location.href='checkTime.php';</script>";
                            exit();
                        }

                        // Close the statement and connection
                        $stmt->close();
                        ?>
                    </select>
                </div>


                <!-- time details -->
                <div class="col-md-4 input-box">
                    <label for="bookingdate" class="form-label">Booking Date</label>
                    <input type="text" class="form-control" id="bookingdate" name="bookingdate" value="<?php echo $preDate; ?>" readonly>
                </div>
                <div class="col-md-4 input-box">
                    <label for="timeslot" class="form-label">Time Slot</label>
                    <input type="text" class="form-control" id="timeslot" name="timeslot" value="<?php echo $preTimeSlot; ?>" readonly>
                </div>

                <div class="col-md-4 input-box">
                    <label for="hoursbooked" class="form-label">Hours Booked</label>
                    <input type="text" class="form-control" id="hoursbooked" name="hoursbooked" readonly>
                </div>


                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-primary">Go to Add-On</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function calculateHoursBooked(timeslot) {
            // Remove the 'H' character and split the timeslot into start and end times
            const times = timeslot.replace(/H/g, '').split('-');
            const startTime = times[0];
            const endTime = times[1];

            // Parse hours and minutes from the start and end times
            const startHours = parseInt(startTime.substring(0, 2));
            const endHours = parseInt(endTime.substring(0, 2));

            // Calculate the difference in hours
            const hoursBooked = endHours - startHours;

            return hoursBooked;
        }

        // Function to set the hours booked value
        function setHoursBooked() {
            const timeslot = document.getElementById('timeslot').value;
            if (timeslot) {
                const hoursBooked = calculateHoursBooked(timeslot);
                document.getElementById('hoursbooked').value = hoursBooked;
            }
        }

        // Set the hours booked on page load
        document.addEventListener('DOMContentLoaded', setHoursBooked);

        // Set the hours booked when the timeslot changes
        document.getElementById('timeslot').addEventListener('change', setHoursBooked);
    </script>



</body>

</html>