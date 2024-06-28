<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    session_start();
    include "config.php";

    function validate($data)
    {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    if (isset($_POST['username']) && isset($_POST['password'])) {
        // Retrieve input values
        $username = validate($_POST['username']);
        $password = validate($_POST['password']);

        if (empty($username)) {
            header("Location: index.php?error=Username is required");
            exit();
        } else if (empty($password)) {
            header("Location: index.php?error=Password is required");
            exit();
        }

        // Prepare and bind for customer table
        $stmt = $conn->prepare("SELECT * FROM customer WHERE USERNAME=? AND PASSWORD=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // If username and password match
            $_SESSION['username'] = $row['USERNAME'];
            $_SESSION['ID'] = $row['CUSTID'];
            header("location: home.php");
            exit();
        }

        // Prepare and bind for admin table
        $stmt = $conn->prepare("SELECT * FROM admin WHERE USERNAME=? AND PASSWORD=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            // If username and password match
            $_SESSION['username'] = $row['USERNAME'];
            $_SESSION['ID'] = $row['ADMINID'];
            header("location: homeAdmin.php");
            exit();
        }

        // If username or password is incorrect
        header("Location: index.php?error=Incorrect username or password");
        exit();

        $stmt->close();
        $conn->close();
    }
    ?>



</body>

</html>