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

    // Update the database
    $updateSql = "UPDATE CUSTOMER SET CUSTNAME = ?, CUSTADDRESS = ?, CUSTPHONE = ? WHERE CUSTID = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("sssi", $newName, $newAddress, $newPhone, $sessionID);
    
    if ($updateStmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating profile. Please try again.');</script>";
    }
    
    $updateStmt->close();
}

// Fetch customer data
$sql = "SELECT * FROM CUSTOMER WHERE CUSTID = ?";
$stmt = $conn->prepare($sql);
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
        .profile-section {
            background-color: white;
            padding: 40px;
            margin: 40px auto;
            max-width: 1000px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            width: 80%;
            height: auto;
            position: relative;
        }

        main {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
            margin: 0;
        }

        .profile-container {
            display: flex;
            align-items: flex-start;
            width: 100%;
        }

        .profile-details {
            flex-grow: 1;
        }

        .profile-details h2 {
            margin-top: 0;
        }

        .input-container {
            display: flex;
            flex-direction: column;
            margin-top: 20px;
        }

        .input-wrapper {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .input-container label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-container input {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 20px;
        }

        .action-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: black;
        }

        .action-buttons img {
            width: 100px;
            height: 100px;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .action-buttons img:hover {
            transform: scale(1.1);
        }

        .action-label {
            margin-top: 5px;
            font-size: 14px;
            text-align: center;
        }

        .save-button-container {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .save-button {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .save-button:hover {
            background-color: darkgreen;
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
    </header>

    <main>
        <section class="profile-section">
            <div class="profile-container">
                <div class="profile-details">
                    <h2>My Profile</h2>

                    <form id="profileForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <div class="input-container">
                            <label for="custid">Customer ID:</label>
                            <div class="input-wrapper">
                                <input type="text" id="custid" name="custid" value="<?php echo htmlspecialchars($sessionID); ?>" readonly>
                            </div>

                            <label for="username">Username:</label>
                            <div class="input-wrapper">
                                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($customerData['USERNAME']); ?>" readonly>
                            </div>

                            <label for="name">Name:</label>
                            <div class="input-wrapper">
                                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($customerData['CUSTNAME']); ?>" placeholder="Enter your name">
                            </div>

                            <label for="address">Address:</label>
                            <div class="input-wrapper">
                                <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customerData['CUSTADDRESS']); ?>" placeholder="Enter your address">
                            </div>

                            <label for="phone">Phone Number:</label>
                            <div class="input-wrapper">
                                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($customerData['CUSTPHONE']); ?>" placeholder="Enter your phone number">
                            </div>
                        </div>
                        <div class="save-button-container">
                            <button type="submit" class="save-button" name="updateProfile">Save</button>
                        </div>
                    </form>

                    <div class="action-buttons">
                        <a href="cusPastBooking.php" class="action-button">
                            <img src="resource/book.png" alt="View Past Booking">
                            <span class="action-label">View Past Booking</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>