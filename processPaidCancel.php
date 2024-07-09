<!DOCTYPE html>
<html lang="en">
<?php
require_once('config.php');

/*
IF ACCEPT IS CANCELLED
*/
if (isset($_GET['cancelID'])) {
    $ID = $_GET['cancelID'];

    // Prepare the delete statement
    $paid = mysqli_prepare($conn, "update payment SET PAYMENTSTATUS='CANCELLED' WHERE BOOKINGID=?");
    mysqli_stmt_bind_param($paid, 's', $ID);

    if (mysqli_stmt_execute($paid)) {
        echo "<script>alert('Payment cancelled');</script>";
        echo "<script type='text/javascript'>document.location = 'adminPendingPayment.php';</script>";
    } else {
        echo "<script>alert('Error cancelling record');</script>";
    }

    // Close the statement
    mysqli_stmt_close($paid);
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