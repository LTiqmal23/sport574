<!DOCTYPE html>
<html lang="en">
<?php

include 'config.php';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ID = trim($_POST['id']);
    $newName = trim($_POST['name']);
    $newPrice = trim($_POST['price']);
    $newQuantity = trim($_POST['quantity']);

    // Validate the input
    if (empty($newName)) {
        echo "<script>alert('Name cannot be empty');</script>";
    } else {
        // Update the database
        $updateSql = "UPDATE ADDON SET ADDONNAME = ?, ADDONPRICE = ?, ADDONQUANTITY = ? WHERE ADDONID = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("sdii", $newName, $newPrice, $newQuantity, $ID);

            if ($updateStmt->execute()) {
                echo "<script>alert('Addon update successful.');
                      window.location.href = 'adminViewAddon.php'; // Replace 'adminViewAddon.php' with the correct page
                      </script>";
            } else {
                echo "<script>alert('Error updating addon. Please try again.');</script>";
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Error preparing statement.');</script>";
        }
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>