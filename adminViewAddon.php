<!DOCTYPE html>
<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['ID']) || !isset($_SESSION['username'])) {
    echo "<script>alert('Log In First');</script>";
    header("Location: login.php");
    exit();
}

$sessionID = $_SESSION['ID'];
$sessionUsername = $_SESSION['username'];

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

// Get the current page number from the query parameter; default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5; // Number of records to display per page
$offset = ($page - 1) * $records_per_page;

// Fetch the total number of records
$total_records_sql = "SELECT COUNT(*) as total FROM ADDON";
$total_records_stmt = $conn->prepare($total_records_sql);
$total_records_stmt->execute();
$total_records_result = $total_records_stmt->get_result();
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch bookings
$sql = "SELECT * FROM ADDON LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $records_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Addon</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">

    <style>
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
        }

        .title {
            padding: 15px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .title h1 {
            display: inline-block;
            position: relative;
            font-family: 'Poppins';
            font-weight: 600;
            color: #000;
        }

        .title h1::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: #1A307F;
            border-radius: 3px;
        }

        .content {
            width: 90%;
        }

        .content table {
            width: 80%;
            text-align: center;
            margin: 0 auto;
            padding: 10px;
        }

        .content th,
        .content td {
            padding: 10px;
        }

        .content .header {
            background-color: #FF8A1E;
        }

        .content .info {
            background-color: #dfdfdf;
        }

        .back-button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #1A307F;
            color: #ffffff;
            border-radius: 5px;
            transition: background-color 0.2s;
            margin-right: 10px;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #1A307F;
            padding: 10px 20px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin: 0 5px;
            border: 1px solid #1A307F;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #1A307F;
            color: white;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }

        .pagination {
            margin-top: 20px;
            /* Add space between the table and pagination */
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="homeAdmin.php">
                    <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    SPORTFUSION
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="adminViewAddon.php">Addon</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminViewBooking.php">Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminViewSport.php">Sport</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="title">
            <a href="homeAdmin.php" class="back-button">
                <img src="resource/backButton.svg" alt="Back">
            </a>
            <h1>List of Addons</h1>
        </div>

        <div class="content">
            <table>
                <tr class="header">
                    <th>No</th>
                    <th>Addon ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th colspan="2">Action</th>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    $counter = 1 + $offset;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='info'>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . $row['ADDONID'] . "</td>";
                        echo "<td>" . $row['ADDONNAME'] . "</td>";
                        echo "<td>" . $row['ADDONPRICE'] . "</td>";
                        echo "<td>" . $row['ADDONQUANTITY'] . "</td>";
                ?>
                        <td>
                            <a href="adminEditAddon.php?editID=<?php echo $row['ADDONID']; ?>" class="btn btn-primary">Edit</a>
                            <a href="processDeleteAddon.php?deleteID=<?php echo $row['ADDONID']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                <?php
                        echo "</tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No bookings found</td></tr>";
                }
                ?>
            </table>


            <!-- Pagination controls -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                        <li class="page-item <?php if ($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php } ?>
                    <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                </ul>
            </nav>

            <div class="d-grid gap-2 d-md-block">
                <a class="btn btn-success" type="button" href="adminAddAddon.php">Add New Addon</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>