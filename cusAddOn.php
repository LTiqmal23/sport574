<!DOCTYPE html>
<html lang="en">
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID']) || !isset($_SESSION['username'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: login.php");
    exit();
}

// session
$sessionID = $_SESSION['ID'];
$sessionUsername = $_SESSION['username'];

// fetch from previous page
$preDate = $_POST['bookingdate'];
$preTimeSlot = $_POST['timeslot'];
$preCourtID = $_POST['court'];
$preHoursBooked = $_POST['hoursbooked'];
// selecting SPORTNAME
include "config.php";

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add On</title>
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
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="homeCus.php">
                    <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    SPORTFUSION
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="cusCheckTime.php">Book</a>
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
    </header>

    <div class="check-container">
        <div class="check-header">
            <h1>Choose Time and Date</h1>
        </div>


        <table class="content">
            <tr>
                <td>
                    <div class="check-wrapper">
                        <form id="addonForm" action="processBooking.php" method="post">
                            <div class="input-box">
                                <!-- hidden input -->
                                <input type="hidden" id="court" name="court" value="<?php echo $preCourtID; ?>">
                                <input type="hidden" id="hoursbooked" name="hoursbooked" value="<?php echo $preHoursBooked; ?>">
                                <input type="hidden" id="timeslot" name="timeslot" value="<?php echo $preTimeSlot; ?>">
                                <input type="hidden" id="bookingdate" name="bookingdate" value="<?php echo $preDate; ?>">

                                <!-- display -->
                                <?php
                                include "config.php";
                                $sql = "SELECT ADDONID, ADDONNAME, ADDONPRICE, ADDONQUANTITY FROM ADDON";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<div class='addon-item'>";
                                        echo "<label>" . $row['ADDONNAME'] . " (RM" . $row['ADDONPRICE'] . ")</label>";
                                        echo "<input type='number' class='form-control addon-quantity' data-id='" . $row['ADDONID'] . "' data-name='" . $row['ADDONNAME'] . "' data-price='" . $row['ADDONPRICE'] . "' data-available='" . $row['ADDONQUANTITY'] . "' id='quantity_" . $row['ADDONID'] . "' name='quantity[" . $row['ADDONID'] . "]' min='0'>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>No options available</p>";
                                }
                                ?>
                            </div>

                            <div class="input-box d-flex justify-content-center gap-2">
                                <button type="submit" class="btn btn-success">Proceed Booking</button>
                                <a href="homeCus.php" class="btn btn-danger ml-3">Cancel</a>
                            </div>

                            <input type="hidden" id="total" name="total">
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
                                $hoursBooked = $preHoursBooked; // Example hours booked, replace with your logic

                                // Prepare the SQL query to fetch court information based on FACID
                                $sqlSportName = "select * FROM FACILITY WHERE FACID = ?";
                                $stmt = $conn->prepare($sqlSportName);
                                $stmt->bind_param("s", $preCourtID);
                                $stmt->execute();
                                $resultCourt = $stmt->get_result();

                                if ($resultCourt->num_rows > 0) {
                                    // Fetch the single result
                                    $row = $resultCourt->fetch_assoc();
                                    $facPrice = $row['FACPRICEPERHOUR'];
                                    $courtTotal = $facPrice * $hoursBooked;

                                    // Display the court information only once
                                    echo "<tr id='courtRow'>";
                                    echo "<td>Court " . htmlspecialchars($preCourtID) . "</td>";
                                    echo "<td>RM" . number_format($facPrice, 2) . "</td>";
                                    echo "<td>" . htmlspecialchars($hoursBooked) . "</td>";
                                    echo "<td>RM" . number_format($courtTotal, 2) . "</td>";
                                    echo "</tr>";
                                } else {
                                    echo "<script>alert('No court available');</script>";
                                }

                                // Close the prepared statement and database connection
                                $stmt->close();
                                ?>
                                <!-- Grand Total row -->
                                <tr id="grandTotalRow">
                                    <td colspan="3"><strong>Grand Total</strong></td>
                                    <td id="grandTotal">RM0.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to calculate the grand total
            function calculateGrandTotal() {
                let grandTotal = 0;

                // Get the court total
                const courtRow = document.getElementById('courtRow');
                const courtTotal = parseFloat(courtRow.querySelector('td:nth-child(4)').textContent.replace('RM', ''));
                grandTotal += courtTotal;

                // Clear previous addon rows
                const addonRows = document.querySelectorAll('.addon-row');
                addonRows.forEach(function(row) {
                    row.remove();
                });

                // Get addon totals and add rows for each addon
                const addonQuantities = document.querySelectorAll('.addon-quantity');
                addonQuantities.forEach(function(input) {
                    const price = parseFloat(input.getAttribute('data-price'));
                    const quantity = parseInt(input.value) || 0;
                    if (quantity > 0) {
                        const total = price * quantity;

                        // Create a new row for the addon
                        const newRow = document.createElement('tr');
                        newRow.classList.add('addon-row');
                        newRow.innerHTML = `
                    <td>${input.getAttribute('data-name')}</td>
                    <td>RM${price.toFixed(2)}</td>
                    <td>${quantity}</td>
                    <td>RM${total.toFixed(2)}</td>
                `;

                        // Insert the new row before the grand total row
                        document.getElementById('grandTotalRow').before(newRow);

                        grandTotal += total;
                    }
                });

                // Update the grand total in the table
                document.getElementById('grandTotal').textContent = 'RM' + grandTotal.toFixed(2);
                document.getElementById('total').value = grandTotal.toFixed(2);
            }

            // Add event listeners to the addon quantity inputs
            const addonQuantities = document.querySelectorAll('.addon-quantity');
            addonQuantities.forEach(function(input) {
                input.addEventListener('input', calculateGrandTotal);
            });

            // Initial calculation of grand total
            calculateGrandTotal();
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector("form").addEventListener("submit", function(event) {
                const quantities = document.querySelectorAll(".addon-quantity");
                let isValid = true;

                quantities.forEach(function(input) {
                    const maxAvailable = parseInt(input.getAttribute("data-available"));
                    const enteredQuantity = parseInt(input.value);

                    if (enteredQuantity > maxAvailable) {
                        alert(`The quantity for ${input.getAttribute("data-name")} exceeds the available stock of ${maxAvailable}.`);
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault(); // Prevent form submission
                }
            });
        });
    </script>
</body>

</html>