<?php
// Fetch data from the clearance_cert table based on status for Walk-in only
$sqlWalkin = "SELECT * FROM clearance_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

// Fetch data from the clearance_cert table based on status for New entries
$sqlNew = "SELECT * FROM clearance_cert WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);

$newData = [];
if ($resultNew->num_rows > 0) {
    while ($row = $resultNew->fetch_assoc()) {
        $newData[] = $row;
    }
}

// Fetch data from the clearance_cert table based on status for Approved entries
$sqlApproved = "SELECT * FROM clearance_cert WHERE status = 'Approved'";
$resultApproved = $conn->query($sqlApproved);

$approvedData = [];
if ($resultApproved->num_rows > 0) {
    while ($row = $resultApproved->fetch_assoc()) {
        $approvedData[] = $row;
    }
}

// Fetch data from the clearance_cert table based on status for Disapproved entries
$sqlDisapproved = "SELECT * FROM clearance_cert WHERE status = 'Disapproved'";
$resultDisapproved = $conn->query($sqlDisapproved);

$disapprovedData = [];
if ($resultDisapproved->num_rows > 0) {
    while ($row = $resultDisapproved->fetch_assoc()) {
        $disapprovedData[] = $row;
    }
}

// Fetch data from the clearance_cert table based on status for Done entries
$sqlDone = "SELECT * FROM clearance_cert WHERE status = 'Done'";
$resultDone = $conn->query($sqlDone);

$doneData = [];
if ($resultDone->num_rows > 0) {
    while ($row = $resultDone->fetch_assoc()) {
        $doneData[] = $row;
    }
}
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize DataTables for all tables
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
// DIALOGS
    // Initialize the dialog
    $("#dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 800, // Set your desired width
        height: 480, // Set your desired height
        title: "Add Certificate",
        close: function() {
            $(this).dialog("close");
        }
    });

    // Open the dialog when the button is clicked
    $("#open-dialog").click(function() {
        $("#dialog").dialog("open");
    });

    $("#residentDialog").dialog({
        autoOpen: false,
        width: 800, // Set your desired width
        height: 400, // Set your desired height
        modal: true,
        title: "Select Resident",
        close: function() {
            $(this).dialog("close");
        }
    });
    // Open resident dialog when search icon is clicked
    $("#open-resident-dialog").click(function() {
        $("#residentDialog").dialog("open");
    });
    
    /////////////////////////////////////////////
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
///////////////////////////////////////////
    $("#DisApproveddDialog").dialog({
        autoOpen: false,
        width: 350, // Set your desired width
        height: 300, // Set your desired height
        modal: true,
        title: "Disapproved Certificate",
        close: function() {
            $(this).dialog("close");
        }
    });

    $(document).on('click', '.select-resident', function() {
        const residentName = $(this).data('name');
        const nameParts = residentName.split(' ');

        const fname = nameParts[0] || '';
        const mname = nameParts.length > 2 ? nameParts[1] : '';
        const lname = nameParts.length > 2 ? nameParts[2] : nameParts[1]; 
        $('#residentName').val(residentName).prop('disabled', false); // 
        $('#status').prop('disabled', false);

        $('#fname').val(fname);
        $('#mname').val(mname);
        $('#lname').val(lname);

        // Close the resident dialog
        $('#residentDialog').dialog("close");
    });

    $(document).on('click', '.delete-btn', function() {
        const recordId = $(this).data('id'); 
        confirmDelete(recordId); // Call the delete confirmation function
    });
});


// CRUD
function addRecord(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById('addCertificateForm'));

    $.ajax({
        url: 'nx_query/certificate_clearance.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            // Optionally disable the submit button to prevent multiple submissions
            $('input[type="submit"]').prop('disabled', true).val('Submitting...');
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
                        $('#dialog').dialog("close"); // Close the dialog
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
            $('input[type="submit"]').prop('disabled', false).val('Submit');
        }
    });
}
function confirmDelete(recordId) {
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this record!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            // Perform the delete action
            $.ajax({
                url: 'nx_query/certificate_clearance.php?action=delete',
                type: 'POST',
                data: { id: recordId },
                success: function(response) {
                    const jsonResponse = JSON.parse(response);
                    if (jsonResponse.success) {
                        swal("Deleted!", "Your record has been deleted.", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); // Reload the page to see changes
                        });
                    } else {
                        swal("Error!", jsonResponse.message, {
                            icon: "error",
                        });
                    }
                },
                error: function() {
                    swal("Error!", "There was an error deleting the record. Please try again.", {
                        icon: "error",
                    });
                }
            });
        } else {
            swal("Your record is safe!");
        }
    });
}
function editApproved(targetID){
    $.get('nx_query/certificate_clearance.php?action=get&id=' + targetID, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(response.data);
            document.getElementById('editID').value = official.id;
            document.getElementById('editAmount').value = official.amount;
            document.getElementById('editBC').value = official.bcNo;
            document.getElementById('editDate').value = official.date_issued;
            document.getElementById('editPurposes').value = official.purpose;

            // Open the dialog after populating the fields
            $("#approvedDialog").dialog("open");
        } else {
            swal("Error: " + response.message, {
                icon: "error",
            });
        }
    }).fail(function() {
        swal("Error retrieving record.", {
            icon: "error",
        });
    });
}
function updateRecord() {
    const id = document.getElementById('editID').value;
    const amount = document.getElementById('editAmount').value;
    const bcNo = document.getElementById('editBC').value;
    const dateIssued = document.getElementById('editDate').value;
    const editPurposes = document.getElementById('editPurposes').value;

    const formData = {
        id: id,
        amount: amount,
        bcNo: bcNo,
        date_issued: dateIssued,
        purposes: editPurposes
    };
    console.log(formData)

    $.ajax({
        url: 'nx_query/certificate_clearance.php?action=updateApprove',
        type: 'POST',
        data: formData,
        success: function(response) {
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            if (jsonResponse.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or update the UI as needed
                    $('#approvedDialog').dialog("close"); // Close the dialog
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
}
function doneCert(targetID) {
    // Show confirmation dialog
    swal({
        title: "Are you sure?",
        text: "Once you click 'Yes', this action cannot be undone.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willProceed) => {
        if (willProceed) {
            // If the user confirms, prepare the data for the AJAX request
            const formData = {
                id: targetID, // Target the specific ID
                // Include other necessary fields here if needed
            };

            $.ajax({
                url: 'nx_query/certificate_clearance.php?action=setAsDone', // Change to setAsDone
                type: 'POST',
                data: formData,
                success: function(response) {
                    const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                    if (jsonResponse.success) {
                        swal("Record marked as done successfully!", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); // Reload the page or update the UI as needed
                            $('#approvedDialog').dialog("close"); // Close the dialog
                        });
                    } else {
                        swal("Error: " + (jsonResponse.message || "Unknown error occurred"), {
                            icon: "error",
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    swal("Error marking record as done", "Please check the console for more details.", {
                        icon: "error",
                    });
                }
            });
        } else {
            // If the user cancels, you can show a message or simply do nothing
            swal("Action canceled.", {
                icon: "info",
            });
        }
    });
}
function editNote(targetID){
    $.get('nx_query/certificate_clearance.php?action=get&id=' + targetID, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(response.data);
            document.getElementById('editID').value = official.id;
            document.getElementById('editNotes').value = official.note;

            // Open the dialog after populating the fields
            $("#DisApproveddDialog").dialog("open");
        } else {
            swal("Error: " + response.message, {
                icon: "error",
            });
        }
    }).fail(function() {
        swal("Error retrieving record.", {
            icon: "error",
        });
    });
}
function updateNote() {
    const id = document.getElementById('editID').value;
    const notes = document.getElementById('editNotes').value;

    const formData = {
        id: id,
        notes: notes,
    };
    console.log(formData)

    $.ajax({
        url: 'nx_query/certificate_clearance.php?action=updateNotes',
        type: 'POST',
        data: formData,
        success: function(response) {
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
            if (jsonResponse.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or update the UI as needed
                    $('#DisApproveddDialog').dialog("close"); // Close the dialog
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
}
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Clearance List</h1>
    <hr>

    <div>
        <button id="open-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Add Certificate</button>
    </div>
    <!-- HTML for Tabs -->
    <div id="tabs" class="container mt-4">
        <ul>
            <li><a href="#walkin">Walk-in</a></li>
            <li><a href="#new">New</a></li>
            <li><a href="#approved">Approved</a></li>
            <li><a href="#disapproved">Disapproved</a></li>
            <li><a href="#done">Done</a></li> <!-- New Tab for Done -->
        </ul>
        
        <!-- Walk-in Tab -->
        <div id="walkin">
            <h3>Walk-in Tab Content</h3>
            <table id="walkinTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>BC No</th>
                        <th>Date Issued</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walkinData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['bcNo']); ?></td>
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

        <!-- New Tab -->
        <div id="new">
            <h3>New Tab Content</h3>
            <table id="newTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>BC No</th>
                        <th>Date Issued</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['bcNo']); ?></td>
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

        <!-- Approved Tab -->
        <div id="approved">
            <h3>Approved Tab Content</h3>
            <table id="approvedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>BC No</th>
                        <th>Date Issued</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['bcNo']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_issued']); ?></td>
                        <td class="flex space-x-2">
                            <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" 
                                    onclick="editApproved(<?php echo htmlspecialchars($row['id']); ?>)">Edit</button>
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Disapproved Tab -->
        <div id="disapproved">
            <h3>Disapproved Tab Content</h3>
            <table id="disapprovedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disapprovedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['note']); ?></td>
                        <td>
                            <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" onclick="editNote(<?php echo htmlspecialchars($row['id']); ?>)">Edit</button>
                            <button class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-200 delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Done Tab -->
        <div id="done">
            <h3>Done Tab Content</h3>
            <table id="doneTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Status</th>
                        <th>Amount</th>
                        <th>BC No</th>
                        <th>Date Issued</th>
                        <th>Status</th>
                        <!-- <th>Actions</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doneData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']); ?></td>
                        <td><?php echo htmlspecialchars($row['age']); ?></td>
                        <td><?php echo htmlspecialchars($row['status']); ?></td>
                        <td><?php echo htmlspecialchars($row['amount']); ?></td>
                        <td><?php echo htmlspecialchars($row['bcNo']); ?></td>
                        <td><?php echo $row['date_issued']; ?></td>
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



<div id="dialog" style="display:none;">
    <form id="addCertificateForm" onsubmit="addRecord(event)">
        <label for="residentName">Resident Name:</label><br>
        <div style="display: flex; align-items: center;">
            <input type="text" id="residentName" name="residentName" required disabled style="border: 1px solid #ccc; padding: 8px; border-radius: 4px;">
            <button type="button" id="open-resident-dialog" style="background: none; border: none; cursor: pointer; margin-left: 5px;" onclick="document.getElementById('residentDialog').style.display='block';">
                <i class="fas fa-search" style="font-size: 20px;"></i>
            </button>
        </div><br><br>

        <input type="hidden" id="fname" name="fname">
        <input type="hidden" id="mname" name="mname">
        <input type="hidden" id="lname" name="lname">

        <div style="display: flex; flex-wrap: wrap; gap: 15px;">
            <div style="flex: 1;">
                <label for="status">Status:</label><br>
                <select id="status" name="status" required disabled style="border: 1px solid #ccc; padding: 8px; border-radius: 4px; width: 100%;">
                    <option value="Walk-in" selected>Walk-in</option>
                    <option value="New">New</option>
                    <option value="Approved">Approved</option>
                    <option value="Disapproved">Disapproved</option>
                    <option value="Done">Done</option>
                </select>
            </div>

            <div style="flex: 1;">
                <label for="certificateAmount">Certificate Amount:</label><br>
                <input type="number" id="certificateAmount" name="certificateAmount" required style="border: 1px solid #ccc; padding: 8px; border-radius: 4px; width: 100%;">
            </div>

            <div style="flex: 1;">
                <label for="bcNo">BC No:</label><br>
                <input type="text" id="bcNo" name="bcNo" required style="border: 1px solid #ccc; padding: 8px; border-radius: 4px; width: 100%;">
            </div>

            <div style="flex: 1;">
                <label for="dateIssued">Date Issued:</label><br>
                <input type="date" id="dateIssued" name="dateIssued" required style="border: 1px solid #ccc; padding: 8px; border-radius: 4px; width: 100%;">
            </div>
        </div>

        <label for="purposes">Purposes:</label><br>
        <textarea id="purposes" name="purposes" rows="4" required style="border: 1px solid #ccc; padding: 8px; border-radius: 4px; width: 100%;"></textarea><br><br>

        <input type="submit" value="Submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
    </form>
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
            $sqlResidents = "SELECT fname, mname, lname, age FROM tblresident";
            $resultResidents = $conn->query($sqlResidents);

            if ($resultResidents->num_rows > 0) {
                while ($row = $resultResidents->fetch_assoc()) {
                    $fullName = htmlspecialchars($row['fname'] . ' ' . $row['mname'] . ' ' . $row['lname']);
                    echo "<tr>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'>" . $fullName . "</td>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td style='border: 1px solid #ccc; padding: 8px;'><button class='select-resident bg-blue-500 text-white py-1 px-2 rounded hover:bg-blue-600 transition duration-200' data-name='" . $fullName . "'>Select</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center; border: 1px solid #ccc; padding: 8px;'>No residents found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>



<!-- Approved Edit Dialog -->
<div id="approvedDialog" style="display:none;">
    <input type="number" id="editID" class="p-4 border mt-3" hidden/><br>
    Amount:
    <input type="number" id="editAmount" class="p-4 border mt-3"/><br>
    BC No:
    <input type="text" id="editBC" class="p-4 border mt-3"/><br>
    Date:
    <input type="date" id="editDate" class="p-4 border mt-3"/><br>
    Purposes:
    <textarea type="text" id="editPurposes" class="p-4 border mt-3"></textarea><br>
    <button id="saveEdit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="updateRecord()">Save</button>
</div>

<!-- DisApproved Edit Dialog -->
<div id="DisApproveddDialog" style="display:none;">
    <input type="number" id="editID" class="p-4 border mt-3" hidden/><br>
    None:
    <textarea type="text" id="editNotes" class="p-4 border mt-3"></textarea><br>
    <button id="saveEdit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="updateNote()">Save</button>
</div>