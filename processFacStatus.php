<!DOCTYPE html>
<html lang="en">
<?php
require_once('config.php');

/*
IF RUN IS CLICKED
*/
if (isset($_GET['runID'])) {
    $ID = $_GET['runID'];

    // Prepare the delete statement
    $facility = mysqli_prepare($conn, "update FACILITY SET FACSTATUS='RUNNING' WHERE FACID=?");
    mysqli_stmt_bind_param($facility, 's', $ID);

    if (mysqli_stmt_execute($facility)) {
        echo "<script>alert('Facility is running: $ID');</script>";
        echo "<script type='text/javascript'>document.location = 'adminEditFac.php';</script>";
    } else {
        echo "<script>alert('Error running facility);</script>";
    }

    // Close the statement
    mysqli_stmt_close($facility);
}

/*
*
*
*
IF SUSPENDED IS CANCELLED
*/
if (isset($_GET['suspendID'])) {
    $ID = $_GET['suspendID'];

    // Prepare the delete statement
    $facility = mysqli_prepare($conn, "update FACILITY SET FACSTATUS='SUSPENDED' WHERE FACID=?");
    mysqli_stmt_bind_param($facility, 's', $ID);

    if (mysqli_stmt_execute($facility)) {
        echo "<script>alert('Facility is suspended: $ID');</script>";
        echo "<script type='text/javascript'>document.location = 'adminEditFac.php';</script>";
    } else {
        echo "<script>alert('Error suspending facility);</script>";
    }

    // Close the statement
    mysqli_stmt_close($facility);
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