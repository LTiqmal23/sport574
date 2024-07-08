<!DOCTYPE html>
<?php
session_start();
require_once('config.php');


// Fetch all addons
$sql = "select * FROM CUSTOMER";
$result = mysqli_query($conn, $sql);

// Get the current page number from the query parameter; default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 5; // Number of records to display per page
$offset = ($page - 1) * $records_per_page;

// Fetch the total number of records
$total_records_sql = "select COUNT(*) as total FROM CUSTOMER";
$total_records_stmt = $conn->prepare($total_records_sql);
$total_records_stmt->execute();
$total_records_result = $total_records_stmt->get_result();
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch bookings
$sql = "select * FROM CUSTOMER LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $records_per_page, $offset);
$stmt->execute();
$result = $stmt->get_result();
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Customer</title>
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
            <h1>List of Customer</h1>
        </div>

        <div class="content">
            <table>
                <tr class="header">
                    <th>No</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th colspan="2">Action</th>
                </tr>

                <?php
                if ($result->num_rows > 0) {
                    $counter = 1 + $offset;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='info'>";
                        echo "<td>" . $counter . "</td>";
                        echo "<td>" . $row['CUSTID'] . "</td>";
                        echo "<td>" . $row['CUSTNAME'] . "</td>";
                        echo "<td>" . $row['CUSTPHONE'] . "</td>";
                        echo "<td>" . $row['CUSTADDRESS'] . "</td>";
                ?>
                        <td>
                            <a href="adminCustDetail.php?viewID=<?php echo $row['CUSTID']; ?>" class="btn btn-primary">View</a>
                        </td>

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
                <a class="btn btn-success" type="button" href="adminAddCust.php">Add Customer</a>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>