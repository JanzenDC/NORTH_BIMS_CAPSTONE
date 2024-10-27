<?php
session_start();
require '../db_connect.php';
$currentPage = 'dashboard'; // Change this value based on the current page

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}

$user = $_SESSION['user'];
$sql = "SELECT * FROM tblofficial";
$result = $conn->query($sql);

$sqlActivities = "SELECT * FROM tblactivity ORDER BY dateofactivity ASC LIMIT 5";
$resultActivities = $conn->query($sqlActivities);

// Query to get the count of unapproved accounts
$query = "SELECT COUNT(*) as count FROM tblregistered_account WHERE isApproved = 0";
$results = $conn->query($query);
$row = $results->fetch_assoc();
$error = '';
if ($row['count'] > 0) {
    $count = $row['count'];
    $error = '
    <div class="bg-red-300 w-full flex justify-between text-red-800 p-4 border border-red-800 rounded-lg">
        <div>
            There ' . ($count === 1 ? 'is' : 'are') . " $count account" . ($count === 1 ? '' : 's') . " that need approval. Click <a class='font-bold cursor-pointer' href='UserAccounts.php?page=useraccounts'>here</a> to view.
        </div>
    </div>";
}

// New query to fetch total residents per year based on year_stayed
$queryResidents = "
    SELECT year_stayed AS year, COUNT(*) AS total_residents
    FROM residents
    GROUP BY year_stayed
    ORDER BY year_stayed;
";

$resultResidents = $conn->query($queryResidents);
$residentData = [];
if ($resultResidents) {
    while ($row = $resultResidents->fetch_assoc()) {
        $residentData[] = $row;
    }
}

// New query to fetch total blotter reports per month
$queryBlotter = "
    SELECT MONTH(date) AS month, COUNT(*) AS total_reports
    FROM tblblotter
    GROUP BY MONTH(date)
    ORDER BY MONTH(date);
";
$resultBlotter = $conn->query($queryBlotter);
$blotterData = array_fill(0, 12, 0); // Initialize an array for 12 months

if ($resultBlotter) {
    while ($row = $resultBlotter->fetch_assoc()) {
        $blotterData[$row['month'] - 1] = (int)$row['total_reports']; // Fill the respective month
    }
}

// Close the connection
$conn->close();

// Convert the resident and blotter data to JSON format for use in the JavaScript chart
$residentDataJson = json_encode($residentData);
$blotterDataJson = json_encode($blotterData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <?php include_once "../headers.php"; ?>
</head>
<body class="bg-gray-100 overflow-hidden">
    <?php include_once("../navbar.php"); ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once("../nx_sidebar/sidebar.php"); ?>
        <!-- Main Content -->

        <main class="flex-1 p-6 overflow-y-auto mb-6">
            <?= $error ?>

            <h1 class="text-2xl card-label font-bold">
                Welcome, <?php echo htmlspecialchars($_SESSION['user']['fname']); ?>!
            </h1>
            <div class="bg-green-600 text-white py-3 rounded-xl shadow-md mt-5">
                <div class="flex justify-between items-center px-4">
                    <h1 id="dateDisplay" class="text-xl font-bold"></h1>
                    <div class="relative">
                        <i class="fas fa-bell w-6 h-7"></i>
                        <span class="absolute top-0 left-3 bottom-2 right-0 inline-flex items-center justify-center w-4 h-4 bg-red-600 rounded-full text-white text-xs">3</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6 mb-[80px]">
                <!-- Barangay Officials Card -->
                <div class="bg-white p-4 shadow rounded-lg shadow-md">
                    <h2 class="font-bold text-2xl card-label">Barangay Officials</h2>
                    <div class="border-t-2 line-border h-1 my-1"></div>

                    <div class="grid grid-cols-3 gap-4 text-center mt-4 scroll-bar" style="max-height: 290px; overflow-y: auto">
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                $fullName = trim($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' ' . $row['suffix']);
                                ?>
                                <div>
                                    <div class="relative inline-block">
                                        <img class="rounded-full border-2 border-green-600" height="80" src='../../assets/images/pfp/<?php echo htmlspecialchars($row['image']); ?>' width="80" alt="<?php echo htmlspecialchars($fullName); ?>" />
                                    </div>
                                    <div class="mt-2">
                                        <div class="font-bold text-sm mb-sm p-1"><?php echo htmlspecialchars($fullName); ?></div>
                                        <div class="text-xs text-gray-600"><?php echo htmlspecialchars($row['position']); ?></div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div>No officials found</div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Upcoming Activities -->
                <div class="bg-white p-4 shadow rounded-lg shadow-md">
                    <h2 class="font-bold text-2xl card-label">Upcoming Activities</h2>
                    <div class="border-t-2 line-border h-1 my-1"></div>

                    <div class="mt-4 scroll-bar" style="height: 100%; max-height: 290px; overflow-y: auto">
                        <?php
                        if ($resultActivities->num_rows > 0) {
                            while ($row = $resultActivities->fetch_assoc()) {
                                $activityDate = new DateTime($row['dateofactivity']);
                                $day = $activityDate->format('d');
                                $month = $activityDate->format('F'); // Full month name
                                ?>
                                <div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                                    <div class="flex gap-10">
                                        <div class="bg-green-500 justify-center border w-28 py-[3px] px-[10px]">
                                            <h1 class="text-white text-2xl font-bold text-center"><?php echo htmlspecialchars($day); ?></h1>
                                            <p class="text-white text-xs font-semibold text-center"><?php echo htmlspecialchars($month); ?></p>
                                        </div>
                                        <div>
                                            <h4 class="font-semibold"><?php echo htmlspecialchars($row['activity']); ?></h4>
                                            <p class="text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "<div>No upcoming activities found</div>";
                        }
                        ?>
                    </div>
                </div>

                <!-- Total Residents in Barangay Chart -->
                <div class="bg-white p-4 shadow rounded-lg shadow-md">
                    <h2 class="font-bold text-2xl card-label">Total Residents in Barangay</h2>
                    <div class="border-t-2 line-border h-1 my-1"></div>

                    <div class="text-center mt-4 scroll-bar" style="max-height: 290px; overflow-y: auto">
                        <div>
                            <canvas id="barangayChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Total Blotter Reports per Month -->
                <div class="bg-white p-4 shadow rounded-lg shadow-md">
                    <h2 class="font-bold text-2xl card-label">Total Blotter Reports per Month</h2>
                    <div class="border-t-2 line-border h-1 my-1"></div>

                    <div class="text-center mt-4 scroll-bar" style="max-height: 290px; overflow-y: auto">
                        <div>
                            <canvas id="blotterChart"></canvas>
                        </div>
                    </div>
                </div>

            </main>
        </div>

    </body>
</html>

<style>
.card-label {
    color: #30c758;
}
.line-border {
    border-color: #30c758;
}

/* Custom scroll styling for WebKit browsers */
.scroll-bar::-webkit-scrollbar {
    width: 8px; /* Width of the scrollbar */
}

.scroll-bar::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Background of the track */
    border-radius: 10px;
}

.scroll-bar::-webkit-scrollbar-thumb {
    background-color: #4CAF50; /* Thumb color */
    border-radius: 10px; /* Rounded edges */
}

.scroll-bar::-webkit-scrollbar-thumb:hover {
    background-color: #45a049; /* Thumb hover color */
}

/* Custom scroll styling for Firefox */
.scroll-bar {
    scrollbar-width: thin; /* Thin scrollbar */
    scrollbar-color: #4CAF50 #f1f1f1; /* Thumb color and track color */
}
</style>

    <script>
    // Function to update the date and time
    function updateDate() {
        const now = new Date();
        const options = { 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        };
        const formattedDate = now.toLocaleString('en-US', options);
        document.getElementById('dateDisplay').textContent = formattedDate;
    }

    // Update the date immediately
    updateDate();
    // Set an interval to update the date every second
    setInterval(updateDate, 1000);

    // Wait for the DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Define Utils object with necessary properties
        const Utils = {
            CHART_COLORS: {
                blue: 'rgb(54, 162, 235)',
                red: 'rgb(255, 99, 132)'
            },
            transparentize: (color, opacity) => {
                const alpha = opacity === undefined ? 0.5 : 1 - opacity;
                return color.replace('rgb', 'rgba').replace(')', `, ${alpha})`);
            }
        };

        // Resident Chart
        const residentData = <?php echo $residentDataJson; ?>;
        const years = residentData.map(item => item.year);
        const residents = residentData.map(item => item.total_residents);

        const residentChartConfig = {
            type: 'line',
            data: {
                labels: years,
                datasets: [{
                    label: 'Total Residents',
                    data: residents,
                    borderColor: Utils.CHART_COLORS.blue,
                    backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
                    pointStyle: 'circle',
                    pointRadius: 10,
                    pointHoverRadius: 15,
                    fill: 'start'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Residents in Barangay (by Year Stayed)'
                    }
                },
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Residents'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Year'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('barangayChart'), residentChartConfig);

        // Blotter Chart
        const blotterData = <?php echo $blotterDataJson; ?>;

        const blotterChartConfig = {
            type: 'bar',
            data: {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                datasets: [{
                    label: 'Blotter Reports',
                    data: blotterData,
                    backgroundColor: Utils.CHART_COLORS.red,
                    borderColor: Utils.CHART_COLORS.red,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Total Blotter Reports per Month'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        title: {
                            display: true,
                            text: 'Number of Reports'
                        },
                        beginAtZero: true
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                }
            }
        };

        new Chart(document.getElementById('blotterChart'), blotterChartConfig);
    });
    </script>