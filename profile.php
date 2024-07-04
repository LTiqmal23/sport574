<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID']) || !isset($_SESSION['username'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: index.php");
    exit();
}

$sessionID = $_SESSION['ID'];
$sessionUsername = $_SESSION['username'];

include "config.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
    $newName = trim($_POST['name']);
    $newAddress = trim($_POST['address']);
    $newPhone = trim($_POST['phone']);

    // Validate the input
    if (empty($newName)) {
        echo "<script>alert('Name cannot be empty');</script>";
    } else {
        // Update the database
        $updateSql = "UPDATE CUSTOMER SET CUSTNAME = ?, CUSTADDRESS = ?, CUSTPHONE = ? WHERE CUSTID = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("sssi", $newName, $newAddress, $newPhone, $sessionID);

            if ($updateStmt->execute()) {
                echo "<script>alert('Profile updated successfully!');</script>";
            } else {
                echo "<script>alert('Error updating profile. Please try again.');</script>";
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Error preparing statement.');</script>";
        }
    }
}

// Fetch customer data
$sql = "SELECT * FROM CUSTOMER WHERE CUSTID = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $sessionID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $customerData = $result->fetch_assoc();
    } else {
        $customerData = [
            'CUSTNAME' => '',
            'CUSTADDRESS' => '',
            'CUSTPHONE' => '',
            'USERNAME' => $sessionUsername
        ];
    }
    $stmt->close();
} else {
    echo "<script>alert('Error preparing statement for fetching data.');</script>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <h1>Profile</h1>
        </div>

        <div class="check-wrapper">
            <form id="profileForm" class="row g-3" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="col-md-4 input-box">
                    <label for="custid" class="form-label">ID</label>
                    <input type="text" class="form-control" id="custid" name="custid" value="<?php echo htmlspecialchars($sessionID); ?>" readonly>
                </div>
                <div class="col-md-4 input-box">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($customerData['USERNAME']); ?>" readonly>
                </div>
                <div class="col-md-4 input-box">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($customerData['CUSTNAME']); ?>" placeholder="Enter your name">
                </div>
                <div class="col-md-12 input-box">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($customerData['CUSTADDRESS']); ?>" placeholder="Enter your address">
                </div>
                <div class="col-md-12 input-box">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($customerData['CUSTPHONE']); ?>" placeholder="Enter your phone number">
                </div>
                <div class="action-buttons">
                    <a href="cusPastBooking.php" class="action-button">
                        <img src="resource/book.png" alt="View Past Booking">
                        <span class="action-label">View Past Booking</span>
                    </a>
                    <button type="submit" class="submit-button" name="updateProfile">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>