<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <main class="flex-1 p-6">
            <h1 class="text-2xl font-bold">Welcome, <?php echo htmlspecialchars($_SESSION['user']['fname']); ?>!</h1>
            <p class="mt-4 text-gray-600">Here you can manage your account settings, view statistics, and more.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-6">
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-semibold">Card 1</h2>
                    <p class="text-gray-600">Some information about this card.</p>
                </div>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-semibold">Card 2</h2>
                    <p class="text-gray-600">Some information about this card.</p>
                </div>
                <div class="bg-white p-4 shadow rounded">
                    <h2 class="font-semibold">Card 3</h2>
                    <p class="text-gray-600">Some information about this card.</p>
                </div>
            </div>

            
        </main>
    </div>

</body>
</html>
