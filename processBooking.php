 
    <?php
    session_start(); // Start the session

    if (!isset($_SESSION['ID'])) {
        echo "<script>alert('Log In First');</script>";
        header("Location: login.php");
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

        $preTotal = $_POST['total'];

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
            // Process addons
            if (!empty($_POST['quantity'])) {
                foreach ($_POST['quantity'] as $addonID => $quantity) {
                    if ($quantity > 0) {
                        // Fetch current quantity of the addon
                        $inventoryStmt = $conn->prepare("select ADDONQUANTITY FROM ADDON WHERE ADDONID = ?");
                        $inventoryStmt->bind_param("i", $addonID);
                        $inventoryStmt->execute();
                        $result = $inventoryStmt->get_result();
                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $currentQuantity = $row['ADDONQUANTITY'];

                            // Calculate the new quantity
                            $newQuantity = $currentQuantity - $quantity;

                            // Update the addon quantity
                            $quantityStmt = $conn->prepare("UPDATE ADDON SET ADDONQUANTITY = ? WHERE ADDONID = ?");
                            $quantityStmt->bind_param("ii", $newQuantity, $addonID);
                            $quantityStmt->execute();
                            $quantityStmt->close();

                            // Fetch price from ADDON
                            $getPriceStmt = $conn->prepare("SELECT ADDONPRICE FROM ADDON WHERE ADDONID = ?");
                            $getPriceStmt->bind_param("i", $addonID);
                            $getPriceStmt->execute();
                            $getPriceResult = $getPriceStmt->get_result();
                            if ($getPriceResult->num_rows > 0) {
                                $priceRow = $getPriceResult->fetch_assoc();
                                $price = $priceRow['ADDONPRICE'];

                                // Insert the addon booking details
                                $addonStmt = $conn->prepare("insert INTO BOOKING_ADDON (BOOKINGID, ADDONID, PRICE, QUANTITY) VALUES (?, ?, ?, ?)");
                                $addonStmt->bind_param("iidi", $booking_id, $addonID, $price, $quantity);
                                $addonStmt->execute();
                                $addonStmt->close();
                            }
                            $getPriceStmt->close();
                        }
                        $inventoryStmt->close();
                    }
                }
            }

            // payment
            // Insert the addon payment
            $payStatus = 'PENDING';
            $payDate = $preDate;
            $payStmt = $conn->prepare("insert INTO PAYMENT (BOOKINGID, PAYMENTTOTAL, PAYMENTSTATUS, PAYMENTDATE) VALUES (?, ?, ?, ?)");
            $payStmt->bind_param("idss", $booking_id, $preTotal, $payStatus, $payDate);
            $payStmt->execute();
            $payStmt->close();

            // Booking successfully inserted
            echo "<script>alert('Booking successful. Your booking ID is: $booking_id');
        window.location.href = 'successBooking.html'; // Replace 'nextPage.php' with the desired page
        </script>";
        } else {
            // Error inserting booking
            echo "<script>
        alert('Booking error occured.');
        window.location.href = 'homeCus.php'; // Replace 'nextPage.php' with the desired page
        </script>";
        }
    } else {
        echo "Invalid input.";
    }

    $conn->close();
    ?>