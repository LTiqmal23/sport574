<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session

if (!isset($_SESSION['ID'])) {
    echo "<script>Log In First</script>";
    header("Location: login.php");
    exit();
}

$sessionID = $_SESSION['ID'];
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Home Page */
        .home-container {
            display: flex;
            margin: 0 auto;
            justify-content: space-between;
            padding: 3em;
        }

        .home-desc h1 {
            font-weight: 600;
            font-size: 60px;
            color: #ffffff;
        }

        .home-desc a {
            color: #000000;
            text-decoration: none;
            background-color: #FF8A1E;
            border-radius: 10px;
            padding: 10px 20px 10px 20px;
            font-weight: 600;
        }

        .home-icon table {
            border-collapse: separate;
            border-spacing: 30px;
        }

        .home-img1 {
            height: 440px;
        }

        .home-img2 {
            height: 210px;
        }

        .home-img3 {
            height: 210px;
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

    <body>
        <div class="home-container">
            <div class="home-desc">
                <h1>Discover the
                    <br>
                    perfect venue
                    <br>
                    for your favorite
                    <br>
                    sports!
                </h1>
                <br>
                <br>
                <a href="checkTime.php">GET STARTED</a>
            </div>

            <div class="home-icon">
                <table>
                    <tr>
                        <td rowspan="2">
                            <img class="home-img1" src="resource/home1.png">
                        </td>

                        <td>
                            <img class="home-img2" src="resource/home2.png">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <img class="home-img2" src="resource/home3.png">
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</body>

</html>