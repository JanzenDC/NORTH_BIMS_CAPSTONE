<?php
session_start();
// Include database connection
require '../db_connect.php';
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

// Fetch activities from the database
$sql = "SELECT * FROM tblactivity ORDER BY dateofactivity DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <?php include_once "../headers.php"; ?>
    <style>
        .hover-scale:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body class="bg-gray-100 overflow-hidden">
    <?php include_once("../navbar.php"); ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include_once("../nx_sidebar/sidebar.php"); ?>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold mb-4">Dashboard</h1>
            
            <!-- Steps in Requesting Barangay Certificates -->
            <div class="mb-6">
                <h3 class="text-xl font-semibold mb-4">Steps in Requesting Barangay Certificates</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="bg-green-100 p-4 rounded shadow hover-scale transition-transform duration-300 flex items-center">
                        <div class="text-green-500 text-2xl"><i class="fa fa-check-circle"></i></div>
                        <p class="ml-2">Create an account and login.</p>
                    </div>
                    <div class="flex items-center md:justify-between">
                        <div class="hidden md:block text-gray-500"><i class="fas fa-arrow-right"></i></div>
                        <div class="bg-blue-100 p-4 rounded shadow hover-scale transition-transform duration-300 flex items-center w-full">
                            <div class="text-blue-500 text-2xl"><i class="fa fa-file-text"></i></div>
                            <p class="ml-2">Choose the certificate type you want to request.</p>
                        </div>
                    </div>
                    <div class="flex items-center md:justify-between">
                        <div class="hidden md:block text-gray-500"><i class="fas fa-arrow-right"></i></div>
                        <div class="bg-yellow-100 p-4 rounded shadow hover-scale transition-transform duration-300 flex items-center w-full">
                            <div class="text-yellow-500 text-2xl"><i class="fa fa-pencil-square-o"></i></div>
                            <p class="ml-2">Fill up the needed information.</p>
                        </div>
                    </div>
                    <div class="flex items-center md:justify-between">
                        <div class="hidden md:block text-gray-500"><i class="fas fa-arrow-right"></i></div>
                        <div class="bg-orange-100 p-4 rounded shadow hover-scale transition-transform duration-300 flex items-center w-full">
                            <div class="text-orange-500 text-2xl"><i class="fas fa-hourglass-half"></i></div>
                            <p class="ml-2">Wait for the approval of the admin.</p>
                        </div>
                    </div>
                    <div class="flex items-center md:justify-between">
                        <div class="hidden md:block text-gray-500"><i class="fas fa-arrow-right"></i></div>
                        <div class="bg-purple-100 p-4 rounded shadow hover-scale transition-transform duration-300 flex items-center w-full">
                            <div class="text-purple-500 text-2xl"><i class="fa fa-handshake"></i></div>
                            <p class="ml-2">Pick up the certificate at Barangay Hall.</p>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="text-2xl font-bold mb-4">Activities</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="bg-white p-4 rounded shadow">
                            <img src="../../assets/images/activity/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['activity']); ?>" class="w-full h-32 object-cover rounded-t">
                            <h2 class="text-lg font-semibold mt-2"><?php echo htmlspecialchars($row['activity']); ?></h2>
                            <p class="text-gray-600"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="text-gray-400 text-sm"><?php echo htmlspecialchars($row['dateofactivity']); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No activities found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <?php $conn->close(); // Close database connection ?>
</body>
</html>
