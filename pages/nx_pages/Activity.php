<?php
session_start();
$currentPage = 'activity'; // Change this value based on the current page

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
        <main class="flex-1 p-6 mb-8 overflow-y-auto">
            <div class='h-screen bg-white p-3'>
                <div class='bg-red-500 text-white p-3 rounded-md w-32'>
                    <i class="fa-solid fa-plus"></i> Add Activity
                </div>

                <div class='mt-5'>
                    <table id="activityTable" class="display" style="width:100%">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Date of Acitivity</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#activityTable').DataTable({
                "scrollX": true // Enable horizontal scrolling
            });
        });
    </script>
    <!-- If meron na javascript dito nalang mag add wag na sa header.php -->
</body>
</html>
