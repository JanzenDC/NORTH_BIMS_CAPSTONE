<?php

$walkinData = []; // Fetch your walk-in data
$newData = []; // Fetch new data
$approvedData = []; // Fetch approved data
$disapprovedData = []; // Fetch disapproved data
$doneData = []; // Fetch done data

// Example queries (customize according to your actual table logic)
$walkinQuery = "SELECT * FROM business_cert WHERE status = 'Walk-in'";
$newQuery = "SELECT * FROM business_cert WHERE status = 'New'";
$approvedQuery = "SELECT * FROM business_cert WHERE status = 'Approved'";
$disapprovedQuery = "SELECT * FROM business_cert WHERE status = 'Disapproved'";
$doneQuery = "SELECT * FROM business_cert WHERE status = 'Done'";


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
        width: 700,
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
        <button id="openDialogButton" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Add Certificate</button>
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
                        <th>Owner Name</th>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Certificate Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walkinData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['owner_fname'] . ' ' . $data['owner_lname']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Add action buttons here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="new">
            <table id="newTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Owner Name</th>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['owner_fname'] . ' ' . $data['owner_lname']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Add action buttons here --></td>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Add action buttons here --></td>
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
                    <tr>
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

        <div id="done">
            <table id="doneTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Business Name</th>
                        <th>Address</th>
                        <th>Type of Business</th>
                        <th>Date Issued</th>
                        <th>Certificate Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doneData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['businessName']); ?></td>
                        <td><?php echo htmlspecialchars($data['businessAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['typeOfBusiness']); ?></td>
                        <td><?php echo htmlspecialchars($data['date_issued']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>




<!-- ADD CERT -->
<div id="loadingIndicator" class="hidden">Loading...</div>
<div id="addCertificateDialog" title="Add Certificate" style="display:none;">
    <form id="addCertificateForm" onsubmit="addRecord(event)">
        <h2 class="text-xl font-semibold mb-4">Add Certificate</h2>
        <input type="text" id="status" name="status" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 disabled" value="Walk-in">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Personal Information -->
            <div class="col-span-1">
                <h3 class="text-lg font-medium mb-2">Personal Information</h3>
                <label for="fname" class="block">First Name:</label>
                <input type="text" id="fname" name="fname" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="mname" class="block mt-2">Middle Name:</label>
                <input type="text" id="mname" name="mname" class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="lname" class="block mt-2">Last Name:</label>
                <input type="text" id="lname" name="lname" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">
            </div>

            <!-- Business Information -->
            <div class="col-span-1">
                <h3 class="text-lg font-medium mb-2">Business Information</h3>
                <label for="businessName" class="block">Business Name:</label>
                <input type="text" id="businessName" name="businessName" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="businessAddress" class="block mt-2">Business Address:</label>
                <input type="text" id="businessAddress" name="businessAddress" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

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
            </div>

            <!-- Business Type and Certificate Info -->
            <div class="col-span-1">
                <h3 class="text-lg font-medium mb-2">Certificate Information</h3>
                <label for="typeOfBusiness" class="block">Type of Business:</label>
                <input type="text" id="typeOfBusiness" name="typeOfBusiness" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="certAmount" class="block mt-2">Certificate Amount:</label>
                <input type="text" id="certAmount" name="certAmount" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">

                <label for="dateIssued" class="block mt-2">Date Issued:</label>
                <input type="date" id="dateIssued" name="dateIssued" required class="mt-1 block w-64 border border-gray-300 rounded-md shadow-sm p-2">
            </div>
        </div>

        <button type="submit" class="mt-6 w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600">Add Certificate</button>
    </form>
</div>

