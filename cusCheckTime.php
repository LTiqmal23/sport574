<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>Log In First</script>";
    header("Location: login.php");
    exit();
}

require_once("config.php");
$sessionID = $_SESSION['ID'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Time</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
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
                        <form action="validateDetail.php" method="post">
                            <div class="input-box">
                                <label for="sport">Sport</label>
                                <select id="sport" name="sport" class="form-control" required>
                                    <option>Select an option</option>
                                    <?php
                                    $sql = "select SPORTID, SPORTNAME FROM SPORT";
                                    $result = $conn->query($sql);


                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['SPORTID'] . "'>" . $row['SPORTNAME'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No options available</option>";
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <div class="input-box">
                                <label for="bookdate">Date</label>
                                <input type="date" id="bookdate" name="bookdate">
                            </div>

                            <div class="input-box">
                                <label>Time Slot</label>
                                <select id="timeslot" name="timeslot" class="form-control" required>
                                    <option value="">Select an option</option>
                                    <option value="0800H-0900H">0800H - 0900H</option>
                                    <option value="0900H-1000H">0900H - 1000H</option>
                                    <option value="1000H-1100H">1000H - 1100H</option>
                                    <option value="1100H-1200H">1100H - 1200H</option>
                                    <option value="1200H-1300H">1200H - 1300H</option>
                                    <option value="1300H-1400H">1300H - 1400H</option>
                                    <option value="1400H-1500H">1400H - 1500H</option>
                                    <option value="1500H-1600H">1500H - 1600H</option>
                                    <option value="1600H-1700H">1600H - 1700H</option>
                                    <option value="1700H-1800H">1700H - 1800H</option>
                                    <option value="1800H-1900H">1800H - 1900H</option>
                                    <option value="1900H-2000H">1900H - 2000H</option>
                                    <option value="2000H-2100H">2000H - 2100H</option>
                                    <option value="2100H-2200H">2100H - 2200H</option>
                                </select>
                            </div>

                            <div class="input-box d-flex justify-content-center">
                                <button type="submit" class="btn btn-success ">Proceed
                                    Booking</button>
                            </div>
                        </form>
                    </div>
                </td>

                <td class="center-cell">
                    <div class="check-table">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Court Number</th>
                                    <th>Availability</th>
                                </tr>
                            </thead>
                            <tbody id="court-details">
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <script>
        // Fetch COURT from SELECTED SPORT
        let selectedSport = '';
        document.getElementById('sport').addEventListener('change', function() {
            selectedSport = this.value;

            // Reset other input fields
            document.getElementById('bookdate').value = '';
            document.getElementById('timeslot').selectedIndex = 0;

            // AJAX request to PHP script
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processSport.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('court-details').innerHTML = xhr.responseText;
                }
            };
            xhr.send('sport=' + selectedSport);
        });

        // fetch COURT from SELECTED DATE
        document.getElementById('bookdate').addEventListener('change', function() {
            var selectedDate = this.value;

            // AJAX request to PHP script
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processDate.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('court-details').innerHTML = xhr.responseText;
                }
            };
            xhr.send('sport=' + selectedSport + '&date=' + selectedDate);
        });

        function fetchAvailableCourts() {
            var selectedSport = document.getElementById('sport').value;
            var selectedDate = document.getElementById('bookdate').value;
            var selectedTimeSlot = document.getElementById('timeslot').value;

            if (selectedSport && selectedDate && selectedTimeSlot) {
                // AJAX request to PHP script
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'processTimeSlot.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('court-details').innerHTML = xhr.responseText;
                    }
                };
                xhr.send('sport=' + selectedSport + '&date=' + selectedDate + '&timeslot=' + selectedTimeSlot);
            }
        }

        document.getElementById('sport').addEventListener('change', fetchAvailableCourts);
        document.getElementById('bookdate').addEventListener('change', fetchAvailableCourts);
        document.getElementById('timeslot').addEventListener('change', fetchAvailableCourts);


        document.getElementById("profileForm").addEventListener("submit", function(event) {
            var timeslot = document.getElementById("timeslot").value;
            if (timeslot === "") {
                alert("Please select a time slot.");
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>

</html>