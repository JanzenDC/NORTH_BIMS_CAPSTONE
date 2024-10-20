<?php
$sqlWalkin = "SELECT * FROM land_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);

$walkinData = [];
if ($resultWalkin->num_rows > 0) {
    while ($row = $resultWalkin->fetch_assoc()) {
        $walkinData[] = $row;
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
    //   buttons: {
    //     Ok: function() {
    //       $( this ).dialog( "close" );
    //     }
    //   }
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
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Deed of Sale for Land Certificate</h1>
    <hr class="mb-3 mt-3">
    
    <div>
        <button id="open-dialog" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Add Certificate</button>
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
                            <div class="bg-blue-400 rounded-lg p-2 " title='Edit'>
                                <i class="fa-solid fa-pen-to-square"></i>
                            </div>
                            <div class="bg-green-400 rounded-lg p-2 " title='Generate'>
                                <i class="fa-solid fa-arrows-rotate"></i>
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
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Data 1</td>
                        <td>Data 2</td>
                        <td>Data 3</td>
                    </tr>
                    <!-- More rows as needed -->
                </tbody>
            </table>
        </div>

        <div id="approved">
            <table id="approvedTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="disapproved">
            <table id="disapprovedTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

        <div id="done">
            <table id="doneTable" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 3</th>
                    </tr>
                </thead>
                <tbody>
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