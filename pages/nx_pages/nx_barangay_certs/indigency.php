<?php
// Fetch walk-in data from the database
$sqlWalkin = "SELECT * FROM indigency_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

// Fetch other data as needed (example SQL queries)
$sqlNew = "SELECT * FROM indigency_cert WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlApproved = "SELECT * FROM indigency_cert WHERE status = 'Approved'";
$resultApproved = $conn->query($sqlApproved);
$approvedData = $resultApproved->fetch_all(MYSQLI_ASSOC);

$sqlDisapproved = "SELECT * FROM indigency_cert WHERE status = 'Disapproved'";
$resultDisapproved = $conn->query($sqlDisapproved);
$disapprovedData = $resultDisapproved->fetch_all(MYSQLI_ASSOC);

$sqlDone = "SELECT * FROM indigency_cert WHERE status = 'Done'";
$resultDone = $conn->query($sqlDone);
$doneData = $resultDone->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTables
    $('#walkinTable').DataTable();
    $('#newTable').DataTable();
    $('#approvedTable').DataTable();
    $('#disapprovedTable').DataTable();
    $('#doneTable').DataTable();
    $('#residentTable').DataTable({
        "searching": true // Enable the search feature
    });
    // Initialize jQuery UI Tabs
    $("#tabs").tabs();

    // Initialize the resident dialog
    $("#residentDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 600,
    });

    // Initialize the add certificate dialog
    $("#add-certificate-dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 800, // Set your desired width
        height: 430, // Set your desired height
    });

    // Open resident dialog on button click
    $("#open-resident-dialog").on("click", function() {
        $("#residentDialog").dialog("open");
    });

    // Handle resident selection
    $(document).on("click", ".select-resident", function() {
        const residentName = $(this).data("name").split(" ");
        $("#fname").val(residentName[0]);
        $("#mname").val(residentName[1] || ""); // Handle middle name if it exists
        $("#lname").val(residentName[2] || "");
        $("#age").val($(this).data("age"));
        
        // Set the resident ID
        $("#resident_id").val($(this).data("id"));

        $("#residentDialog").dialog("close");
        $("#add-certificate-dialog").dialog("open");
    })

    // Close dialog button
    $("#close-dialog").on("click", function() {
        $("#add-certificate-dialog").dialog("close");
    });
});

function addRecord(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById('addCertificateForm'));

    $.ajax({
        url: 'nx_query/certificate_indigency.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            // Optionally disable the submit button to prevent multiple submissions
            $('button[type="submit"]').prop('disabled', true).text('Submitting...');
        },
        success: function(response) {
            console.log('Full server response:', response);
            try {
                const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                if (jsonResponse.success) {
                    swal("Certificate added successfully!", {
                        icon: "success",
                    }).then(() => {
                        location.reload(); // Reload the page or update the UI as needed
                        $('#add-certificate-dialog').dialog("close"); // Close the dialog
                    });
                } else {
                    swal("Error: " + (jsonResponse.message || "Unknown error occurred"), {
                        icon: "error",
                    });
                }
            } catch (e) {
                console.error('Error parsing server response:', e);
                swal("Server Error", "The server encountered an error. Please check the server logs.", {
                    icon: "error",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            swal("Error adding record", "Please check the console for more details.", {
                icon: "error",
            });
        },
        complete: function() {
            // Re-enable the submit button after the request is complete
            $('button[type="submit"]').prop('disabled', false).text('Add Certificate');
        }
    });
}
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Indigency List</h1>
    <hr class="mb-3 mt-3">

    <div>
        <button id="open-resident-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Select Resident</button>

    </div>
    
    <div id="tabs" class="container mt-4">
        <ul>
            <li><a href="#walkin">Walk-in</a></li>
            <li><a href="#new">New</a></li>
            <li><a href="#approved">Approved</a></li>
            <li><a href="#disapproved">Disapproved</a></li>
            <li><a href="#done">Done</a></li>
        </ul>

        <div id="walkin">
            <table id="walkinTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Street</th>
                        <th>Year of Residence</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walkinData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['bday']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['purok']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_stayed']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="new">
            <table id="newTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Street</th>
                        <th>Year of Residence</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['bday']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['purok']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_stayed']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="approved">
            <table id="approvedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Street</th>
                        <th>Year of Residence</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['bday']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['purok']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_stayed']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="disapproved">
            <table id="disapprovedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Street</th>
                        <th>Year of Residence</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disapprovedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['bday']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['purok']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_stayed']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="done">
            <table id="doneTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Street</th>
                        <th>Year of Residence</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Date Issued</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doneData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['bday']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['purok']); ?></td>
                        <td><?php echo htmlspecialchars($row['year_stayed']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Resident Search Dialog -->
<div id="residentDialog" style="display:none;">
    <h2>Select Resident</h2>
    <table id="residentTable" class="display" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="border: 1px solid #ccc; padding: 8px;">Resident Name</th>
                <th style="border: 1px solid #ccc; padding: 8px;">Age</th>
                <th style="border: 1px solid #ccc; padding: 8px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch residents from tblresident
            $sqlResidents = "SELECT * FROM tblresident";
            $resultResidents = $conn->query($sqlResidents);

            if ($resultResidents->num_rows > 0) {
                while ($row = $resultResidents->fetch_assoc()) {
                    $fullName = htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']);
                    echo "<tr>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'>" . $fullName . "</td>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'><button class='select-resident bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition duration-200' data-name='" . $fullName . "' data-age='" . htmlspecialchars($row['age']) . "' data-id='" . htmlspecialchars($row['resident_id']) . "'>Select</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center; border: 1px solid #ccc; padding: 8px;'>No residents found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Add Certificate Dialog -->
<div id="add-certificate-dialog" title="Add Certificate" style="display:none;">
    <form id="addCertificateForm" class="flex flex-wrap" onsubmit="addRecord(event)">

        <div class="w-full mb-2" style="display: none;">
            <label for="resident_id" class="block mb-1">Resident ID:</label>
            <input type="hidden" id="resident_id" name="resident_id">
        </div>

        <div class="w-full mb-2">
            <label for="status" class="block mb-1">Status:</label>
            <input type="text" id="status" name="status" value="Walk-in" readonly class="border rounded p-2 w-full">
        </div>

        <div class="w-full md:w-1/2 md:pr-2 mb-2">
            <label for="fname" class="block mb-1">First Name:</label>
            <input type="text" id="fname" name="fname" required readonly class="border rounded p-2 w-full">
        </div>

        <div class="w-full md:w-1/2 mb-2">
            <label for="mname" class="block mb-1">Middle Initial:</label>
            <input type="text" id="mname" name="mname" readonly class="border rounded p-2 w-full">
        </div>

        <div class="w-full md:w-1/2 md:pr-2 mb-2">
            <label for="lname" class="block mb-1">Last Name:</label>
            <input type="text" id="lname" name="lname" required readonly class="border rounded p-2 w-full">
        </div>

        <div class="w-full md:w-1/2 md:pr-2 mb-2">
            <label for="amount" class="block mb-1">Certificate Amount:</label>
            <input type="text" id="amount" name="amount" required class="border rounded p-2 w-full">
        </div>

        <div class="w-full md:w-1/2 mb-2">
            <label for="date_issued" class="block mb-1">Date Issued:</label>
            <input type="date" id="date_issued" name="date_issued" required class="border rounded p-2 w-full">
        </div>

        <div class="w-full mb-2">
            <label for="purpose" class="block mb-1">Purpose:</label>
            <textarea id="purpose" name="purpose" required class="border rounded p-2 w-full" rows="3"></textarea>
        </div>

        <!-- Close button -->
        <div class="w-full mt-2">
            <button type="button" id="close-dialog" class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-200">Close</button>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Add Certificate</button>
        </div>
    </form>
</div>