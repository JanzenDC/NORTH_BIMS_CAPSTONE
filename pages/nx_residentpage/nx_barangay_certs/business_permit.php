<?php
$userid = $_SESSION['user']['id'];

$walkinData = []; // Fetch your walk-in data
$newData = []; // Fetch new data
$approvedData = []; // Fetch approved data
$disapprovedData = []; // Fetch disapproved data
$doneData = []; // Fetch done data

// Example queries (customize according to your actual table logic)
$walkinQuery = "SELECT * FROM business_cert WHERE status = 'Walk-in' AND ownerId = $userid";
$newQuery = "SELECT * FROM business_cert WHERE status = 'New' AND ownerId = $userid";
$approvedQuery = "SELECT * FROM business_cert WHERE status = 'Approved' AND ownerId = $userid";
$disapprovedQuery = "SELECT * FROM business_cert WHERE status = 'Disapproved' AND ownerId = $userid";
$doneQuery = "SELECT * FROM business_cert WHERE status = 'Done' AND ownerId = $userid";


foreach ([$walkinQuery => &$walkinData, $newQuery => &$newData, 
           $approvedQuery => &$approvedData, $disapprovedQuery => &$disapprovedData,
           $doneQuery => &$doneData] as $query => &$dataArray) {
    $result = $conn->query($query);
    while ($row = $result->fetch_assoc()) {
        $dataArray[] = $row;
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
    $('#walkinTable, #newTable, #approvedTable, #disapprovedTable, #doneTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    
    // Initialize jQuery UI Tabs
    $("#tabs").tabs();


    $("#addCertificateDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        height:  555,

        buttons: {
            Cancel: function() {
                $(this).dialog("close");
            }
        }
    });

    // Function to open the dialog
    $("#openDialogButton").on("click", function() {
        $("#addCertificateDialog").dialog("open");
    });

    $('#updateButton').on('click', function() {
        const id = $('#editCertId').val(); // Get the hidden ID
        saveEdit(id); // Call save function
    });

        $("#editNoteDialog").dialog({
        autoOpen: false,
        modal: true,
        width: 400
    });

    window.openEditNoteDialog = function(id, currentNote) {
        $("#editNoteId").val(id);
        $("#editNote").val(currentNote);
        $("#editNoteDialog").dialog("open");
    };

    $("#editNoteForm").on("submit", function(e) {
        e.preventDefault();
        const id = $("#editNoteId").val();
        const note = $("#editNote").val();

        $.ajax({
            url: 'nx_query/certificate_bpermit.php?action=updateNote',
            type: 'POST',
            data: { id: id, note: note },
            success: function(response) {
                if (response.success) {
                    swal("Certificate marked as done successfully!", {
                        icon: "success",
                    }).then(() => {
                        location.reload(); // Reload the page or update the UI as needed
                        $('#editCertificateDialog').dialog("close");
                    });
                    
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
                alert('Error updating certificate.');
            }
        });
    });

    $(document).on('click', '.deleteButton', function() {
        var certificateId = $(this).data('id');
        
        // SweetAlert confirmation prompt
        swal({
            title: "Are you sure?",
            text: "Do you really want to delete this certificate?",
            icon: "warning",
            buttons: {
                cancel: {
                    text: "Cancel",
                    value: null,
                    visible: true,
                    className: "btn btn-secondary",
                    closeModal: true
                },
                confirm: {
                    text: "Yes, delete it!",
                    value: true,
                    visible: true,
                    className: "btn btn-danger",
                    closeModal: true
                }
            }
        }).then((willDelete) => {
            if (willDelete) {
                // Send AJAX request to delete the record
                $.ajax({
                    url: 'nx_query/certificate_bpermit.php?action=delete',
                    type: 'POST',
                    data: { id: certificateId },
                    success: function(response) {
                        // Check if deletion was successful
                        if (response.success) {
                            swal("Deleted!", "Certificate deleted successfully.", {
                                icon: "success",
                            }).then(() => {
                                location.reload(); // Reload the page or update the UI
                            });
                        } else {
                            swal("Error", "Failed to delete the certificate.", {
                                icon: "error",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', status, error);
                        swal("Error", "There was an error processing your request.", {
                            icon: "error",
                        });
                    }
                });
            } else {
                // If the user cancels, just show a message
                swal("Your certificate is safe!", {
                    icon: "info",
                });
            }
        });
    });

});

///////////// CRUD ////////////////////
function addRecord(event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(document.getElementById('addCertificateForm'));

    $.ajax({
        url: 'nx_query/certificate_bpermit.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('#loadingIndicator').show(); // Show loading indicator
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
                        $('#addCertificateDialog').dialog("close"); // Close the dialog
                        location.reload(); 
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
            $('#loadingIndicator').hide(); // Hide loading indicator
            $('input[type="submit"]').prop('disabled', false).val('Submit');
        }
    });
}



</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Business Permit</h1>
    <hr class="mb-3 mt-3">

    <div>
        <button id="openDialogButton" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Request</button>
    </div>

    <div id="tabs" class="container mt-4">
        <ul>
            <li><a href="#new">New</a></li>
            <li><a href="#approved">Approved</a></li>
            <li><a href="#disapproved">Disapproved</a></li>
        </ul>



        <div id="new">
            <table id="newTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Owner Name</th>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Status</th>
                        <th>Action</th> <!-- Add Action column for Delete -->
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $data): ?>
                    <tr data-id="<?php echo $data['id']; ?>">
                        <td><?php echo htmlspecialchars($data['owner_fname'] . ' ' . $data['owner_lname']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td>
                            <button class="deleteButton bg-red-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" data-id="<?php echo $data['id']; ?>">Delete</button>
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
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Certificate Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $data): ?>
                    <tr data-id="<?php echo $data['id']; ?>">
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>



        <div id="disapproved">
            <table id="disapprovedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disapprovedData as $data): ?>
                    <tr data-id="<?php echo $data['id']; ?>"> <!-- Added data-id attribute -->
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['note']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- ADD CERT -->
<div id="loadingIndicator" class="hidden">Loading...</div>
<div id="addCertificateDialog" title="Request" style="display:none;">
    <form id="addCertificateForm" onsubmit="addRecord(event)">
        <input type="text" id="status" name="status" class=" hidden mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 disabled" value="New" readonly>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Personal Information -->
            <div class="col-span-1 hidden">
                <h3 class="text-lg font-medium mb-2">Personal Information</h3>
                <label for="fname" class="block">First Name:</label>
                <input type="text" id="fname" name="fname" readonly value="<?= $_SESSION['user']['fname']; ?>" class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="mname" class="block mt-2">Middle Name:</label>
                <input type="text" id="mname" name="mname" readonly value="<?= $_SESSION['user']['mname']; ?>" class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="lname" class="block mt-2">Last Name:</label>
                <input type="text" id="lname" name="lname" readonly value="<?= $_SESSION['user']['lname']; ?>" class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">
            </div>

            <!-- Business Information -->
            <div class="col-span-1">
                <label for="typeOfBusiness" class="block">Type of Business:</label>
                <input type="text" id="typeOfBusiness" name="typeOfBusiness" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="dateIssued" class="mt-2 hidden">Date Issued:</label>
                <input type="date" id="dateIssued" name="dateIssued" required class=" hidden mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2" readonly>

                <label for="businessName" class="block">Business Name:</label>
                <input type="text" id="businessName" name="businessName" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">


                <label for="street" class="block mt-2">Street:</label>
                <select id="street" name="street" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">
                    <option value="">Select a street</option>
                    <option value="Banaba">Banaba</option>
                    <option value="Narra">Narra</option>
                    <option value="Mulawin">Mulawin</option>
                    <option value="Kamagong">Kamagong</option>
                    <option value="Mabolo">Mabolo</option>
                    <option value="Calumpit">Calumpit</option>
                    <option value="Acasia">Acasia</option>
                </select>

                <label for="municipality" class="block">Municipality:</label>
                <input type="text" id="municipality" name="municipality" value="Gabaldon" readonly class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="province" class="block mt-2">Province:</label>
                <input type="text" id="province" name="province" value="Nueva Ecija" readonly class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">
            </div>

        </div>

        <button type="submit" class="mt-6 w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600">Request</button>
    </form>
</div>

<script>
        document.addEventListener('DOMContentLoaded', function() {
                const dateIssuedInput = document.getElementById('dateIssued');
                
                // Get the current date in yyyy-mm-dd format
                const currentDate = new Date().toISOString().split('T')[0];
                
                // Set the value of the input to the current date
                dateIssuedInput.value = currentDate;
        });
</script>