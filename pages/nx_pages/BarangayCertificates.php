<?php
session_start();
require '../db_connect.php';
$currentPage = 'certs'; // Change this value based on the current page

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

// Get the page from the query parameter, default to 'home'
$page = isset($_GET['page']) ? $_GET['page'] : 'barangay_official';

// Ensure the page is valid to prevent security issues
$valid_pages = ['clearance', 'indigency', 'residency', 'business_permit', 'livestock_sale', 'land', 'vehicle']; // Add other valid pages here

if (!in_array($page, $valid_pages)) {
    $page = 'barangay_official'; // Fallback to 'home' if the page is invalid
}

$treeView = $page;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barangay Certificate</title>
    <?php 
        include_once "../headers.php"
    ?>
</head>
<body class="bg-gray-100 overflow-y-hidden">
    <?php
        include_once("../navbar.php")
    ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto mb-8">
             <?php 
            // Include the corresponding page content
            include_once("../nx_pages/nx_barangay_certs/{$page}.php"); 
            ?>
        </main>
    </div>

    <!-- If meron na javascript dito nalang mag add wag na sa header.php -->
</body>
</html>
