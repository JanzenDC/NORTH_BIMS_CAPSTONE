<?php
session_start();
$currentPage = 'backup'; // Change this value based on the current page

require '../db_connect.php';

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
    <title>Backup</title>
    <?php 
        include_once "../headers.php";
    ?>
    <!-- Include DataTables CSS and JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Include SweetAlert CSS and JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 overflow-hidden">
    <?php
        include_once("../navbar.php");
    ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>

        <main class="flex-1 p-6 overflow-y-auto mb-24">
            <div class='p-4 bg-white h-full'>
                <h1 class="text-xl font-bold mb-4">Backup Data</h1>
                <!-- Backup Button -->
                <form action="nx_query/backup.php" method="post" class='mb-3'>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Backup
                    </button>
                </form>

                <!-- DataTables for logs -->
                <table id="logsTable" class="display" style='width: 100%;'>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>User</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch logs from the database
                        $query = "SELECT * FROM tbllogs WHERE action = 'Backup' ORDER BY logdate DESC";
                        $result = mysqli_query($conn, $query);

                        if (!$result) {
                            // Display error message
                            echo "Error executing query: " . mysqli_error($conn);
                        } else {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$row['logdate']}</td>
                                        <td>{$row['user']}</td>
                                        <td>{$row['action']}</td>
                                    </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

<script>
$(document).ready(function() {
    $('#logsTable').DataTable();

    // Handle form submission for backup
    $('form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            xhrFields: {
                responseType: 'blob' // Set response type to blob for downloading files
            },
            success: function(response, status, xhr) {
                // Handle the file download
                const filename = xhr.getResponseHeader('Content-Disposition').split('filename=')[1].replace(/"/g, '');
                const blob = new Blob([response]);
                const link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
                
                // Show success message
                Swal.fire({
                    title: 'Success!',
                    text: response.message,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred while processing your request.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });
    });
});
</script>

</body>
</html>
