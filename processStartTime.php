
    <?php
    // Retrieve POST parameters
    $sportId = $_POST['sport'];
    $selectedDate = $_POST['date'];
    $startTime = $_POST['startTime'];

    // Convert selectedDate and startTime to a datetime object for comparison
    $selectedDateTime = date('Y-m-d H:i:s', strtotime("$selectedDate $startTime"));

    // Prepare the SQL query to fetch court details based on selected sport and date/time
    $stmt = $conn->prepare("
        SELECT f.FACID
        FROM facility f
        LEFT JOIN booking b ON f.FACID = b.FACID 
            AND b.BOOKINGDATE = ? 
            AND b.STARTTIME <= ? 
            AND b.ENDTIME > ?
        WHERE f.SPORTID = ? 
        AND b.FACID IS NULL
    ");

    $stmt->bind_param("ssss", $selectedDate, $startTime, $startTime, $sportId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch and display the results
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Available Court: " . $row['FACID'] . "<br>";
        }
    } else {
        echo "No available courts for the selected sport and time.";
    }

    $stmt->close();
    $conn->close();

    ?>
