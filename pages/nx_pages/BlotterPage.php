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

$sqlNew = "SELECT * FROM tblblotter WHERE status = 'New' ORDER BY date DESC"; // Newest first
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlDismissed = "SELECT * FROM tblblotter WHERE status = 'Dismissed' ORDER BY date DESC"; // Newest first
$resultDismissed = $conn->query($sqlDismissed);
$dismissedData = $resultDismissed->fetch_all(MYSQLI_ASSOC);

$sqlReferred = "SELECT * FROM tblblotter WHERE status = 'Referred' ORDER BY date DESC"; // Newest first
$resultReferred = $conn->query($sqlReferred);
$referredData = $resultReferred->fetch_all(MYSQLI_ASSOC);

$sqlResched = "SELECT * FROM tblblotter WHERE status = 'Resched' ORDER BY date DESC"; // Newest first
$resultResched = $conn->query($sqlResched);
$reschedData = $resultResched->fetch_all(MYSQLI_ASSOC);

$sqlOngoing = "SELECT * FROM tblblotter WHERE status = 'Ongoing' ORDER BY date DESC"; // Newest first
$resultOngoing = $conn->query($sqlOngoing);
$ongoingData = $resultOngoing->fetch_all(MYSQLI_ASSOC);
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
                        <li><a href="#ongoing">OnGoing</a></li>
                        <li><a href="#rescheduled">Re-scheduled</a></li>
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
                                        <!-- <a class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200" title="Generate">
                                            <i class="fas fa-file-download"></i>
                                        </a> -->
                                        <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" title="Dismiss" onclick="setDismissed(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-check-circle"></i>
                                        </button>
                                        <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" title="Refer" onclick="setReferred(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-external-link-alt"></i>
                                        </button>
                                        <button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded hover:bg-purple-600 transition duration-200" title="Edit" onclick="openEditDialog(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div id="ongoing">
                        <table id="ongoingCases" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Complainant</th>
                                    <th>Person to Complaint</th>
                                    <th>Complaint</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ongoingData as $row): ?>
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
                                    <td>
                                        <span id="status-<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['reference'])): ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Reference" onclick="showImage('<?php echo htmlspecialchars($row['reference']); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        <?php else: ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded hover:bg-purple-600 transition duration-200" title="Edit" onclick="openEditDialog(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <button class="bg-green-500 text-white font-semibold py-1 px-2 rounded hover:bg-green-600 transition duration-200" onclick="setStatusResched(<?php echo htmlspecialchars($row['id']); ?>)">
                                            Reset
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>


                    <div id="rescheduled">
                        <table id="rescheduledcases" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Complainant</th>
                                    <th>Person to Complaint</th>
                                    <th>Complaint</th>
                                    <th>Action</th>
                                    <th>Status</th>
                                    <th>Reference</th>
                                    <th><i class="fa-solid fa-gears"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reschedData as $row): ?>
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
                                    <td>
                                        <span id="status-<?php echo htmlspecialchars($row['id']); ?>"><?php echo htmlspecialchars($row['status']); ?></span>
                                    </td>
                                    <td>
                                        <?php if (!empty($row['reference'])): ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Reference" onclick="showImage('<?php echo htmlspecialchars($row['reference']); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        <?php else: ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded hover:bg-purple-600 transition duration-200" title="Edit" onclick="openEditDialog(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
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
                                    <th>Reference</th> <!-- New column for Reference -->
                                    <th><i class="fa-solid fa-gears"></i></th>
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
                                    <td>
                                        <?php if (!empty($row['reference'])): // Check if there's an image ?>
                                            <span class="view-icon" style="cursor:pointer; color:blue;" title="View Reference" onclick="showImage('<?php echo htmlspecialchars($row['reference']); ?>')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        <?php else: ?>
                                            <span>No Image</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded hover:bg-purple-600 transition duration-200" title="Edit" onclick="openEditDialog(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>

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
                                    <th><i class="fa-solid fa-bars"></i></th>
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
                                    <td class="flex space-x-2">
                                            <a class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200" title="Generate">
                                            <i class="fas fa-file-download"></i>
                                            </a>
                                            <button class="bg-purple-500 text-white font-semibold py-2 px-4 rounded hover:bg-purple-600 transition duration-200" title="Edit" onclick="openEditDialog(<?php echo htmlspecialchars($row['id']); ?>)">
                                            <i class="fas fa-edit"></i>
                                            </button>
                                    </td>
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
        <form id="blotterForm" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="complainant" class="block text-sm font-medium text-gray-700">Complainant Name:</label>
                <input type="text" id="complainant" name="complainant" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="personToComplaint" class="block text-sm font-medium text-gray-700">Person to Complaint:</label>
                <input type="text" id="personToComplaint" name="personToComplaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="cAddress" class="block text-sm font-medium text-gray-700">Complainant Address:</label>
                <input type="text" id="cAddress" name="cAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <label for="pAddress" class="block text-sm font-medium text-gray-700">Complainee Address:</label>
                <input type="text" id="pAddress" name="pAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="col-span-1 md:col-span-2">
                <label for="complaint" class="block text-sm font-medium text-gray-700">Complaint:</label>
                <textarea id="complaint" name="complaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>
            <div>
                <label for="action" class="block text-sm font-medium text-gray-700">Action:</label>
                <select id="action" name="action" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="1st Option">Brgy. Captain</option>
                    <option value="2nd Option">Lupon</option>
                    <option value="3rd Option">Police</option>
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

<div id="editBlotterDialog" title="Edit Blotter" style="display:none;" class="p-6 bg-white rounded-lg shadow-lg">
    <form id="editBlotterForm" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <input type="hidden" id="editId" name="editId">
        
        <div>
            <label for="editComplainant" class="block text-sm font-medium text-gray-700">Complainant Name:</label>
            <input type="text" id="editComplainant" name="editComplainant" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="editPersonToComplaint" class="block text-sm font-medium text-gray-700">Person to Complaint:</label>
            <input type="text" id="editPersonToComplaint" name="editPersonToComplaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="editCAddress" class="block text-sm font-medium text-gray-700">Complainant Address:</label>
            <input type="text" id="editCAddress" name="editCAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="editPAddress" class="block text-sm font-medium text-gray-700">Complainee Address:</label>
            <input type="text" id="editPAddress" name="editPAddress" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div class="col-span-1 md:col-span-2">
            <label for="editComplaint" class="block text-sm font-medium text-gray-700">Complaint:</label>
            <textarea id="editComplaint" name="editComplaint" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div>
            <label for="editAction" class="block text-sm font-medium text-gray-700">Action:</label>
            <select id="editAction" name="editAction" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="1st Option">Brgy. Captain</option>
                <option value="2nd Option">Lupon</option>
                <option value="3rd Option">Police</option>
            </select>
        </div>

        <div>
            <label for="editStatus" class="block text-sm font-medium text-gray-700">Status:</label>
            <select id="editStatus" name="editStatus" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="New">New</option>
                <option value="Dismissed">Dismissed</option>
                <option value="Referred">Referred</option>
                <option value="Ongoing">Ongoing</option>
            </select>
        </div>



        <div class="col-span-1 md:col-span-2">
            <label for="editImage" class="block text-sm font-medium text-gray-700">Upload Image Reference:</label>
            <input type="file" id="editImage" name="editImage" accept="image/*" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500">
            <img id="editImagePreview" src="" alt="Image Preview" class="mt-2" style="display:none; max-width: 100%;">
            <label class="block text-sm font-medium text-gray-700 mt-2">Supporting Details:</label>
            <div id="supportingDetailsContainer">
                <div class="flex items-center mb-2">
                    <input type="text" name="supportingDetails[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Supporting Detail">
                    <button type="button" class="ml-2 text-red-600 hover:text-red-800 remove-supporting-detail">
                        <i class="fas fa-minus-circle"></i>
                    </button>
                </div>
            </div>
            <button type="button" id="addSupportingDetail" class="mt-2 text-blue-600 hover:text-blue-800">
                <i class="fas fa-plus"></i> Add More
            </button>
        </div>
    </form>
</div>


    <div id="imagePreviewDialog" title="Image Reference" style="display:none;">
        <img id="imagePreview" src="" alt="Image Preview" style="max-width: 100%;"/>
    </div>
    <script>
        function addSupportingDetailInput(value = '') {
            const inputHtml = `
                <div class="flex items-center mb-2">
                    <input type="text" name="supportingDetails[]" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Supporting Detail" value="${value}">
                    <button type="button" class="ml-2 text-red-600 hover:text-red-800 remove-supporting-detail">
                        <i class="fas fa-minus-circle"></i>
                    </button>
                </div>
            `;
            $('#supportingDetailsContainer').append(inputHtml);
        }

        // Event listener for adding more supporting details
        $('#addSupportingDetail').on('click', function() {
            addSupportingDetailInput(); // Add a new input with a blank value
        });

        // Event delegation for removing supporting detail inputs
        $(document).on('click', '.remove-supporting-detail', function() {
            $(this).closest('.flex').remove(); // Remove the input group
        });
        $(document).ready(function() {
            $('#allCases, #dismissedCases, #referredCases, #rescheduledcases, #ongoingCases').DataTable({
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
                height: 500,
                buttons: {
                    "Add Blotter": function() {
                        AddBlotter();
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

            $("#editBlotterDialog").dialog({
                autoOpen: false,
                modal: true,
                width: 500,
                height: 500,
                buttons: {
                    "Save Changes": function() {
                        const formData = new FormData();
                        formData.append('id', $('#editId').val());
                        formData.append('complainant', $('#editComplainant').val());
                        formData.append('cAddress', $('#editCAddress').val());
                        formData.append('personToComplaint', $('#editPersonToComplaint').val());
                        formData.append('pAddress', $('#editPAddress').val());
                        formData.append('complaint', $('#editComplaint').val());
                        formData.append('action', $('#editAction').val());
                        formData.append('status', $('#editStatus').val());

                        // Gather Supporting Details
                        const supportingDetails = $('input[name="supportingDetails[]"]').map(function() {
                            return $(this).val();
                        }).get(); // Get values as an array
                        supportingDetails.forEach(detail => {
                            formData.append('supportingDetails[]', detail); // Append each detail to FormData
                        });

                        const imageInput = document.getElementById('editImage');
                        if (imageInput.files.length > 0) {
                            formData.append('image', imageInput.files[0]); // Append the selected file
                        }

                        $.ajax({
                            url: 'nx_query/blotter_query.php?action=edit',
                            type: 'POST',
                            processData: false,  // Important: prevents jQuery from transforming the data into a query string
                            contentType: false,   // Important: let jQuery know you're sending FormData
                            data: formData,
                            success: function(response) {
                                if (response.success) {
                                    swal("Blotter updated successfully!", {
                                        icon: "success",
                                    }).then(() => {
                                        location.reload(); // Reload the page to see updated data
                                    });
                                } else {
                                    swal("Error!", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', status, error);
                                swal("Error!", "Failed to update the blotter.", "error");
                            }
                        });

                        $(this).dialog("close");
                    },
                    Cancel: function() {
                        $(this).dialog("close");
                    }
                }
            });



            $("#imagePreviewDialog").dialog({
                autoOpen: false,
                modal: true,
                width: 600,
                buttons: {
                    Close: function() {
                        $(this).dialog("close");
                    }
                }
            });

        });
        function setStatusResched(id) {
            const newStatus = "Resched"; // Automatically set to Resched

            $.ajax({
                url: 'nx_query/blotter_query.php?action=updateStatus', // Adjust URL as necessary
                type: 'POST',
                data: { id: id, status: newStatus },
                success: function(response) {
                    if (response.success) {
                        // Update the displayed status
                        $('#status-' + id).text(newStatus);
                        swal("Status updated successfully!", {
                            icon: "success",
                        });
                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    swal("Error!", "Failed to update status.", "error");
                }
            });
        }

        function showImage(imageName) {
            const imagePath = `../../assets/images/blotter/${imageName}`; // Prepend the path
            $('#imagePreview').attr('src', imagePath); // Set the image source
            $("#imagePreviewDialog").dialog("open"); // Show the dialog
        }

        function openDialog(complaintText) {
            $("#dialog-content").text(complaintText);
            $("#dialog").dialog("open");
        }

        function AddBlotter() {
            const formData = {
                complainant: $('#complainant').val(),
                cAddress: $('#cAddress').val(),
                personToComplaint: $('#personToComplaint').val(),
                pAddress: $('#pAddress').val(),
                complaint: $('#complaint').val(),
                action: $('#action').val(),
                status: $('#status').val(),
            };

            $.ajax({
                url: 'nx_query/blotter_query.php?action=create',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        swal("Blotter added successfully!", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); // Reload the page or update the UI as needed
                        });
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    alert('Error adding blotter.');
                }
            });
        }
        function setDismissed(id) {
            swal({
                title: "Are you sure?",
                text: "Once dismissed, you will not be able to recover this case!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDismiss) => {
                if (willDismiss) {
                    $.ajax({
                        url: 'nx_query/blotter_query.php?action=dismissed', // Adjust the URL to match your setup
                        type: 'POST',
                        data: { id: id }, // Send the ID of the case to dismiss
                        success: function(response) {
                            if (response.success) {
                                swal("Case dismissed successfully!", {
                                    icon: "success",
                                }).then(() => {
                                    location.reload(); // Reload the page to see the updated list
                                });
                            } else {
                                swal("Error!", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('AJAX error:', status, error);
                            swal("Error!", "Failed to dismiss the case.", "error");
                        }
                    });
                }
            });
        }
        function setReferred(id) {
          swal({
            title: "Are you sure?",
            text: "Once Referred, you will not be able to recover this case!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          }).then((willReferred) => {
            if (willReferred) {
              $.ajax({
                url: "nx_query/blotter_query.php?action=reffered", 
                type: "POST",
                data: { id: id }, // Send the ID of the case to dismiss
                success: function (response) {
                  if (response.success) {
                    swal("Case set Reffered successfully!", {
                      icon: "success",
                    }).then(() => {
                      location.reload(); // Reload the page to see the updated list
                    });
                  } else {
                    swal("Error!", response.message, "error");
                  }
                },
                error: function (xhr, status, error) {
                  console.error("AJAX error:", status, error);
                  swal("Error!", "Failed to dismiss the case.", "error");
                },
              });
            }
          });
        }
        function openEditDialog(id) {
            // Fetch the existing data for the case to be edited
            $.ajax({
                url: 'nx_query/blotter_query.php?action=get',
                type: 'POST',
                data: { id: id },
                success: function(response) {
                    if (response.success) {
                        $('#editId').val(response.data.id);
                        $('#editComplainant').val(response.data.complainant);
                        $('#editCAddress').val(response.data.caddress);
                        $('#editPersonToComplaint').val(response.data.personToComplaint);
                        $('#editPAddress').val(response.data.paddress);
                        $('#editComplaint').val(response.data.complaint);
                        $('#editAction').val(response.data.action);
                        $('#editStatus').val(response.data.status);
                        
                        // Check if an image exists and display it
                        if (response.data.image) {
                            $('#editImagePreview').attr('src', response.data.image).show();
                        } else {
                            $('#editImagePreview').hide(); // Hide if no image
                        }

                        // Reset the file input to allow re-uploading the same file
                        $('#editImage').val('');
                        $('#supportingDetailsContainer').empty();
                        
                        // Populate supporting details
                        if (response.data.supportingDetails && response.data.supportingDetails.length > 0) {
                            response.data.supportingDetails.forEach(function(detail) {
                                addSupportingDetailInput(detail);
                            });
                        } else {
                            addSupportingDetailInput(); // Add one empty input if none exists
                        }
                        $("#editBlotterDialog").dialog("open");
                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    swal("Error!", "Failed to fetch data.", "error");
                }
            });
        }
        document.getElementById('editImage').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('editImagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Set the src to the file content
                    preview.style.display = 'block'; // Show the preview image
                };
                reader.readAsDataURL(file); // Read the file as a data URL
            } else {
                preview.src = ""; // Clear the src if no file is selected
                preview.style.display = 'none'; // Hide the preview image
            }
        });

    </script>
</body>
</html>
