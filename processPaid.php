<!DOCTYPE html>
<html lang="en">
<?php
require_once('config.php');

/*
IF ACCEPT IS CLICKED
*/
if (isset($_GET['updateID'])) {
    $ID = $_GET['updateID'];

    // Prepare the delete statement
    $paid = mysqli_prepare($conn, "update payment SET PAYMENTSTATUS='PAID' WHERE BOOKINGID=?");
    mysqli_stmt_bind_param($paid, 's', $ID);

    if (mysqli_stmt_execute($paid)) {
        echo "<script>alert('Payment accepted');</script>";
        echo "<script type='text/javascript'>document.location = 'adminPendingPayment.php';</script>";
    } else {
        echo "<script>alert('Error accepting record');</script>";
    }

    // Close the statement
    mysqli_stmt_close($paid);
}

/*
*
*
*
IF ACCEPT IS CANCELLED
*/
if (isset($_GET['cancelID'])) {
    $ID = $_GET['cancelID'];

    // Prepare the update statement to cancel the payment
    $cancel = mysqli_prepare($conn, "UPDATE PAYMENT SET PAYMENTSTATUS='CANCELLED' WHERE BOOKINGID=?");
    mysqli_stmt_bind_param($cancel, 's', $ID);

    if (mysqli_stmt_execute($cancel)) {
        // Query to fetch booking addons
        $sql = "SELECT * FROM BOOKING_ADDON WHERE BOOKINGID=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $ID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Iterate through each addon associated with the booking
        while ($row = $result->fetch_assoc()) {
            $addonID = $row['ADDONID'];
            $quantityBooked = $row['QUANTITY'];

            // Fetch the current inventory quantity for the addon
            $inventoryStmt = $conn->prepare("SELECT ADDONQUANTITY FROM ADDON WHERE ADDONID=?");
            $inventoryStmt->bind_param("i", $addonID);
            $inventoryStmt->execute();
            $inventoryResult = $inventoryStmt->get_result();

            if ($inventoryResult->num_rows > 0) {
                $inventoryRow = $inventoryResult->fetch_assoc();
                $currentQuantity = $inventoryRow['ADDONQUANTITY'];

                // Calculate the new quantity
                $newQuantity = $currentQuantity + $quantityBooked;

                // Update the addon quantity
                $updateStmt = $conn->prepare("UPDATE ADDON SET ADDONQUANTITY=? WHERE ADDONID=?");
                $updateStmt->bind_param("ii", $newQuantity, $addonID);
                $updateStmt->execute();
                $updateStmt->close();
            }
            $inventoryStmt->close();
        }
        $stmt->close();

        echo "<script>alert('Payment cancelled');</script>";
        echo "<script type='text/javascript'>document.location = 'adminPendingPayment.php';</script>";
    } else {
        echo "<script>alert('Error cancelling record');</script>";
    }

    // Close the statement
    mysqli_stmt_close($cancel);
}

// Close the connection
mysqli_close($conn);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Program</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <script src="function.js"></script>
</head>

<body class="bg-dark">

</body>

</html>