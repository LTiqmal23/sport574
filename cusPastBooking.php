<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>Log In First</script>";
    header("Location: login.html");
    exit();
}

require_once("config.php");
$sessionID = $_SESSION['ID'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to fetch bookings
$sql = "select * FROM BOOKING WHERE CUSTID = $sessionID";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Past Bookings</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            background-color: #fff;
            width: 80%;
            margin: 20px auto;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .title {
            padding: 15px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            /* Center horizontally */
            position: relative;
            /* Add position relative */
        }


        .title h1 {
            color: #000;
            font-size: 30px;
            position: relative;
            margin-left: 10px;
            text-align: center;
            /* Center text */
        }

        .title h1::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -5px;
            width: 100%;
            height: 5px;
            background: #1A307F;
            border-radius: 3px;
        }

        .content {
            width: 90%;
        }

        .content table {
            width: 80%;
            text-align: center;
            margin: 0 auto;
            padding: 10px;
        }

        .content th {
            padding: 10px;
        }

        .content td {
            padding: 10px;
        }

        .content .header {
            background-color: #FF8A1E;
        }

        .content .info {
            background-color: #dfdfdf;
        }

        .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #1A307F;
            color: #ffffff;
            border-radius: 5px;
            transition: background-color 0.2s;
            margin-right: 10px;
            position: absolute;
            /* Position back button absolutely */
            left: 20px;
            /* Adjust left position for back button */
            top: 50%;
            /* Center vertically */
            transform: translateY(-50%);
            /* Center vertically */
        }
    </style>
</head>

<body>
    <header>
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
                            <a class="nav-link" href="#">Book</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="title">
            <a href="home.html" class="back-button">
                <img src="resource/previous-btn.svg" alt="Back">
            </a>
            <h1>Past Bookings</h1>
        </div>

        <div class="content">
            <table>
                <tr class="header">
                    <th>No</th>
                    <th>Booking ID</th>
                    <th>Date</th>
                    <th>Time Slot</th>
                    <th>Court</th>
                    <th>Total Payment</th>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    $counter = 1;
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='info'>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . $row['BOOKINGID'] . "</td>";
                        echo "<td>" . $row['BOOKINGDATE'] . "</td>";
                        echo "<td>" . $row['TIMESLOT'] . "</td>";
                        echo "<td>" . $row['FACID'] . "</td>";
                        // You may need to fetch total payment from related tables or calculations
                        echo "<td>RMXXX</td>"; // Placeholder for total payment
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='7'>No bookings found</td></tr>";
                }
                $conn->close();
                ?>

            </table>
        </div>
    </div>
</body>

</html>