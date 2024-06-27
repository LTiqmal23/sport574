<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: login.html");
    exit();
}

// session
$sessionID = $_SESSION['ID'];

// fetch from previous page
$preDate = $_POST['bookingdate'];
$preTimeSlot = $_POST['timeslot'];
$preSportName = $_POST['sport'];
$preCourtID = $_POST['court'];

// selecting SPORTNAME
include "config.php";

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Time</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>
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
            padding-bottom: 40px;
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

        .check-wrapper {
            width: 90%;
        }

        .check-wrapper form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .check-wrapper {
            width: 90%;
        }

        .input-box {
            width: 70%;
            margin-top: 10px;
        }

        .input-box input,
        .input-box select {
            height: 100%;
            width: 100%;
            background-color: #d9d9d9;
            border: none;
            outline: none;
            border-radius: 30px;
            font-size: 16px;
            color: #000000;
            padding: 10px 45px 10px 20px;
        }

        .content {
            width: 90%;
        }

        .check-table table {
            width: 100%;
            text-align: center;
        }

        .check-table th {
            background-color: coral;
            /* Set border size, style, and color */
        }

        .check-table td {
            background-color: #d9d9d9;
            text-align: center;
            /* Set border size, style, and color */
        }
    </style>

</head>

<body>
    <header>
        <nav class="navbar">
            <div class="site-logo">
                <img src="resource/logo.svg">
                <h1>SPORTFUSION</h1>
            </div>

            <ul class="nav_links">
                <li><a class="active" href="#">Home</a></li>
                <li><a href="#">Book</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </nav>
    </header>

    <div class="check-container">
        <div class="check-header">
            <h1>Choose Time and Date</h1>
        </div>

        <table class="content">
            <tr>
                <td>
                    <div class="check-wrapper">
                        <form id="addonForm" action="#" method="post">
                            <div class="input-box">
                                <?php
                                include "config.php";
                                $sql = "SELECT ADDONID, ADDONNAME, ADDONPRICE FROM ADDON";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='addon-item'>";
                                        echo "<label>" . $row['ADDONNAME'] . " (RM" . $row['ADDONPRICE'] . ")</label>";
                                        echo "<input type='number' class='form-control addon-quantity' data-id='" . $row['ADDONID'] . "' data-name='" . $row['ADDONNAME'] . "' data-price='" . $row['ADDONPRICE'] . "' id='quantity_" . $row['ADDONID'] . "' name='quantity[" . $row['ADDONID'] . "]' min='0'>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>No options available</p>";
                                }
                                ?>
                            </div>

                            <div class="input-box d-flex justify-content-center">
                                <button type="submit" class="btn btn-success">Proceed Booking</button>
                            </div>
                        </form>
                    </div>
                </td>

                <td class="center-cell">
                    <div class="check-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="priceTable">
                                <?php
                                include "config.php";
                                $hoursBooked = 2; // Example hours booked, replace with your logic

                                $sqlSportName = "SELECT * FROM FACILITY WHERE FACID = ?";
                                $stmt = $conn->prepare($sqlSportName);
                                $stmt->bind_param("i", $preCourtID);
                                $stmt->execute();
                                $resultCourt = $stmt->get_result();

                                if ($resultCourt->num_rows > 0) {
                                    while ($row = $resultCourt->fetch_assoc()) {
                                        $facPrice = $row['FACPRICEPERHOUR'];
                                        $courtTotal = $facPrice * $hoursBooked;
                                        echo "<tr id='courtRow'>";
                                        echo "<td>Court " . $preCourtID . "</td>";
                                        echo "<td>RM" . number_format($facPrice, 2) . "</td>";
                                        echo "<td>" . $hoursBooked . "</td>";
                                        echo "<td>RM" . number_format($courtTotal, 2) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<script>alert('No court available');</script>";
                                }
                                ?>
                            </tbody>
                        </table>
                        <button id="calculateTotalBtn" class="btn btn-primary">Calculate Grand Total</button>
                        <div id="grandTotalDiv" style="display:none;">
                            <strong>Grand Total: </strong><span id="grandTotalAmount">RM0.00</span>
                        </div>
                    </div>
                </td>
            </tr>
        </table>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial calculation for the court
            calculateCourtTotal();

            // Get all quantity inputs
            const quantityInputs = document.querySelectorAll('.addon-quantity');

            // Add event listeners to each input
            quantityInputs.forEach(input => {
                input.addEventListener('input', updateTable);
            });

            // Calculate Grand Total Button
            const calculateTotalBtn = document.getElementById('calculateTotalBtn');
            calculateTotalBtn.addEventListener('click', calculateGrandTotal);

            function calculateCourtTotal() {
                const courtRow = document.getElementById('courtRow');
                const courtPrice = parseFloat(courtRow.cells[1].innerText.replace('RM', ''));
                const hoursBooked = parseInt(courtRow.cells[2].innerText);
                const courtTotal = courtPrice * hoursBooked;
                courtRow.cells[3].innerText = 'RM' + courtTotal.toFixed(2);

                return courtTotal;
            }

            function updateTable() {
                const priceTable = document.getElementById('priceTable');

                quantityInputs.forEach(input => {
                    const addonName = input.getAttribute('data-name');
                    const addonPrice = parseFloat(input.getAttribute('data-price'));
                    const quantity = parseInt(input.value) || 0;
                    const total = addonPrice * quantity;

                    if (quantity > 0) {
                        let row = document.getElementById('addon_' + addonName);
                        if (!row) {
                            row = document.createElement('tr');
                            row.id = 'addon_' + addonName;
                            row.innerHTML = `
                        <td>${addonName}</td>
                        <td>RM${addonPrice.toFixed(2)}</td>
                        <td>${quantity}</td>
                        <td>RM${total.toFixed(2)}</td>
                    `;
                            priceTable.appendChild(row);
                        } else {
                            row.cells[2].innerText = quantity;
                            row.cells[3].innerText = 'RM' + total.toFixed(2);
                        }
                    } else {
                        let row = document.getElementById('addon_' + addonName);
                        if (row) {
                            priceTable.removeChild(row);
                        }
                    }
                });
            }

            function calculateGrandTotal() {
                const courtTotal = calculateCourtTotal();
                let grandTotal = courtTotal; // Start with court total

                quantityInputs.forEach(input => {
                    const addonPrice = parseFloat(input.getAttribute('data-price'));
                    const quantity = parseInt(input.value) || 0;
                    const total = addonPrice * quantity;

                    if (quantity > 0) {
                        grandTotal += total;
                    }
                });

                document.getElementById('grandTotalAmount').innerText = 'RM' + grandTotal.toFixed(2);
                document.getElementById('grandTotalDiv').style.display = 'block';
            }
        });
    </script>


</body>

</html>