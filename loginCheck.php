<?php
session_start();
include "config.php";

$error_message = "";

function validate($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    // Retrieve input values
    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($username)) {
        $error_message = "Username is required";
    } else if (empty($password)) {
        $error_message = "Password is required";
    } else {
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
        $error_message = "Incorrect username or password";
    }

    $stmt->close();
    $conn->close();
}

// Pass error message back to login.html
if (!empty($error_message)) {
    $_SESSION['error_message'] = $error_message;
    header("Location: login.php");
    exit();
}
?>
