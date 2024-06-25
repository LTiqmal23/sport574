<!DOCTYPE html>
<html lang="en">

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
            margin-top: 20px;
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
            padding: 15px 45px 15px 20px;
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
                        <form action="#" method="post">
                            <div class="input-box">
                                <label for="sport">Sport</label>
                                <select id="sport" name="sport" class="form-control">
                                    <?php
                                    include "config.php";
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
                                <label>Start Time</label>
                                <input type="time">
                            </div>

                            <div class="input-box">
                                <label>End Time</label>
                                <input type="time">
                            </div>

                            <div class="input-box d-flex justify-content-center">
                                <button type="submit" href="validateDetail.html" class="btn btn-success ">Proceed
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
        let selectedSport = '';

        document.getElementById('sport').addEventListener('change', function() {
            selectedSport = this.value;

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
    </script>
</body>

</html>