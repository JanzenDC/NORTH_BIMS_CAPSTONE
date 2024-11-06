<?php
$sqlWalkin = "SELECT * FROM land_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
    }
}

$sqlNew = "SELECT * FROM land_cert WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);

$newData = [];
if ($resultNew->num_rows > 0) {
    while ($row = $resultNew->fetch_assoc()) {
        $newData[] = $row;
    }
}

$sqlApproved = "SELECT * FROM land_cert WHERE status = 'Approved'";
$resultApproved = $conn->query($sqlApproved);

$approvedData = [];
if ($resultApproved->num_rows > 0) {
    while ($row = $resultApproved->fetch_assoc()) {
        $approvedData[] = $row;
    }
}

$sqlDisApproved = "SELECT * FROM land_cert WHERE status = 'Dispproved'";
$resultDisApproved = $conn->query($sqlDisApproved);

$disapprovedData = [];
if ($resultDisApproved->num_rows > 0) {
    while ($row = $resultDisApproved->fetch_assoc()) {
        $disapprovedData[] = $row;
    }
}

$sqlDone = "SELECT * FROM land_cert WHERE status = 'Done'";
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

    // jquery Ui dialogs
    $( "#ViewDialog" ).dialog({
      autoOpen: false,
      modal: true,
      width:  800,
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
});

function ViewLand(targetID){
    console.log(targetID);
    $.get('nx_query/certificate_land.php?action=get&id=' + targetID, function(response) {
        if (response.success) {
            const official = response.data;
            console.log(response.data);
            document.getElementById('sellerName').value = official.sellerName;
            document.getElementById('sellerAddress').value = official.sellerAddress;
            document.getElementById('buyerName').value = official.buyerName;
            document.getElementById('buyerAddress').value = official.buyerAddress;

            document.getElementById('landArea').value = official.landArea;
            document.getElementById('propertySold').value = official.propertySold;
            document.getElementById('amount').value = official.amount;
            document.getElementById('amount_words').value = official.amount_words;
            document.getElementById('legalAgree').value = official.legalAgree;
            document.getElementById('paymentConfirm').value = official.paymentConfirm;
            document.getElementById('witness').value = official.witness;
            document.getElementById('locationNota').value = official.locationNota;
            document.getElementById('cert_amount').value = official.cert_amount;
            document.getElementById('note').value = official.note;
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

function AddCert(){
    $("#AddCertDialogOpen").dialog("open");
}
function submitCert() {
    
    const sellerName = document.getElementById("new_sellerName").value;
    const sellerAddress = document.getElementById("new_sellerAddress").value;
    const buyerName = document.getElementById("new_buyerName").value;
    const buyerAddress = document.getElementById("new_buyerAddress").value;
    const landArea = document.getElementById("new_landArea").value;
    const propertySold = document.getElementById("new_propertyAddress").value; // Update propertyAddress to propertySold
    const saleAgreement = document.getElementById("new_saleAgreement").value;
    const buyersPayment = document.getElementById("new_buyersPayment").value;
    const receiptOfPayment = document.getElementById("new_receiptOfPayment").value;
    const date = document.getElementById("new_date").value;
    const witness = document.getElementById("new_witness").value;
    const notarizeDate = document.getElementById("new_datenotarization").value; // Updated dateOfNotarization to notarizeDate

    // Create an object to hold the values
    const data = {
        sellerName,
        sellerAddress,
        buyerName,
        buyerAddress,
        landArea,
        propertySold,
        saleAgreement,
        buyersPayment,
        receiptOfPayment,
        date,
        witness,
        notarizeDate
    };

    $.ajax({
        url: 'nx_query/certificate_land.php?action=create',
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
function editSave(){
    const hiddenID = document.getElementById("hiddenID").value;
    const AmountEdit =  document.getElementById("AmountEdit").value;
    const data = {
        hiddenID,
        AmountEdit
    };
    $.ajax({
        url: 'nx_query/certificate_land.php?action=updateAmount',
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
                url: 'nx_query/certificate_land.php?action=setAsApprove', // Change to setAsApprove
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
                url: 'nx_query/certificate_land.php?action=setDisapproved', // Change to setAsApprove
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
            url: 'nx_query/certificate_land.php?action=mark_done',
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
    <h1 class="text-3xl font-bold">Deed of Sale for Land Certificate</h1>
    <hr class="mb-3 mt-3">
    
    <div>
        <button id="open-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200" onclick='AddCert()'>Add Certificate</button>
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
                            <div class="bg-yellow-300 rounded-lg p-2" title='View' onclick="ViewLand(<?php echo htmlspecialchars($row['id']);?>)">
                                <i class="fa-solid fa-eye"></i>
                            </div>
                            <div class="bg-blue-400 rounded-lg p-2 " title='Edit'  onclick="editCert(<?php echo htmlspecialchars($row['id']);?>)">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <a href='GenerateCertificate.php?page=bilihannglupa&id=<?php echo htmlspecialchars($row['id']);?>' class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</a>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($newData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                        <td class="flex space-x-2">
                            <div class="bg-green-400 rounded-lg p-2 " title='Approve'  onclick="approveCert(<?php echo htmlspecialchars($row['id']);?>)">
                               <i class="fa-solid fa-thumbs-up"></i>
                            </div>
                            <div class="bg-red-400 rounded-lg p-2 " title='Disapprove' onclick="disapproveCert(<?php echo htmlspecialchars($row['id']);?>)">
                                <i class="fa-solid fa-thumbs-down"></i>
                            </div>
                        </td>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                        <td class="flex space-x-2">
                            <div class="bg-green-400 rounded-lg p-2 flex items-center gap-2" title='Mark as Done'  onclick="doneCert(<?php echo htmlspecialchars($row['id']);?>)">
                               <i class="fa-solid fa-circle-check"></i> Done
                            </div>
                        </td>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                     <?php foreach ($approvedData as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']);?></td>
                        <td><?php echo htmlspecialchars($row['sellerName']);?></td>
                        <td><?php echo htmlspecialchars($row['buyerName']);?></td>
                        <td><?php echo htmlspecialchars($row['date_of_pickup']);?></td>
                        <td class="flex space-x-2">
                            <div class="bg-green-400 rounded-lg p-2 flex items-center gap-2" title='Mark as Done'  onclick="doneCert(<?php echo htmlspecialchars($row['id']);?>)">
                               <i class="fa-solid fa-circle-check"></i> Done
                            </div>
                        </td>
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
                            <div class="bg-yellow-300 rounded-lg p-2" title='View' onclick="ViewLand(<?php echo htmlspecialchars($row['id']);?>)">
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



<!-- DIALOGS -->
 <div id="ViewDialog" title="View Details">
    <div>
        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Seller Info
            </div>
            <div class="p-3 border border-black">
                Seller Name:  <input type="text" id="sellerName" disabled/><br>
                Seller Address:  <input type="text" id="sellerAddress" disabled/><br>
            </div>
        </div>

        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Buyer Info
            </div>
            <div class="p-3 border border-black">
                Buyer Name:  <input type="text" id="buyerName" disabled/><br>
                Buyer Address:  <input type="text" id="buyerAddress" disabled/><br>
            </div>
        </div>

        <div class="mb-3">
            <div class='bg-green-600 text-white w-full p-3 rounded-t-lg'> Other Info
            </div>
            <div class="p-3 border border-black grid grid-cols-3">
                <div class="flex items-center">
                    <div class='w-1/2'>Land Area (sq ft):</div> 
                    <div class='w-1/2'>
                        <input type="text" id="landArea" disabled/>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Property Sold:</div>
                    <div class='w-1/2'>
                        <input type="text" id="propertySold" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Amount:</div>
                    <div class='w-1/2'>
                        <input type="text" id="amount" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Amount in Words:</div>
                    <div class='w-1/2'>
                        <input type="text" id="amount_words" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Legal Agreement:</div>
                    <div class='w-1/2'>
                        <input type="text" id="legalAgree" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Payment Condition:</div>
                    <div class='w-1/2'>
                        <input type="text" id="paymentConfirm" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Witness:</div>
                    <div class='w-1/2'>
                        <input type="text" id="witness" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Notarize Date:</div>
                    <div class='w-1/2'>
                        <input type="text" id="notarizeDate" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Location:</div>
                    <div class='w-1/2'>
                        <input type="text" id="locationNota" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Certificate Amount:</div>
                    <div class='w-1/2'>
                        <input type="text" id="cert_amount" disabled/><br>
                    </div>
                </div>

                <div class="flex items-center">
                    <div class='w-1/2'>Note:</div>
                    <div class='w-1/2'>
                        <input type="text" id="note" disabled/><br>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Add Certificate -->
<div id="AddCertDialogOpen" title="Add Certificate" class="p-6 bg-white rounded-lg shadow-md">
    <div class="mb-4">
        <label for="new_sellerName" class="block text-sm font-medium text-gray-700">Seller Name:</label>
        <input type="text" id="new_sellerName" name="new_sellerName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_sellerAddress" class="block text-sm font-medium text-gray-700">Seller Address:</label>
        <input type="text" id="new_sellerAddress" name="new_sellerAddress" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_buyerName" class="block text-sm font-medium text-gray-700">Buyer Name:</label>
        <input type="text" id="new_buyerName" name="new_buyerName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_buyerAddress" class="block text-sm font-medium text-gray-700">Buyer Address:</label>
        <input type="text" id="new_buyerAddress" name="new_buyerAddress" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_landArea" class="block text-sm font-medium text-gray-700">Land Area:</label>
        <input type="text" id="new_landArea" name="new_landArea" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_propertyAddress" class="block text-sm font-medium text-gray-700">Property Address:</label>
        <input type="text" id="new_propertyAddress" name="new_propertyAddress" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_saleAgreement" class="block text-sm font-medium text-gray-700">Agreed Price:</label>
        <input type="text" id="new_saleAgreement" name="new_saleAgreement" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_buyersPayment" class="block text-sm font-medium text-gray-700">Buyer's Payment:</label>
        <input type="text" id="new_buyersPayment" name="new_buyersPayment" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_receiptOfPayment" class="block text-sm font-medium text-gray-700">Receipt of Payment:</label>
        <input type="text" id="new_receiptOfPayment" name="new_receiptOfPayment" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_date" class="block text-sm font-medium text-gray-700">Date:</label>
        <input type="date" id="new_date" name="new_date" placeholder="mm/dd/yyyy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_witness" class="block text-sm font-medium text-gray-700">Witness:</label>
        <input type="text" id="new_witness" name="new_witness" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

    <div class="mb-4">
        <label for="new_date" class="block text-sm font-medium text-gray-700">Date Notarization:</label>
        <input type="date" id="new_datenotarization" name="new_date" placeholder="mm/dd/yyyy" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200" required>
    </div>

</div>

<!-- Edit Amount -->

<div id="EditAmount" title="Edit Certificate" class="p-6 bg-white rounded-lg shadow-md">
    <input type="hidden" id='hiddenID' value=''>
    <p>Amount</p>
    <input type='number' value='' id='AmountEdit' name='AmountEdit'>
</div>