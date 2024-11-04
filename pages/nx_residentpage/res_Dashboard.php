<?php
session_start();
require '../db_connect.php';
// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

// Query to fetch activities
$sql = "SELECT dateofactivity, activity, description, image FROM tblactivity";
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
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
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
            <h1 class="text-xl font-bold mb-6">Steps in Requesting Barangay Certificates</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div class="card bg-blue-200 rounded-lg shadow-lg p-4">
                    <i class="fas fa-user-plus text-blue-500 text-3xl"></i>
                    <h2 class="font-semibold">Create an account</h2>
                    <p class="text-gray-600">and login.</p>
                </div>
                <div class="card bg-green-200 rounded-lg shadow-lg p-4">
                    <i class="fas fa-file-alt text-green-500 text-3xl"></i>
                    <h2 class="font-semibold">Choose the certificate</h2>
                    <p class="text-gray-600">type you want to request.</p>
                </div>
                <div class="card bg-yellow-200 rounded-lg shadow-lg p-4">
                    <i class="fas fa-pencil-alt text-yellow-500 text-3xl"></i>
                    <h2 class="font-semibold">Fill up the needed</h2>
                    <p class="text-gray-600">information.</p>
                </div>
                <div class="card bg-orange-200 rounded-lg shadow-lg p-4">
                    <i class="fas fa-clock text-orange-500 text-3xl"></i>
                    <h2 class="font-semibold">Wait for the approval</h2>
                    <p class="text-gray-600">of the admin.</p>
                </div>
                <div class="card bg-purple-200 rounded-lg shadow-lg p-4">
                    <i class="fas fa-home text-purple-500 text-3xl"></i>
                    <h2 class="font-semibold">Pick up the certificate</h2>
                    <p class="text-gray-600">at Barangay Hall.</p>
                </div>
            </div>


            <h1 class="text-xl font-bold mb-6">Upcoming Activities</h1>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($activity = $result->fetch_assoc()): ?>
                        <div class="card bg-gray-200 rounded-lg shadow-lg p-4 transition-transform duration-300 hover:scale-105">
                            <img src="../../assets/images/activity/<?php echo $activity['image']; ?>" alt="<?php echo htmlspecialchars($activity['activity'], ENT_QUOTES); ?>" class="cursor-pointer rounded-t-lg mb-2" onclick="openModal('<?php echo htmlspecialchars($activity['image'], ENT_QUOTES); ?>')">
                            <h2 class="font-semibold"><?php echo htmlspecialchars($activity['activity'], ENT_QUOTES); ?></h2>
                            <p class="text-gray-600"><?php echo htmlspecialchars($activity['description'], ENT_QUOTES); ?></p>
                            <p class="text-gray-500 text-sm"><?php echo date('F j, Y', strtotime($activity['dateofactivity'])); ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p class="text-gray-600">No activities found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <!-- Modal for image enlargement -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden justify-center items-center">
        <span class="absolute top-2 right-2 text-white cursor-pointer" onclick="closeModal()">&times;</span>
        <img id="modalImage" src="" alt="" class="max-w-full max-h-full">
    </div>

    <script>
        function openModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }
    </script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
