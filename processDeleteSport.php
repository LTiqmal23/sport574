<!DOCTYPE html>
<html lang="en">
<?php
require_once('config.php');

if (isset($_GET['deleteID'])) {
    $ID = $_GET['deleteID'];

    // Prepare the delete statement
    $delete = mysqli_prepare($conn, "delete FROM sport WHERE SPORTID = ?");
    mysqli_stmt_bind_param($delete, 's', $ID);

    if (mysqli_stmt_execute($delete)) {
        echo "<script>alert('Record deleted successfully');</script>";
        echo "<script type='text/javascript'>document.location = 'adminViewSport.php';</script>";
    } else {
        echo "<script>alert('Error deleting record');</script>";
    }

    // Close the statement
    mysqli_stmt_close($delete);
}

// Close the connection
mysqli_close($conn);
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Program</title>
    <link rel="stylesheet" href="css/bootstrap.css">
</head>

<body class="bg-dark">

</body>

</html>