<?php
$userid = $_SESSION['user']['id'];
$sqlWalkin = "SELECT * FROM vehicle_cert WHERE status = 'Walk-in' AND created_by ='$userid'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

$sqlNew = "SELECT * FROM vehicle_cert WHERE status = 'New' AND created_by ='$userid'";
$resultNew = $conn->query($sqlNew);

$newData = [];
if ($resultNew->num_rows > 0) {
    while ($row = $resultNew->fetch_assoc()) {
        $newData[] = $row;
    }
}

$sqlApproved = "SELECT * FROM vehicle_cert WHERE status = 'Approved' AND created_by ='$userid' AND created_by ='$userid'";
$resultApproved = $conn->query($sqlApproved);

$approvedData = [];
if ($resultApproved->num_rows > 0) {
    while ($row = $resultApproved->fetch_assoc()) {
        $approvedData[] = $row;
    }
}

$sqlDisApproved = "SELECT * FROM vehicle_cert WHERE status = 'Dispproved'";
$resultDisApproved = $conn->query($sqlDisApproved);

$disapprovedData = [];
if ($resultDisApproved->num_rows > 0) {
    while ($row = $resultDisApproved->fetch_assoc()) {
        $disapprovedData[] = $row;
    }
}

$sqlDone = "SELECT * FROM vehicle_cert WHERE status = 'Done'";
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
    // Initialize DataTables
    $('#walkinTable, #newTable, #approvedTable, #disapprovedTable, #doneTable, #residentTable').DataTable({
        "scrollX": true, // Enable horizontal scrolling
        "searching": true // Enable the search feature for all but walkinTable
    });

    // Initialize jQuery UI Tabs
    $("#tabs").tabs();

    // DIALOGS
    $( "#ViewDialog" ).dialog({
      autoOpen: false,
      modal: true,
      width:  800,
    });
    $( "#AddCertDialogOpen" ).dialog({
      autoOpen: false,
      modal: true,
      width:  600,
      height: 400,
      buttons: {
        Submit: function(){
            submitCert();
        },
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $( "#EditAmount" ).dialog({
      autoOpen: false,
      modal: true,
      width:  250,
      height: 200,
      buttons: {
        Submit: function(){
            editSave();
        },
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
});
function editSave(){
    const hiddenID = document.getElementById("hiddenID").value;
    const AmountEdit =  document.getElementById("AmountEdit").value;
    const data = {
        hiddenID,
        AmountEdit
    };
    $.ajax({
        url: 'nx_query/certificate_vehicle.php?action=updateAmount',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log(response)
            if (response.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or update the UI as needed
                    $('#approvedDialog').dialog("close"); // Close the dialog
                });
            } else {
                // Handle error message from server
                console.error(response.message);
                swal("Error creating certificate", response.message, {
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
function editCert(x)
{
    document.getElementById('hiddenID').value = x;
    $("#EditAmount").dialog("open");
}
function AddCert(){
    $("#AddCertDialogOpen").dialog("open");
}
function submitCert() {
    const data = {
        sellerName: document.getElementById("New_sellerName").value,
        sellerAddress: document.getElementById("New_sellerAddress").value,
        amount: document.getElementById("New_amount").value,
        amount_words: document.getElementById("New_amountWords").value,
        buyerName: document.getElementById("New_buyerName").value,
        buyerAddress: document.getElementById("New_buyerAddress").value,
        make: document.getElementById("New_make").value,
        plateNumber: document.getElementById("New_plateNumber").value,
        engineNumber: document.getElementById("New_engineNumber").value,
        chasisNumber: document.getElementById("New_chasisNumber").value,
        denomination: document.getElementById("New_denomination").value,
        fuel: document.getElementById("New_fuel").value,
        bodyType: document.getElementById("New_bodyType").value,
        crNo: document.getElementById("New_crNo").value,
        date: document.getElementById("New_date").value,
        witness: document.getElementById("New_witness").value,
        locationTransaction: document.getElementById("New_locationTransaction").value,
        certificateAmount: document.getElementById("New_certificateAmount").value
    };

    $.ajax({
        url: 'nx_query/certificate_vehicle.php?action=create',
        type: 'POST',
        data: data,
        success: function(response) {
            console.log(response);
            if (response.success) {
                swal("Record updated successfully!", {
                    icon: "success",
                }).then(() => {
                    location.reload(); // Reload the page or update the UI as needed
                    $('#approvedDialog').dialog("close"); // Close the dialog
                });
            } else {
                // Handle error message from server
                console.error(response.message);
                swal("Error creating certificate", response.message, {
                    icon: "error",
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Server response:', xhr.responseText);
            let errorMessage = "An error occurred while processing your request.";
            try {
                const result = JSON.parse(xhr.responseText);
                errorMessage = result.message || errorMessage;
            } catch (e) {
                // If the response isn't JSON, use the raw response text
                errorMessage = xhr.responseText || errorMessage;
            }
            swal("Error", errorMessage, "error");
        }
    });
}

function ViewVehicle(targetID) {
    console.log(targetID);
    $.get('nx_query/certificate_vehicle.php?action=get&id=' + targetID, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(response.data);
            document.getElementById('view_sellerName').value = official.sellerName;
            document.getElementById('view_sellerAddress').value = official.sellerAddress;
            document.getElementById('view_buyerName').value = official.buyerName;
            document.getElementById('view_buyerAddress').value = official.buyerAddress;

            document.getElementById('view_amount').value = official.amount;
            document.getElementById('view_amountWords').value = official.amount_words;
            document.getElementById('view_make').value = official.make;
            document.getElementById('view_plateNum').value = official.plateNum;
            document.getElementById('view_engineNum').value = official.engineNum;
            document.getElementById('view_chasisNum').value = official.chasisNum;
            document.getElementById('view_denomination').value = official.denomination;
            document.getElementById('view_fuel').value = official.fuel;
            document.getElementById('view_bodyType').value = official.bodyType;
            document.getElementById('view_crNo').value = official.crNo;
            document.getElementById('view_date').value = official.date;
            document.getElementById('view_witness').value = official.witness;
            document.getElementById('view_locationTransaction').value = official.locationTran;
            document.getElementById('view_cert_amount').value = official.cert_amount;
            document.getElementById('view_note').value = official.note;

            $("#ViewDialog").dialog("open");
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
                url: 'nx_query/certificate_vehicle.php?action=setAsApprove', // Change to setAsApprove
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
                url: 'nx_query/certificate_vehicle.php?action=setDisapproved', // Change to setAsApprove
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
function doneCert(id) {
    if (confirm('Are you sure you want to mark this certificate as done?')) {
        // Send AJAX request to the server
        $.ajax({
            url: 'nx_query/certificate_vehicle.php?action=mark_done',
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
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Vehicle Certificate</h1>
    <hr class="mb-3 mt-3">
    
    <div>
        <button id="open-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200" onclick="AddCert()">Add Certificate</button>
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
            <table id="walkinTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Date of Pickup</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($walkinData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                        <td class="flex space-x-2">
                            <div class="bg-yellow-300 rounded-lg p-2" title='View' onclick="ViewVehicle(<?php echo htmlspecialchars($row['id']);?>)">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="new">
            <table id="newTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Date of Pickup</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($newData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="approved">
            <table id="approvedTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Date of Pickup</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="disapproved">
            <table id="disapprovedTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Date of Pickup</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="done">
            <table id="doneTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Date of Pickup</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($doneData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                        <td class="flex space-x-2">
                            <div class="bg-yellow-300 rounded-lg p-2" title='View' onclick="ViewVehicle(<?php echo htmlspecialchars($row['id']);?>)">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <div class="bg-green-400 rounded-lg p-2 " title='Done'>
                                Done
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<!-- Add Certificate -->
<div id="AddCertDialogOpen" title="Add Certificate" class="p-6 bg-white rounded-lg shadow-md">
    <div class="mb-4">
        <label for="New_sellerName" class="block font-medium">Seller Name:</label>
        <input type="text" id="New_sellerName" name="sellerName" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_sellerAddress" class="block font-medium">Seller Address:</label>
        <input type="text" id="New_sellerAddress" name="sellerAddress" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_amount" class="block font-medium">Amount:</label>
        <input type="number" id="New_amount" name="amount" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_amountWords" class="block font-medium">Amount in Words:</label>
        <input type="text" id="New_amountWords" name="amount_words" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_buyerName" class="block font-medium">Buyer Name:</label>
        <input type="text" id="New_buyerName" name="buyerName" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_buyerAddress" class="block font-medium">Buyer Address:</label>
        <input type="text" id="New_buyerAddress" name="buyerAddress" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_make" class="block font-medium">Make:</label>
        <input type="text" id="New_make" name="make" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_plateNumber" class="block font-medium">Plate Number:</label>
        <input type="text" id="New_plateNumber" name="plateNumber" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_engineNumber" class="block font-medium">Engine Number:</label>
        <input type="text" id="New_engineNumber" name="engineNumber" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_chasisNumber" class="block font-medium">Chassis Number:</label>
        <input type="text" id="New_chasisNumber" name="chasisNumber" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_denomination" class="block font-medium">Denomination:</label>
        <input type="text" id="New_denomination" name="denomination" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_fuel" class="block font-medium">Fuel:</label>
        <input type="text" id="New_fuel" name="fuel" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_bodyType" class="block font-medium">Body Type:</label>
        <input type="text" id="New_bodyType" name="bodyType" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_crNo" class="block font-medium">CR. No:</label>
        <input type="number" id="New_crNo" name="crNo" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_date" class="block font-medium">Date:</label>
        <input type="date" id="New_date" name="date" class="border rounded p-2 w-full" required>
        <small class="text-gray-500">Format: mm/dd/yyyy</small>
    </div>

    <div class="mb-4">
        <label for="New_witness" class="block font-medium">Witness:</label>
        <input type="text" id="New_witness" name="witness" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_locationTransaction" class="block font-medium">Location of Transaction:</label>
        <input type="text" id="New_locationTransaction" name="locationTransaction" class="border rounded p-2 w-full" required>
    </div>

    <div class="mb-4">
        <label for="New_certificateAmount" class="block font-medium">Certificate Amount:</label>
        <input type="number" id="New_certificateAmount" name="certificateAmount" class="border rounded p-2 w-full" required>
    </div>
</div>


<div id="ViewDialog" title="View Details">
    <div>
        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Seller Info
            </div>
            <div class="p-3 border border-black">
                Seller Name:  <input type="text" id="view_sellerName" disabled/><br>
                Seller Address:  <input type="text" id="view_sellerAddress" disabled/><br>
            </div>
        </div>

        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Buyer Info
            </div>
            <div class="p-3 border border-black">
                Buyer Name:  <input type="text" id="view_buyerName" disabled/><br>
                Buyer Address:  <input type="text" id="view_buyerAddress" disabled/><br>
            </div>
        </div>

        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Other Info
            </div>
            <div class="p-3 border border-black grid grid-cols-3">
                <div class="flex items-center">
                    <div class='w-1/2'>Amount:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_amount" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Amount in Words:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_amountWords" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Make:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_make" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Plate Number:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_plateNum" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Engine Number:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_engineNum" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Chassis Number:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_chasisNum" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Denomination:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_denomination" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Fuel:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_fuel" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Body Type:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_bodyType" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>CR. No:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_crNo" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Date:</div>
                    <div class='w-1/2'>
                        <input type="date" id="view_date" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Witness:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_witness" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Location of Transaction:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_locationTransaction" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Certificate Amount:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_cert_amount" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Note:</div>
                    <div class='w-1/2'>
                        <input type="text" id="view_note" disabled/><br>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>


<div id="EditAmount" title="Edit Certificate" class="p-6 bg-white rounded-lg shadow-md">
    <input type="hidden" id='hiddenID' value=''>
    <p>Amount</p>
    <input type='number' value='' id='AmountEdit' name='AmountEdit'>
</div>