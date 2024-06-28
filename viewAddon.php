<!DOCTYPE html>
<?php
session_start();

require_once('config.php');
$sql = "Select * from ADDON";
$result = mysqli_query($conn, $sql);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">
                <img src="resource/logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                SPORTFUSION
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="checkTime.php">Book</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="viewSport.php">Sport</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6 text-center">View Student</h2>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="table-dark">
                                <tr class="bg-dark text-white">
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <td><?php echo $row['ADDONID']; ?></td>
                                        <td><?php echo $row['ADDONNAME']; ?></td>
                                        <td><?php echo $row['ADDONPRICE']; ?></td>
                                        <td><?php echo $row['ADDONQUANTITY']; ?></td>

                                        <td><a href="updateAddon.php?updateID=<?php echo $row['ADDONID']; ?>" class="btn btn-primary">Edit</a></td>
                                </tr>
                            <?php
                                    }
                            ?>
                            </tbody>
                        </table>


                        <div class="d-grid gap-2 d-md-block">
                            <a class="btn btn-success" type="button" href="formStudent.php">Insert New Addon</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>