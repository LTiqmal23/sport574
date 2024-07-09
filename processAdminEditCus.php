<!DOCTYPE html>
<?php
include "config.php";
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updateProfile'])) {
    $viewID = trim($_POST['custid']);
    $newName = trim($_POST['name']);
    $newAddress = trim($_POST['address']);
    $newPhone = trim($_POST['phone']);

    // Validate the input
    if (empty($newName)) {
        echo "<script>alert('Name cannot be empty');</script>";
    } else {
        // Update the database
        $updateSql = "UPDATE CUSTOMER SET CUSTNAME = ?, CUSTADDRESS = ?, CUSTPHONE = ? WHERE CUSTID = ?";
        if ($updateStmt = $conn->prepare($updateSql)) {
            $updateStmt->bind_param("sssi", $newName, $newAddress, $newPhone, $viewID);

            if ($updateStmt->execute()) {
                echo "<script>alert('Profile updated successfully!');</script>";
                echo "<script type='text/javascript'>document.location = 'adminViewCust.php';</script>";
            } else {
                echo "<script>alert('Error updating profile. Please try again.');</script>";
            }

            $updateStmt->close();
        } else {
            echo "<script>alert('Error preparing statement.');</script>";
        }
    }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>