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
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <?php 
        include_once "../headers.php"
    ?>
  </head>
  <body class="bg-gray-100 overflow-hidden">
    <?php
        include_once("../navbar.php")
    ?>
    <div class="flex h-screen">
      <!-- Sidebar -->
      <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>
      <!-- Main Content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <h1 class="text-2xl card-label font-bold">
          Welcome,
          <?php echo htmlspecialchars($_SESSION['user']['fname']); ?>!
        </h1>
        <div class="bg-green-600 text-white py-3 rounded-xl shadow-md mt-5">
          <div class="flex justify-between items-center px-4">
            <h1 id="dateDisplay" class="text-xl font-bold"></h1>
            <div class="relative">
              <i class="fas fa-bell w-6 h-7"></i>
              <span
                class="absolute top-0 left-3 bottom-2 right-0 inline-flex items-center justify-center w-4 h-4 bg-red-600 rounded-full text-white text-xs"
                >3</span
              >
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
          <!-- Barangay Officials Card -->
            <div class="bg-white p-4 shadow rounded-lg shadow-md">
                <h2 class="font-bold text-2xl card-label">Barangay Officials</h2>
                <div class="border-t-2 line-border h-1 my-1"></div>

                <div
                    class="grid grid-cols-3 gap-4 text-center mt-4 scroll-bar"
                    style="max-height: 290px; overflow-y: auto"
                >
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            // Combine names into a full name
                            $fullName = trim($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname'] . ' ' . $row['suffix']);
                            ?>
                            <!-- <?php
                            // Debugging output
                            echo " Debug: Image URL: " . htmlspecialchars($row['image']) . "";
                            ?> -->
                            <div>
                                <div class="relative inline-block">
                                    <img
                                        class="rounded-full border-2 border-green-600"
                                        height="80"
                                        src='../../assets/images/pfp/<?php echo htmlspecialchars($row['image']); ?>'
                                        width="80"
                                        alt="<?php echo htmlspecialchars($fullName); ?>"
                                    />
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

          <!--Upcomming Events-->
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
                                        <!-- day -->
                                        <h1 class="text-white text-2xl font-bold text-center">
                                            <?php echo htmlspecialchars($day); ?>
                                        </h1>
                                        <!-- month -->
                                        <p class="text-white text-xs font-semibold text-center">
                                            <?php echo htmlspecialchars($month); ?>
                                        </p>
                                    </div>
                                    <div>
                                        <!-- Event title -->
                                        <h4 class="font-semibold"><?php echo htmlspecialchars($row['activity']); ?></h4>
                                        <!-- Description -->
                                        <p class="text-sm"><?php echo htmlspecialchars($row['description']); ?></p>
                                        <!-- Optional image -->
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

        </main>
    </div>


            
            
            
          </div>

          <!--Total Residents in Barangay Chart-->
          <div class="bg-white p-4 shadow rounded-lg shadow-md">
            <h2 class="font-bold text-2xl card-label">
              Total Residents in Barangay
            </h2>
            <div class="border-t-2 line-border h-1 my-1"></div>

            <div
              class="text-center mt-4 scroll-bar"
              style="max-height: 290px; overflow-y: auto"
            ></div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>

<style>

.card-label{
color:#30c758;
}
.line-border{
    border-color:#30c758;
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
            // Create a date object for the current time
            const now = new Date();

            // Options for formatting the date
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

            // Format the date
            const formattedDate = now.toLocaleString('en-US', options);

            // Display the formatted date in the h1 element
            document.getElementById('dateDisplay').textContent = formattedDate;
        }

        // Update the date immediately
        updateDate();
        // Set an interval to update the date every second
        setInterval(updateDate, 1000);
</script>