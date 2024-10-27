<?php
session_start();
$currentPage = 'blotter'; // Change this value based on the current page
require '../db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); 
    exit();
}
$user = $_SESSION['user'];

$sqlNew = "SELECT * FROM tblblotter WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlDismissed = "SELECT * FROM tblblotter WHERE status = 'Dismissed'";
$resultDismissed = $conn->query($sqlDismissed);
$dismissedData = $resultDismissed->fetch_all(MYSQLI_ASSOC);

$sqlReferred = "SELECT * FROM tblblotter WHERE status = 'Referred'";
$resultReferred = $conn->query($sqlReferred);
$referredData = $resultReferred->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blotter Page</title>
    <?php 
        include_once "../headers.php";
    ?>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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

        <!-- Main Content -->
        <main class="flex-1 p-6 h-dvh overflow-y-auto">
            <div class='w-full bg-white p-4 mb-14'>
                <p class='text-2xl mb-3'>Blotter</p>

                <!-- Add Blotter Button -->
                <button id='openBlotter' class='bg-yellow-500 text-white p-3 rounded-md w-32 mb-4'>
                    <i class="fa-solid fa-plus"></i> Add Blotter
                </button>

                <div id="tabs" class="container mt-4">
                    <ul>
                        <li><a href="#allcase">All Cases</a></li>
                        <li><a href="#dismiss">Dismissed</a></li>
                        <li><a href="#refer">Referred</a></li>
                    </ul>

                    <div id="allcase">
                        <table id="allCases" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Complainant</th>
                                    <th>Person to Complaint</th>
                                    <th>Complaint</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($newData as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['complainant']); ?><br><small>Address: <?php echo htmlspecialchars($row['caddress']); ?></small></td>
                                    <td><?php echo htmlspecialchars($row['personToComplaint']); ?><br><small>Address: <?php echo htmlspecialchars($row['paddress']); ?></small></td>
                                    <td>
                                        <?php 
                                        $complaintText = htmlspecialchars($row['complaint']);
                                        echo (strlen($complaintText) > 20) ? substr($complaintText, 0, 20) . '...' : $complaintText; 
                                        ?>
                                        <?php if (strlen($complaintText) > 20): ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Complaint" onclick="openDialog('<?php echo addslashes($complaintText); ?>')">👁️</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                    <td class="flex space-x-2">
                                        <a class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</a>
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="setDismissed(<?php echo htmlspecialchars($row['id']); ?>)">Disapproved</button>
                                        <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" onclick="setReferred(<?php echo htmlspecialchars($row['id']); ?>)">Referred</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="dismiss">
                        <table id="dismissedCases" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Complainant</th>
                                    <th>Person to Complaint</th>
                                    <th>Complaint</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dismissedData as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['complainant']); ?><br><small>Address: <?php echo htmlspecialchars($row['caddress']); ?></small></td>
                                    <td><?php echo htmlspecialchars($row['personToComplaint']); ?><br><small>Address: <?php echo htmlspecialchars($row['paddress']); ?></small></td>
                                    <td>
                                        <?php 
                                        $complaintText = htmlspecialchars($row['complaint']);
                                        echo (strlen($complaintText) > 20) ? substr($complaintText, 0, 20) . '...' : $complaintText; 
                                        ?>
                                        <?php if (strlen($complaintText) > 20): ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Complaint" onclick="openDialog('<?php echo addslashes($complaintText); ?>')">👁️</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="refer">
                        <table id="referredCases" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Complainant</th>
                                    <th>Person to Complaint</th>
                                    <th>Complaint</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($referredData as $row): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['complainant']); ?><br><small>Address: <?php echo htmlspecialchars($row['caddress']); ?></small></td>
                                    <td><?php echo htmlspecialchars($row['personToComplaint']); ?><br><small>Address: <?php echo htmlspecialchars($row['paddress']); ?></small></td>
                                    <td>
                                        <?php 
                                        $complaintText = htmlspecialchars($row['complaint']);
                                        echo (strlen($complaintText) > 20) ? substr($complaintText, 0, 20) . '...' : $complaintText; 
                                        ?>
                                        <?php if (strlen($complaintText) > 20): ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Complaint" onclick="openDialog('<?php echo addslashes($complaintText); ?>')">👁️</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['action']); ?></td>
                                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Dialog for Adding Blotter -->
    <div id="addBlotterDialog" title="Add Blotter" style="display:none;" class="p-6 bg-white rounded-lg shadow-lg">
        <form id="blotterForm" class="space-y-4">
            <div>
                <label for="complainant" class="block text-sm font-medium text-gray-700">Complainant Name:</label>
                <input type="text" id="complainant" name="complainant" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="cAddress" class="block text-sm font-medium text-gray-700">Complainant Address:</label>
                <input type="text" id="cAddress" name="cAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="personToComplaint" class="block text-sm font-medium text-gray-700">Person to Complaint:</label>
                <input type="text" id="personToComplaint" name="personToComplaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="pAddress" class="block text-sm font-medium text-gray-700">Complainee Address:</label>
                <input type="text" id="pAddress" name="pAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="complaint" class="block text-sm font-medium text-gray-700">Complaint:</label>
                <textarea id="complaint" name="complaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div>
                <label for="action" class="block text-sm font-medium text-gray-700">Action:</label>
                <select id="action" name="action" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="Brgy. Captain">Brgy. Captain</option>
                    <option value="Lupon">Lupon</option>
                    <option value="Police">Police</option>
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status:</label>
                <select id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="New">New</option>
                    <option value="Dismissed">Dismissed</option>
                    <option value="Referred">Referred</option>
                </select>
            </div>
        </form>
    </div>


    <div id="dialog" title="Complaint Details" style="display:none;">
        <p id="dialog-content"></p>
    </div>

    <script>
        $(document).ready(function() {
            $('#allCases, #dismissedCases, #referredCases').DataTable({
                "scrollX": true,
                "searching": true
            });
            $("#tabs").tabs();

            $("#dialog").dialog({
                autoOpen: false,
                modal: true,
                width: 400,
                
            });

            $("#addBlotterDialog").dialog({
                autoOpen: false,
                modal: true,
                width: 500,
                height: 650,
                buttons: {
                    "Add Blotter": function() {
                        
                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });

            $('#openBlotter').on('click', function() {
                $("#addBlotterDialog").dialog("open");
            });
        });

        function openDialog(complaintText) {
            $("#dialog-content").text(complaintText);
            $("#dialog").dialog("open");
        }
    </script>
</body>
</html>
