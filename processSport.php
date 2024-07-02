
    <?php
    include "config.php";

    if (isset($_POST['sport'])) {
        $sportId = $_POST['sport'];

        // Prepare the SQL query to fetch court details based on selected sport
        $stmt = $conn->prepare("select FACID, FACNAME FROM facility WHERE SPORTID = ?");
        $stmt->bind_param("s", $sportId);
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
            echo "<tr><td colspan='2'>No courts available for this sport</td></tr>";
        }

        $stmt->close();
    } else {
        echo "<tr><td colspan='2'>No sport selected</td></tr>";
    }

    $conn->close();
    ?>