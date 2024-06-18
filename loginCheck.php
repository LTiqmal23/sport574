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
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
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

        // Prepare and bind
        $stmt = $conn->prepare("SELECT * FROM customer WHERE USERNAME=? AND PASSWORD=?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if ($row['USERNAME'] === $username && $row['PASSWORD'] === $password) {
                echo "Logged In";

                $_SESSION['user_name'] = $row['USERNAME'];
                $_SESSION['ID'] = $row['CUSTID'];

                header("location: home.html");
                exit();
            } else {
                header("Location: index.php?error=Incorrect username or password");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorrect username or password");
            exit();
        }

        $stmt->close();
        $conn->close();
    }
    ?>

</body>

</html>