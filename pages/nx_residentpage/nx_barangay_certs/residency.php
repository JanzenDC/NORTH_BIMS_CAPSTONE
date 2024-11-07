<?php
$userid = $_SESSION['user']['id'];

$sqlWalkin = "SELECT * FROM residency_cert WHERE status = 'Walk-in' AND ownerid = $userid";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

// Fetch other data as needed (example SQL queries)
$sqlNew = "SELECT * FROM residency_cert WHERE status = 'New' AND ownerid = $userid";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlApproved = "SELECT * FROM residency_cert WHERE status = 'Approved' AND ownerid = $userid";
$resultApproved = $conn->query($sqlApproved);
$approvedData = $resultApproved->fetch_all(MYSQLI_ASSOC);

$sqlDisapproved = "SELECT * FROM residency_cert WHERE status = 'Disapproved' AND ownerid = $userid";
$resultDisapproved = $conn->query($sqlDisapproved);
$disapprovedData = $resultDisapproved->fetch_all(MYSQLI_ASSOC);

$sqlDone = "SELECT * FROM residency_cert WHERE status = 'Done' AND ownerid = $userid";
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
    $('#walkinTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#newTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#approvedTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#disapprovedTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#doneTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    $('#residentTable').DataTable({
        "searching": true, // Enable the search feature
        "scrollX": true // Enable horizontal scrolling
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
        width: 300, // Set your desired width
    });

    // Open resident dialog on button click
    $("#open-resident-dialog").on("click", function() {
        $("#add-certificate-dialog").dialog("open");
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


        $("#approvedDialog").dialog({
        autoOpen: false,
        width: 350, // Set your desired width
        height: 500, // Set your desired height
        modal: true,
        title: "Edit Approved Record",
        close: function() {
            $(this).dialog("close");
        }
    });
    // Open approvedDialog when search icon is clicked
    $("#open-approved-dialog").click(function() {
        $("#approvedDialog").dialog("open");
    });

    $('#editCertificateForm').on('submit', function(event) {
    event.preventDefault();
    
    const formData = {
        id: document.getElementById('editIDs').value,
        note: document.getElementById('editNote').value
    };
    console.log(formData)
    $.ajax({
        url: 'nx_query/certificate_residency.php?action=updateNote',
        type: 'POST',
        data: formData,
        success: function(response) {
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            if (jsonResponse.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload();
                    $('#editDialog').dialog("close"); 
                });
            } else {
                swal("Error: " + (jsonResponse.message || "Unknown error occurred"), {
                    icon: "error",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
            swal("Error updating record", "Please check the console for more details.", {
                icon: "error",
            });
        }
        });
    });
});

function addRecord(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById('addCertificateForm'));

    $.ajax({
        url: 'nx_query/certificate_residency.php?action=create',
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
    <h1 class="text-3xl font-bold">Residency List</h1>
    <hr class="mb-3 mt-3">

    <div>
        <button id="open-resident-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Request</button>
    </div>
    
    <div id="tabs" class="container mt-4">
        <ul>
            <!-- <li><a href="#walkin">Walk-in</a></li> -->
            <li><a href="#new">New</a></li>
            <li><a href="#approved">Approved</a></li>
            <li><a href="#disapproved">Disapproved</a></li>
            <li><a href="#done">Done</a></li>
        </ul>

        <!-- <div id="walkin">
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

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> -->

        <!-- Repeat similar structure for other sections (new, approved, disapproved, done) -->

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
                        <th>Status</th>
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
                            <div class="bg-green-400 p-2 text-center rounded-full border border-green-700 text-white">
                                <?php echo htmlspecialchars($row['status']); ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<!-- Add Certificate Dialog -->
<div id="add-certificate-dialog" title="Request" style="display:none;">
    <form id="addCertificateForm" onsubmit="addRecord(event)">

        <div class="w-full mb-2">
            <label for="year_residence" class="block mb-1">Year Residence:</label>
            <input type="number" id="year_residence" name="year_residence" required class="border rounded p-2 w-full">
        </div>

        <div class="w-full  mb-2">
            <label for="date_issued" class="block mb-1">Date Issued:</label>
            <input type="date" id="date_issued" name="date_issued" required class="border rounded p-2 w-full">
        </div>

        <!-- Close button -->
        <div class="w-full mt-2">
            <button type="button" id="close-dialog" class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-200">Close</button>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">Add Certificate</button>
        </div>
    </form>
</div>

<!-- APPROVE DIALOG -->
<div id="approvedDialog" style="display:none;">
    <input type="number" id="editID" class="p-4 border mt-3" hidden/><br>
    Amount:
    <input type="number" id="editAmount" class="p-4 border mt-3"/><br>
    Date:
    <input type="date" id="editDate" class="p-4 border mt-3"/><br>
    Purposes:
    <textarea type="text" id="editPurposes" class="p-4 border mt-3"></textarea><br>
    <button id="saveEdit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="updateRecord()">Save</button>
</div>

<div id="editDialog" style="display: none; width: 600px;">
    <form id="editCertificateForm">
        <input type="hidden" id="editIDs" name="id" />
        <label for="editNote" class="block mb-2 font-medium">Notes:</label>
        <textarea id="editNote" name="note" rows="4" class="w-full border-2 border-green-500 rounded-lg p-2 resize-none"></textarea>
        <button type="submit" class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200">Update</button>
    </form>
</div>
