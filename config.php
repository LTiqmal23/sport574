<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB Connection</title>
</head>

<body>
    <?php
    // Database connection settings
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "sportdb";

    // database connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>
</body>

</html>