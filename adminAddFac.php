<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID']) || !isset($_SESSION['username'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: index.php");
    exit();
}

$sessionID = $_SESSION['ID'];

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sportid = $_POST['sportid'];
    $facid = $_POST['facid'];
    $facname = $_POST['facname'];
    $fee = $_POST['fee'];
    $status = $_POST['status'];

    // Check for duplicate FACID
    $check_sql = "SELECT FACID FROM FACILITY WHERE FACID = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $facid);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        // FACID already exists
        $error_message = "Facility ID already exists. Please use a different ID.";
    } else {
        // Insert the new facility
        $insert_sql = "INSERT INTO FACILITY (FACID, SPORTID, FACNAME, FEE, FACSTATUS) VALUES (?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssss", $facid, $sportid, $facname, $fee, $status);

        if ($insert_stmt->execute()) {
            $success_message = "Facility added successfully.";
        } else {
            $error_message = "Error adding facility: " . $conn->error;
        }

        $insert_stmt->close();
    }

    $check_stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Facility</title>
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

        .title {
            padding: 15px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .title h1 {
            display: inline-block;
            position: relative;
            font-family: 'Poppins';
            font-weight: 600;
            color: #000;
        }

        .title h1::after {
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

        .check-wrapper {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .input-box {
            margin-bottom: 15px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .action-button {
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .action-button img {
            margin-right: 8px;
            height: 20px;
            /* Adjust icon size */
        }

        .action-button:hover {
            background-color: #45a049;
        }

        .submit-button {
            padding: 8px 16px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 14px;
        }

        .submit-button:hover {
            background-color: #007bb5;
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
        <div class="title">
            <h1>Add Facility</h1>
        </div>

        <div class="check-wrapper">
            <?php if (isset($error_message)) : ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php endif; ?>
            <?php if (isset($success_message)) : ?>
                <div class="alert alert-success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            <form class="row g-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="col-md-12 input-box">
                    <label for="sportid">Sport</label>
                    <select id="sportid" name="sportid" class="form-control" required>
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
                <div class="col-md-6 input-box">
                    <label for="facid">Facility ID</label>
                    <input type="text" class="form-control" id="facid" name="facid" required>
                </div>
                <div class="col-md-6 input-box">
                    <label for="facname">Facility Name</label>
                    <input type="text" class="form-control" id="facname" name="facname" required>
                </div>
                <div class="col-md-6 input-box">
                    <label for="fee">Fee per Hour</label>
                    <input type="text" class="form-control" id="fee" name="fee" required>
                </div>
                <div class="col-md-6 input-box">
                    <label for="status">Facility Status</label>
                    <input type="text" class="form-control" id="status" name="status" placeholder="RUNNING, SUSPENDED..." required>
                </div>
                <div class="action-buttons">
                    <button type="submit" class="submit-button">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>