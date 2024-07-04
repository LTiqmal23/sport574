<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: login.php");
    exit();
}

include "config.php";
$viewID = $_GET["viewID"];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Edit Booking Details</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Customer Booking Detail */
        #customer-details .choose-sport {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 600px;
            color: #000000;
        }

        #customer-details .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
        }

        #customer-details .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #1A307F;
            color: #ffffff;
            border-radius: 5px;
            transition: background-color 0.2s;
            cursor: pointer;
        }

        #customer-details .back-button svg {
            width: 24px;
            height: 24px;
            stroke: #ffffff;
            stroke-width: 2;
        }

        #customer-details .back-button:hover {
            background-color: #16275e;
        }

        #customer-details .booking-details-wrapper {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        #customer-details .booking-details,
        #customer-details .booking-details2 {
            flex-basis: calc(50% - 10px);
            background-color: #1A307F;
            border-radius: 10px;
            padding: 10px;
        }

        #customer-details .booking-details .table-container,
        #customer-details .booking-details2 .table-container {
            background-color: #1A307F;
            padding: 10px;
            border-radius: 10px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #customer-details .booking-details2 {
            flex-basis: calc(50% - 20px);
            background-color: #5d5d5e;
            border-radius: 10px;
            padding: 20px;
            margin-left: 20px;
        }

        #customer-details .booking-details .table-container {
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #customer-details .booking-details2 .table-container2 {
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        #customer-details .booking-details .table-container h3 {
            margin: 0 0 10px 0;
            color: #FF8A1E;
            font-size: 1.5em;
            text-align: left;
            width: 100%;
        }

        #customer-details .booking-details2 .table-container2 h3 {
            margin: 0 0 10px 0;
            color: #FF8A1E;
            font-size: 1.5em;
            text-align: left;
            width: 100%;
        }

        #customer-details .booking-details table,
        #customer-details .booking-details2 table {
            width: 100%;
            background-color: transparent;
            color: #ffffff;
            border-collapse: collapse;
            text-align: left;
        }

        #customer-details .booking-details table td,
        #customer-details .booking-details2 table td {
            padding: 10px 15px;
            border: none;
        }

        #customer-details .booking-details2 table th {
            background-color: #FF8A1E;
            color: #1A307F;
            font-weight: bold;
        }

        #customer-details .booking-details2 table tr:nth-child(even) {
            background-color: #5d5d5e;
        }

        #customer-details .booking-details2 table tr:last-child td {
            background-color: #5d5d5e;
            padding-top: 15px;
        }

        #customer-details .proceedpayment-button {
            position: absolute;
            bottom: 20px;
            right: 20px;
            align-self: flex-end;
            background-color: #d4edda;
            color: #155724;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #customer-details .proceedpayment-button:hover {
            background-color: #c3e6cb;
        }

        .scrollable-table {
            max-height: 200px;
            /* Adjust the height as needed */
            overflow-y: auto;
            position: relative;
            width: 100%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            /* Sticky position for header */
            z-index: 2;
        }

        .total-row {
            background-color: #f2f2f2;
            position: sticky;
            bottom: 0;
            z-index: 1;
        }

        .container h1 {
            display: inline-block;
            position: relative;
            font-family: 'Poppins';
            font-weight: 600;
            color: #000;
        }

        .container h1::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: #1A307F;
            border-radius: 3px;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="homeAdmin.php">
                    <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    SPORTFUSION
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="adminViewAddon.php">Addon</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminViewBooking.php">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="viewSport.php">Sport</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main id="customer-details">
        <section class="choose-sport">
            <div class="container">
                <a href="adminViewBooking.php" class="back-button">
                    <img src="resource/backButton.svg" alt="Back">
                </a>
                <h1>Booking Details</h1>

                <div class="booking-details-wrapper">
                    <?php

                    $sqlBooking = "SELECT * FROM booking B JOIN customer C ON B.CUSTID = C.CUSTID WHERE BOOKINGID = ?";
                    $stmtBooking = $conn->prepare($sqlBooking);

                    if ($stmtBooking) {
                        $stmtBooking->bind_param("i", $viewID);
                        $stmtBooking->execute();
                        $resultBooking = $stmtBooking->get_result();

                        if ($resultBooking->num_rows > 0) {
                            // Fetch the single result
                            $row = $resultBooking->fetch_assoc();

                            // Now you can access the row elements
                            $bookingDate = $row["BOOKINGDATE"];
                            $bookingSlot = $row["TIMESLOT"];
                            $bookingFacID = $row["FACID"];
                            $bookingCustPhone = $row["CUSTPHONE"];
                            $bookingCustName = $row["CUSTNAME"];
                        } else {
                            echo "<script>alert('No Booking Available');</script>";
                        }

                        // Close the prepared statement
                        $stmtBooking->close();
                    } else {
                        echo "Error preparing statement: " . $conn->error;
                    }
                    ?>
                    <div class="booking-details">
                        <div class="table-container">
                            <h3><?php echo $viewID; ?></h3>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo $bookingCustName; ?></td>
                                </tr>
                                <tr>
                                    <td>Phone Number</td>
                                    <td><?php echo $bookingCustPhone; ?></td>
                                </tr>
                                <tr>
                                    <td>Court/Table Number</td>
                                    <td><?php echo $bookingFacID; ?></td>
                                </tr>
                                <tr>
                                    <td>Date</td>
                                    <td><?php echo $bookingDate; ?></td>
                                </tr>
                                <tr>
                                    <td>Time</td>
                                    <td><?php echo $bookingSlot; ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>


                    <div class="booking-details2">

                        <div class="table-container2">
                            <?php
                            $sqlPayment = "SELECT B.*, F.FACPRICEPERHOUR, A.ADDONID, A.QUANTITY, AD.ADDONPRICE, AD.ADDONNAME 
                   FROM booking B 
                   JOIN booking_addon A ON B.BOOKINGID = A.BOOKINGID
                   JOIN FACILITY F ON B.FACID = F.FACID 
                   JOIN ADDON AD ON A.ADDONID = AD.ADDONID 
                   WHERE B.BOOKINGID = ?";
                            $stmtPayment = $conn->prepare($sqlPayment);

                            if ($stmtPayment) {
                                $stmtPayment->bind_param("i", $viewID);
                                $stmtPayment->execute();
                                $resultPayment = $stmtPayment->get_result();

                                if ($resultPayment->num_rows > 0) {
                                    // Initialize total amount
                                    $totalAmount = 0;
                            ?>
                                    <h3>Payment Details</h3>
                                    <div class="scrollable-table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Items</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch and display booking details
                                                $row = $resultPayment->fetch_assoc();
                                                $price = $row["FACPRICEPERHOUR"];
                                                $hour = $row["HOURSBOOKED"];
                                                $courtTotal = $price * $hour;
                                                $totalAmount += $courtTotal;
                                                ?>
                                                <tr>
                                                    <td>Court</td>
                                                    <td><?php echo $price; ?></td>
                                                    <td><?php echo $hour; ?></td>
                                                    <td><?php echo $courtTotal; ?></td>
                                                </tr>
                                                <?php
                                                // Display add-on details
                                                do {
                                                    $addonName = $row["ADDONNAME"];
                                                    $addonPrice = $row["ADDONPRICE"];
                                                    $addonQuantity = $row["QUANTITY"];
                                                    $addonTotal = $addonPrice * $addonQuantity;
                                                    $totalAmount += $addonTotal;
                                                ?>
                                                    <tr>
                                                        <td><?php echo $addonName; ?></td>
                                                        <td><?php echo $addonPrice; ?></td>
                                                        <td><?php echo $addonQuantity; ?></td>
                                                        <td><?php echo $addonTotal; ?></td>
                                                    </tr>
                                                <?php
                                                } while ($row = $resultPayment->fetch_assoc());
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr class="total-row">
                                                    <td colspan="3">Total All</td>
                                                    <td><?php echo 'RM' . number_format($totalAmount, 2); ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                            <?php
                                } else {
                                    echo "<script>alert('No Booking Available');</script>";
                                }

                                // Close the prepared statement
                                $stmtPayment->close();
                            } else {
                                echo "Error preparing statement: " . $conn->error;
                            }
                            ?>
                        </div>
                    </div>
                </div>
        </section>
    </main>
</body>

</html>