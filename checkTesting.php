<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sport Booking</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <style>
        .center-cell {
            vertical-align: middle;
        }

        .check-wrapper {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .input-box {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
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
                                    $sql = "SELECT SPORTID, SPORTNAME FROM SPORT";
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
                                <label>Date</label>
                                <input type="date" class="form-control">
                            </div>

                            <div class="input-box">
                                <label>Start Time</label>
                                <input type="time" class="form-control">
                            </div>

                            <div class="input-box">
                                <label>End Time</label>
                                <input type="time" class="form-control">
                            </div>

                            <div class="input-box d-flex justify-content-center">
                                <button type="submit" href="validateDetail.html" class="btn btn-success">Proceed
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
        document.getElementById('sport').addEventListener('change', function() {
            var selectedOption = this.value;

            // AJAX request to PHP script
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'processSport.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('court-details').innerHTML = xhr.responseText;
                }
            };
            xhr.send('sport=' + selectedOption);
        });
    </script>
</body>

</html>