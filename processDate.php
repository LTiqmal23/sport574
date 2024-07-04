
<?php
include "config.php";

if (isset($_POST['sport']) && isset($_POST['date'])) {
    $sportId = $_POST['sport'];
    $selectedDate = $_POST['date'];

    // Prepare the SQL query to fetch court details based on selected sport
    $stmt = $conn->prepare("select f.FACID, f.FACNAME 
    FROM facility f 
    LEFT JOIN booking b ON f.FACID = b.FACID AND b.BOOKINGDATE = ? 
    WHERE f.SPORTID = ? 
    AND FACSTATUS = 'RUNNING'
    AND b.FACID IS NULL");

    $stmt->bind_param("ss", $selectedDate, $sportId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Output the court details in table rows
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['FACID'] . "</td>";
            echo "<td>Available</td>"; // You can change this to dynamically fetch availability
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='2'>No courts available for this sport and date</td></tr>";
    }

    $stmt->close();
} else {
    echo "<tr><td colspan='2'>No sport or date selected</td></tr>";
}

$conn->close();
?>
