<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .profile-picture {
            position: relative;
        }

        .profile-picture img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            margin-right: 40px;
        }

        .edit-profile-link {
            position: absolute;
            bottom: -50px;
            right: 70px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .edit-profile-link:hover {
            background-color: rgba(0, 0, 0, 0.9);
        }

        .edit-icon {
            margin-right: 5px;
        }

        .profile-details {
            flex-grow: 1;
        }

        .profile-details h2 {
            margin-top: 0;
        }

        .profile-details p {
            margin: 10px 0;
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

        .edit-button {
            background-color: transparent;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .edit-button img {
            width: 20px;
            height: 20px;
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

                    <div class="input-container">
                        <label for="name">Name:</label>
                        <div class="input-wrapper">
                            <input type="text" id="name" name="name" placeholder="Enter your name">
                            <button class="edit-button">
                                <img src="resource/edit.png" alt="Edit">
                            </button>
                        </div>
                        <label for="phone">Phone Number:</label>
                        <div class="input-wrapper">
                            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                            <button class="edit-button">
                                <img src="resource/edit.png" alt="Edit">
                            </button>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <a href="cusPastBooking.php" class="action-button">
                            <img src="resource/book.png" alt="View Past Booking">
                            <span class="action-label">View Past Booking</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="save-button-container">
                <button class="save-button">Save</button>
            </div>
        </section>
    </main>
</body>

</html>