<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    $name = $_POST['name'];
    $address = $_POST['name'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // connection setting
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "sportdb";

    // Database connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die('Connection failed: ' . $conn_->connect_error);
    } else {
        $stmt = "INSERT INTO `customer` (`CUSTID`, `CUSTNAME`, `CUSTADDRESS`, `CUSTPHONE`, `USERNAME`, `PASSWORD`) VALUES (NULL, '$name', '$address', '$phone', '$username', '$password')";

        if ($conn->query($stmt)) {
            echo "New Record inserted";
        } else {
            echo "Error";
        }
        $conn->close();
    }
    ?>
</body>

</html>