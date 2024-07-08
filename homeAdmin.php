<!DOCTYPE html>
<html lang="en">
<?php
include "config.php";

// pending payment
$sqlGetPending = $conn->prepare("select COUNT(PAYMENTID) as totalPending from payment where PAYMENTSTATUS='PENDING'");
$sqlGetPending->execute();
$resGetPending = $sqlGetPending->get_result();

// total income
$sqlGetTotal = $conn->prepare("select SUM(PAYMENTTOTAL) as totalPay from payment where PAYMENTSTATUS='PAID'");
$sqlGetTotal->execute();
$resGetTotal = $sqlGetTotal->get_result();

// total registered customer
$sqlGetCust = $conn->prepare("select COUNT(CUSTID) as totalCust from CUSTOMER");
$sqlGetCust->execute();
$resGetCust = $sqlGetCust->get_result();

// total suspended court
$sqlSuspended = $conn->prepare("select COUNT(FACID) as suspended from FACILITY WHERE FACSTATUS='SUSPENDED'");
$sqlSuspended->execute();
$resSuspended = $sqlSuspended->get_result();

/*
*
*
*
*
*
*
sql chart1
*/

$sql = "select A.ADDONNAME, SUM(BA.QUANTITY) AS total
        FROM addon A 
        JOIN booking_addon BA 
        ON A.ADDONID = BA.ADDONID
        GROUP BY ADDONNAME";
$result = $conn->query($sql);

$addonNames = [];
$totals = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $addonNames[] = $row['ADDONNAME'];
        $totals[] = $row['total'];
    }
}

// Convert PHP arrays to JSON
$addonNamesJson = json_encode($addonNames);
$totalsJson = json_encode($totals);


/*
*
*
*
*
*
*
*
*
*
sql chartArea
*/
// Fetch data for 'PAID' bookings grouped by month
$sqlSeries1 = "
    SELECT DATE_FORMAT(PAYMENTDATE, '%Y-%m') AS payment_month, COUNT(BOOKINGID) AS total_paid
    FROM PAYMENT
    WHERE PAYMENTSTATUS = 'PAID'
    GROUP BY payment_month
    ORDER BY payment_month";
$result1 = $conn->query($sqlSeries1);

$paidMonths = [];
$paidTotals = [];

if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        $paidMonths[] = $row['payment_month'];
        $paidTotals[] = $row['total_paid'];
    }
}

// Fetch data for 'CANCELLED' bookings grouped by month
$sqlSeries2 = "
    SELECT DATE_FORMAT(PAYMENTDATE, '%Y-%m') AS payment_month, COUNT(BOOKINGID) AS total_cancelled
    FROM PAYMENT
    WHERE PAYMENTSTATUS = 'CANCELLED'
    GROUP BY payment_month
    ORDER BY payment_month";
$result2 = $conn->query($sqlSeries2);

$cancelledMonths = [];
$cancelledTotals = [];

if ($result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $cancelledMonths[] = $row['payment_month'];
        $cancelledTotals[] = $row['total_cancelled'];
    }
}

$conn->close();
$monthsJson = json_encode($paidMonths);
$paidTotalsJson = json_encode($paidTotals);
$cancelledTotalsJson = json_encode($cancelledTotals);
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="testStyle.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        h3 {
            font-weight: 500;
            font-size: 20px;
        }

        h1 {
            font-weight: 800;
            color: #000000;
            font-size: 30px;
        }
    </style>
</head>

<body>
    <div class="grid-container">
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

        <main class="main-container">

            <div class="main-cards">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">PENDING PAYMENT</>
                            <?php
                            if ($resGetPending->num_rows > 0) {
                                while ($row = $resGetPending->fetch_assoc()) {
                                    echo "<h1>" . $row['totalPending'] . "</h1>";
                                }
                            } else {
                                echo "<h1>No pending payment found</h1>";
                            }
                            ?>
                            <a href="adminPendingPayment.php" class="card-link btn btn-dark">View</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">GROSS INCOME</h3>
                        <?php
                        if ($resGetTotal->num_rows > 0) {
                            while ($row = $resGetTotal->fetch_assoc()) {
                                echo "<h1>RM" . $row['totalPay'] . "</h1>";
                            }
                        } else {
                            echo "<h1>No pending payment found</h1>";
                        }
                        ?>
                        <a href="adminViewPayment.php" class="card-link btn btn-dark">View</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">CUSTOMER</h3>
                        <?php
                        if ($resGetCust->num_rows > 0) {
                            while ($row = $resGetCust->fetch_assoc()) {
                                echo "<h1>" . $row['totalCust'] . "</h1>";
                            }
                        } else {
                            echo "<h1>No customer registered</h1>";
                        }
                        ?>
                        <a href="adminViewCust.php" class="card-link btn btn-dark">View</a>
                    </div>
                </div>
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">SUSPENDED COURT</h3>
                        <?php
                        if ($resSuspended->num_rows > 0) {
                            while ($row = $resSuspended->fetch_assoc()) {
                                echo "<h1>" . $row['suspended'] . "</h1>";
                            }
                        } else {
                            echo "<h1>No customer registered</h1>";
                        }
                        ?>
                        <a href="adminEditFac.php" class="card-link btn btn-dark">View</a>
                    </div>
                </div>
            </div>

            <div class="charts">

                <div class="charts-card">
                    <h2 class="chart-title">Top 5 Addons</h2>
                    <div id="bar-chart"></div>
                </div>

                <div class="charts-card">
                    <h2 class="chart-title">Paid and Cancelled Booking</h2>
                    <div id="area-chart"></div>
                </div>
            </div>
        </main>
    </div>



    <script>
        // Get the PHP data
        const addonNames = <?php echo $addonNamesJson; ?>;
        const totals = <?php echo $totalsJson; ?>;

        // BAR CHART
        const barChartOptions = {
            series: [{
                data: totals,
                name: 'Total Usage',
            }, ],
            chart: {
                type: 'bar',
                background: 'transparent',
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            colors: ['#2962ff', '#d50000', '#2e7d32', '#ff6d00', '#583cb3'],
            plotOptions: {
                bar: {
                    distributed: true,
                    borderRadius: 4,
                    horizontal: false,
                    columnWidth: '40%',
                },
            },
            dataLabels: {
                enabled: false,
            },
            fill: {
                opacity: 1,
            },
            grid: {
                borderColor: '#55596e',
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            legend: {
                labels: {
                    colors: '#f5f7ff',
                },
                show: true,
                position: 'top',
            },
            stroke: {
                colors: ['transparent'],
                show: true,
                width: 2,
            },
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'dark',
            },
            xaxis: {
                categories: addonNames,
                title: {
                    style: {
                        color: '#f5f7ff',
                    },
                },
                axisBorder: {
                    show: true,
                    color: '#55596e',
                },
                axisTicks: {
                    show: true,
                    color: '#55596e',
                },
                labels: {
                    style: {
                        colors: '#f5f7ff',
                    },
                },
            },
            yaxis: {
                tickAmount: 10, // Set the number of ticks based on the highest total
                labels: {
                    formatter: function(val) {
                        return Math.round(val); // Round the values to the nearest integer
                    },
                    style: {
                        colors: '#f5f7ff',
                    },
                },
                title: {
                    text: 'Total Usage',
                    style: {
                        color: '#f5f7ff',
                    },
                },
                axisBorder: {
                    color: '#55596e',
                    show: true,
                },
                axisTicks: {
                    color: '#55596e',
                    show: true,
                },
            },
        };

        const barChart = new ApexCharts(
            document.querySelector('#bar-chart'),
            barChartOptions
        );
        barChart.render();

        // Get the PHP data
        const months = <?php echo $monthsJson; ?>;
        const paidTotals = <?php echo $paidTotalsJson; ?>;
        const cancelledTotals = <?php echo $cancelledTotalsJson; ?>;

        // AREA CHART
        const areaChartOptions = {
            series: [{
                    name: 'Paid Bookings',
                    data: paidTotals,
                },
                {
                    name: 'Cancelled Bookings',
                    data: cancelledTotals,
                },
            ],
            chart: {
                type: 'area',
                background: 'transparent',
                height: 350,
                stacked: false,
                toolbar: {
                    show: false,
                },
            },
            colors: ['#00ab57', '#d50000'],
            labels: months,
            dataLabels: {
                enabled: false,
            },
            fill: {
                gradient: {
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    shadeIntensity: 1,
                    stops: [0, 100],
                    type: 'vertical',
                },
                type: 'gradient',
            },
            grid: {
                borderColor: '#55596e',
                yaxis: {
                    lines: {
                        show: true,
                    },
                },
                xaxis: {
                    lines: {
                        show: true,
                    },
                },
            },
            legend: {
                labels: {
                    colors: '#f5f7ff',
                },
                show: true,
                position: 'top',
            },
            markers: {
                size: 6,
                strokeColors: '#1b2635',
                strokeWidth: 3,
            },
            stroke: {
                curve: 'smooth',
            },
            xaxis: {
                axisBorder: {
                    color: '#55596e',
                    show: true,
                },
                axisTicks: {
                    color: '#55596e',
                    show: true,
                },
                labels: {
                    offsetY: 5,
                    style: {
                        colors: '#f5f7ff',
                    },
                },
            },
            yaxis: [{
                title: {
                    text: 'Paid Bookings',
                    style: {
                        color: '#f5f7ff',
                    },
                },
                labels: {
                    style: {
                        colors: ['#f5f7ff'],
                    },
                },
            }, ],
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'dark',
            },
        };

        const areaChart = new ApexCharts(
            document.querySelector('#area-chart'),
            areaChartOptions
        );
        areaChart.render();
    </script>
</body>

</html>