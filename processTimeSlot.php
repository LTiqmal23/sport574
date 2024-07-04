 
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
            AND FACSTATUS = 'RUNNING'
            AND b.FACID IS NULL
        ");

        // Bind parameters
        $stmt->bind_param("sss", $selectedDate, $selectedTimeSlot, $sportId);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch available courts and display
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['FACID'] . "</td>";
                echo "<td>Available</td>"; // You can change this to dynamically fetch availability
                echo "</tr>";
            }
        } else {
            echo "No available courts for the selected time slot.";
        }

        $stmt->close();
    } else {
        echo "Invalid input.";
    }

    $conn->close();
    ?>