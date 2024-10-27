<?php
session_start();
$currentPage = 'logs'; // Change this value based on the current page
require '../db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

$sqlLogs = "SELECT * FROM tbllogs ORDER BY logdate DESC";
$resultLogs = $conn->query($sqlLogs);

$logsData = [];
if ($resultLogs->num_rows > 0) {
    while ($row = $resultLogs->fetch_assoc()) {
        $logsData[] = $row;
    }
}
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
        <main class="flex-1 p-6 h-dvh overflow-y-auto">
            
            <div class='w-full bg-white p-4 mb-14'>
                <p class='text-2xl mb-3'>System Logs</p>
                <table id="sysLogs" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logsData as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['user']); ?></td>
                                <td>
                                    <?php 
                                        // Assuming $row['logdate'] is a valid date string or timestamp
                                        $formattedDate = date('F j, Y h:i A', strtotime($row['logdate'])); 
                                        echo htmlspecialchars($formattedDate); 
                                    ?>
                                </td>
                                <td><?php echo htmlspecialchars($row['action']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </main>
    </div>

    <script>
        $(document).ready(function() {
            $('#sysLogs').DataTable({
                "scrollX": true
            });
        });
    </script>
    <!-- If meron na javascript dito nalang mag add wag na sa header.php -->
</body>
</html>
