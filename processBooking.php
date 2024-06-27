 
    <?php
    session_start(); // Start the session

    if (!isset($_SESSION['ID'])) {
        echo "<script>alert('Log In First');</script>";
        header("Location: login.html");
        exit();
    }
    include "config.php";

    // session
    $sessionID = $_SESSION['ID'];
    if (isset($_POST['bookingdate']) && isset($_POST['timeslot']) && isset($_POST['hoursbooked']) && isset($_POST['court'])) {

        // Prepare the SQL query to fetch court details based on selected sport, date, and timeslot
        // INSERT PROCESSING...
        // Include the database configuration
        $preDate = $_POST['bookingdate'];
        $preTimeSlot = $_POST['timeslot'];
        $preHoursBooked = $_POST['hoursbooked'];
        $preCourtID = $_POST['court'];
        $sessionID = $_SESSION['ID'];

        // Prepare the SQL query to insert booking details
        $bookingStmt = $conn->prepare("
        INSERT INTO booking (BOOKINGDATE, TIMESLOT, HOURSBOOKED, ADMINID, FACID, CUSTID) 
        VALUES (?, ?, ?, ?, ?, ?)");

        $adminID = 20241; // Assuming ADMINID is 20241

        // Bind parameters and execute the statement
        $bookingStmt->bind_param("ssiisi", $preDate, $preTimeSlot, $preHoursBooked, $adminID, $preCourtID, $sessionID);
        $bookingStmt->execute();

        // Retrieve the auto-generated booking ID
        $booking_id = mysqli_insert_id($conn);

        if ($bookingStmt->affected_rows > 0) {
            // addon processing
            // Process addons
            if (!empty($_POST['quantity'])) {
                foreach ($_POST['quantity'] as $addonID => $quantity) {
                    if ($quantity > 0) {
                        // Prepare the SQL query to insert addon details
                        $addonStmt = $conn->prepare("
                    INSERT INTO booking_addon (BOOKINGID, ADDONID, QUANTITY) 
                    VALUES (?, ?, ?)
                ");
                        $addonStmt->bind_param("iii", $booking_id, $addonID, $quantity);
                        $addonStmt->execute();
                        $addonStmt->close();
                    }
                }
            }
            // Booking successfully inserted
            echo "<script>alert('Booking successful. Your booking ID is:  . $booking_id');
        window.location.href = 'successBooking.html'; // Replace 'nextPage.php' with the desired page
        </script>";
        } else {
            // Error inserting booking
            echo "<script>
        alert('Booking error occured.');
        window.location.href = 'home.php'; // Replace 'nextPage.php' with the desired page
        </script>";
        }
    } else {
        echo "Invalid input.";
    }

    $conn->close();
    ?>