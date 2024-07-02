<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Form</title>
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
    <div class="check-container">
        <div class="check-header">
            <h1>My Profile</h1>
        </div>

        <div class="check-wrapper">
            <form id="profileForm" class="row g-3" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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
                    <button type="submit" class="submit-button">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>