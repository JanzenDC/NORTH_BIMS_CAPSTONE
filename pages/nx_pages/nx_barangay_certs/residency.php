<?php
// Fetch walk-in data from the database
$sqlWalkin = "SELECT * FROM residency_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

// Fetch other data as needed (example SQL queries)
$sqlNew = "SELECT * FROM residency_cert WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlApproved = "SELECT * FROM residency_cert WHERE status = 'Approved'";
$resultApproved = $conn->query($sqlApproved);
$approvedData = $resultApproved->fetch_all(MYSQLI_ASSOC);

$sqlDisapproved = "SELECT * FROM residency_cert WHERE status = 'Disapproved'";
$resultDisapproved = $conn->query($sqlDisapproved);
$disapprovedData = $resultDisapproved->fetch_all(MYSQLI_ASSOC);

$sqlDone = "SELECT * FROM residency_cert WHERE status = 'Done'";
$resultDone = $conn->query($sqlDone);
$doneData = $resultDone->fetch_all(MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {

    const tableConfig = {
        scrollX: true,
        searching: true,
        responsive: true,
        language: {
            emptyTable: "No data available"
        },
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        initComplete: function() {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        }
    };

    // Initialize all tables with the same configuration
    $('#walkinTable, #newTable, #approvedTable, #disapprovedTable, #doneTable, #residentTable').DataTable(tableConfig);

    swal({
    title: "Loading...",
    text: "Please wait while the content is loading.",
    buttons: false,
    closeOnClickOutside: false,
    closeOnEsc: false
    });

    setTimeout(() => {
    swal.close();
    $("#tabs").tabs();
    }, 2000);


    // Initialize the resident dialog
    $("#residentDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 600,
        resizable: false, // Disable resizing
        responsive: true

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
            setTimeout(function() {
                $('#residentDialog thead th').each(function() {
                    $(this).trigger('click');
                });
            }, 100);
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
                    location.reload(); // Reload the page or update the UI as needed
                    $('#editDialog').dialog("close"); // Close the dialog
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

function doneCert(id) {
    if (confirm('Are you sure you want to mark this certificate as done?')) {
        // Send AJAX request to the server
        $.ajax({
            url: 'nx_query/certificate_residency.php?action=mark_done',
            type: 'POST',
            data: { id: id },
            success: function(response) {
                console.log('Full server response:', response);
                try {
                    const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                    if (jsonResponse.success) {
                        swal("Certificate marked as done successfully!", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); // Reload the page or update the UI as needed
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
                swal("Error marking record as done", "Please check the console for more details.", {
                    icon: "error",
                });
            }
        });
    }
}
function editApproved(targetID){
    console.log(targetID)
    $.get('nx_query/certificate_residency.php?action=get&id=' + targetID, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(response.data);
            document.getElementById('editID').value = official.id;
            document.getElementById('editAmount').value = official.amount;
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
    const dateIssued = document.getElementById('editDate').value;
    const editPurposes = document.getElementById('editPurposes').value;

    const formData = {
        id: id,
        amount: amount,
        date_issued: dateIssued,
        purposes: editPurposes
    };
    console.log(formData)

    $.ajax({
        url: 'nx_query/certificate_residency.php?action=updateApprove',
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
function editDisapproved(id) {
    console.log(id);
    document.getElementById('editIDs').value = id;

    // Fetch current note from the server
    $.ajax({
        url: 'nx_query/certificate_residency.php?action=get',
        type: 'GET',
        data: { id: id },
        success: function(response) {
            const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;

            if (jsonResponse.success) {
                // Populate the note field with the current note
                document.getElementById('editNote').value = jsonResponse.data.note || ''; // Default to empty if no note
            } else {
                console.error("Error fetching current note: " + jsonResponse.message);
                document.getElementById('editNote').value = ''; // Clear if there's an error
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX error fetching note:', status, error);
            document.getElementById('editNote').value = ''; // Clear on error
        }
    });

    $('#editDialog').dialog({
        title: "Edit Certificate Notes",
        modal: true,
        width: 400,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            }
        }
    });
}
function approveCert(targetID) {
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
                url: 'nx_query/certificate_residency.php?action=setAsApprove', // Change to setAsApprove
                type: 'POST',
                data: formData,
                success: function(response) {
                    const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                    if (jsonResponse.success) {
                        swal("Record marked as done successfully!", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); 
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
function disapproveCert(targetID) {
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
                url: 'nx_query/certificate_residency.php?action=setDisapproved', // Change to setAsApprove
                type: 'POST',
                data: formData,
                success: function(response) {
                    const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                    if (jsonResponse.success) {
                        swal("Record marked as done successfully!", {
                            icon: "success",
                        }).then(() => {
                            location.reload(); 
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

</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Residency Certificate</h1>
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
                        <td class="flex space-x-2">
                            <a href='GenerateCertificate.php?page=generate_residency&id=<?php echo $row['id']; ?>' class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</a>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($row['id']); ?>)">Done</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

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
                        <td class="flex space-x-2">
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200" onclick="approveCert(<?php echo htmlspecialchars($row['id']); ?>)">Approve</button>
                            <button class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 transition duration-200" onclick="disapproveCert(<?php echo htmlspecialchars($row['id']); ?>)">Disapprove</button>
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
                        <td class="flex space-x-2">
                            <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" 
                                    onclick="editApproved(<?php echo htmlspecialchars($row['id']); ?>)">Edit</button>
                            <a href='GenerateCertificate.php?page=generate_residency&id=<?php echo $row['id']; ?>' class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</a>
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
                        <td class="flex space-x-2">
                            <button class="bg-yellow-500 text-white font-semibold py-2 px-4 rounded hover:bg-yellow-600 transition duration-200" 
                                    onclick="editDisapproved(<?php echo htmlspecialchars($row['id']); ?>)">Edit</button>
                            <a href='GenerateCertificate.php?page=generate_residency&id=<?php echo $row['id']; ?>' class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</a>
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

<!-- Resident Search Dialog -->
<div id="residentDialog" style="display:none;">
    <h2>Select Resident</h2>
    <div style="width:100%;">
        <table id="residentTable" class="display" style="width:100%;">
            <thead>
                <tr>
                    <th>Resident Name</th>
                    <th>Age</th>
                    <th>Actions</th>
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
                        $age = htmlspecialchars($row['age']);
                        $residentId = htmlspecialchars($row['resident_id']);

                        // Output the row with consistent styles
                        echo "<tr>";
                        echo "<td>" . $fullName . "</td>";
                        echo "<td>" . $age . "</td>";
                        echo "<td><button class='select-resident bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200' data-name='" . $fullName . "' data-age='" . $age . "' data-id='" . $residentId . "'>Select</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3' style='text-align:center; border: 1px solid #ccc; padding: 8px;'>No residents found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
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

        <!-- <div class="w-full mb-2">
            <label for="purpose" class="block mb-1">Purpose:</label>
            <textarea id="purpose" name="purpose" required class="border rounded p-2 w-full" rows="3"></textarea>
        </div> -->

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
