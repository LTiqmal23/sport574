<!DOCTYPE html>
<?php
session_start();
require_once('config.php');

// Handle update of existing addons
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateID'])) {
    $id = $_POST['updateID'];
    $name = $_POST['addonName'];
    $price = $_POST['addonPrice'];
    $quantity = $_POST['addonQuantity'];

    $update_sql = "UPDATE ADDON SET ADDONNAME=?, ADDONPRICE=?, ADDONQUANTITY=? WHERE ADDONID=?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sdii", $name, $price, $quantity, $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Addon updated successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error updating addon: " . $conn->error . "</div>";
    }
}

// Handle deletion of an addon
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteID'])) {
    $id = $_POST['deleteID'];

    $delete_sql = "DELETE FROM ADDON WHERE ADDONID=?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Addon deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting addon: " . $conn->error . "</div>";
    }
}

// Handle insertion of new addon
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['newAddon'])) {
    $name = $_POST['newAddonName'];
    $price = $_POST['newAddonPrice'];
    $quantity = $_POST['newAddonQuantity'];

    $insert_sql = "INSERT INTO ADDON (ADDONNAME, ADDONPRICE, ADDONQUANTITY) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("sdi", $name, $price, $quantity);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>New addon inserted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error inserting addon: " . $conn->error . "</div>";
    }
}

// Fetch all addons
$sql = "SELECT * FROM ADDON";
$result = mysqli_query($conn, $sql);
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Addon</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
        /* Custom styles to adjust layout */
        .container {
            background-color: #fff;
            width: 80%;
            margin: 20px auto;
            border-radius: 15px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 60%;
           
        }

        .card {
            width: 80%;
            margin-top: -30px; /* Adjust top margin */

        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .card-body {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 10px; /* Adjust bottom margin */
        }

        .form-control {
            width: 100%;
            height: 30px; /* Adjust height */
            padding: 6px 12px; /* Adjust padding */
            font-size: 14px; /* Adjust font size */
        }

        .btn {
            padding: 8px 20px; /* Adjust button padding */
        }
        
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="homeAdmin.php">
                <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                SPORTFUSION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="viewAddon.php">Addon</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminViewBooking.php">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminviewSport.php">Sport</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mt-5">
            <div class="card-header">
                <h2 class="display-6 text-center">View Addon</h2>
            </div>

            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="table-dark">
                        <tr class="bg-dark text-white">
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <form method="post" action="">
                                    <td><?php echo $row['ADDONID']; ?></td>
                                    <td><input type="text" name="addonName" value="<?php echo htmlspecialchars($row['ADDONNAME']); ?>" class="form-control" required></td>
                                    <td><input type="text" name="addonPrice" value="<?php echo htmlspecialchars($row['ADDONPRICE']); ?>" class="form-control" required></td>
                                    <td><input type="number" name="addonQuantity" value="<?php echo htmlspecialchars($row['ADDONQUANTITY']); ?>" class="form-control" required></td>
                                    <td>
                                        <input type="hidden" name="updateID" value="<?php echo $row['ADDONID']; ?>">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </td>
                                </form>
                                <form method="post" action="">
                                    <td>
                                        <input type="hidden" name="deleteID" value="<?php echo $row['ADDONID']; ?>">
                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                                    </td>
                                </form>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

                <!-- New Addon Form -->
                <h3 class="text-center mt-5">Insert New Addon</h3>
                <form method="post" action="" class="mt-3">
                    <input type="hidden" name="newAddon" value="true">
                    <div class="form-group">
                        <label for="newAddonName">Name</label>
                        <input type="text" name="newAddonName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="newAddonPrice">Price</label>
                        <input type="text" name="newAddonPrice" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="newAddonQuantity">Quantity</label>
                        <input type="number" name="newAddonQuantity" class="form-control" required>
                    </div>
                    <div class="form-group mt-3">
                        <button type="submit" class="btn btn-success">Insert Addon</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>
