<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve input values
        $name = filter_input(INPUT_POST, 'name');
        $address = filter_input(INPUT_POST, 'address');
        $phone = filter_input(INPUT_POST, 'phone');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

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
        } else {
            // SQL for execution
            $stmt = $conn->prepare("INSERT INTO `customer` (`CUSTNAME`, `CUSTADDRESS`, `CUSTPHONE`, `USERNAME`, `PASSWORD`) VALUES (?, ?, ?, ?, ?)");

            if ($stmt) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sssss", $name, $address, $phone, $username, $password);

                // Execute the prepared statement
                if ($stmt->execute()) {
                    echo "New record inserted successfully";
                } else {
                    echo "Error executing query: " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }

            // Close the connection
            $conn->close();
        }
    }
    ?>
</body>

</html>