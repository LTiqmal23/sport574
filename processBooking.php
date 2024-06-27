 
    <?php
    include "config.php";

    if (isset($_POST['sport']) && isset($_POST['date']) && isset($_POST['timeslot'])) {
        $sportId = $_POST['sport'];
        $selectedDate = $_POST['date'];
        $selectedTimeSlot = $_POST['timeslot'];

        // Prepare the SQL query to fetch court details based on selected sport, date, and timeslot
        $stmt = $conn->prepare("
            SELECT f.FACID 
            FROM facility f 
            LEFT JOIN booking b 
            ON f.FACID = b.FACID 
            AND b.BOOKINGDATE = ? 
            AND b.TIMESLOT = ?
            WHERE f.SPORTID = ? 
            AND b.FACID IS NULL
        ");

        // INSERT PROCESSING...
        $bookingStmt = $conn->prepare("
        insert INTO booking(BOOKINGDATE, TIMESLOT, ADMINID, FACID, CUSTID) 
        VALUES (,'?','?','?','?','?')");

        $stmt->bind_param("sss", $selectedDate, $selectedTimeSlot, $sportId);
        $stmt->execute();
        $result = $stmt->get_result();

        // ADDON PROCESSING...
        $bookingStmt = $conn->prepare("
        insert INTO booking(BOOKINGDATE, TIMESLOT, ADMINID, FACID, CUSTID) 
        VALUES (,'?','?','?','?','?')");


        $stmt->close();
    } else {
        echo "Invalid input.";
    }

    $conn->close();
    ?>