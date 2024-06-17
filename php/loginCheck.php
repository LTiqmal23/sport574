<?php
session_start();
include "config.php";
if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

// Retrieve input values
$username = validate($_POST('username'));
$password = validate($_POST('password'));

if (empty($username)) {
    header("Location: index.php?error=Username is required");
    exit();
} else if (empty($password)) {
    header("Location: index.php?error=Password is required");
    exit();
}

$sql = "select * from customer where USERNAME='$username' and PASSWORD='$password'";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if ($row['username'] === $username && $row['$password'] === $password) {
        echo "Logged In";

        $_SESSION['user_name'] = $row['username'];
        $_SESSION['ID'] = $row['CUSTID'];

        header("location: home.php");
        exit();
    } else {
        header("Location: index.php?error=Incorrect username or password");
        exit();
    }
} else {
    header("Location: index.php?error=Incorrect username or password");
    exit();
}
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

</body>

</html>