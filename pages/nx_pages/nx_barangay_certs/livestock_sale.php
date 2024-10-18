<?php
// Fetch walk-in data from the database
$sqlWalkin = "SELECT * FROM livestock_cert WHERE status = 'Walk-in'";
$resultWalkin = $conn->query($sqlWalkin);
$walkinData = $resultWalkin->fetch_all(MYSQLI_ASSOC);

// Fetch other data as needed
$sqlNew = "SELECT * FROM livestock_cert WHERE status = 'New'";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlApproved = "SELECT * FROM livestock_cert WHERE status = 'Approved'";
$resultApproved = $conn->query($sqlApproved);
$approvedData = $resultApproved->fetch_all(MYSQLI_ASSOC);

$sqlDisapproved = "SELECT * FROM livestock_cert WHERE status = 'Disapproved'";
$resultDisapproved = $conn->query($sqlDisapproved);
$disapprovedData = $resultDisapproved->fetch_all(MYSQLI_ASSOC);

$sqlDone = "SELECT * FROM livestock_cert WHERE status = 'Done'";
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
    $('#walkinTable').DataTable({"scrollX": true});
    $('#newTable').DataTable({"scrollX": true});
    $('#approvedTable').DataTable({"scrollX": true});
    $('#disapprovedTable').DataTable({"scrollX": true});
    $('#doneTable').DataTable({"scrollX": true});
    
    // Initialize jQuery UI Tabs
    $("#tabs").tabs();
});
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Livestock Sale Certificate</h1>
    <hr class="mb-3 mt-3">

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
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walkinData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Actions here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="new">
            <table id="newTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Actions here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="approved">
            <table id="approvedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Actions here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="disapproved">
            <table id="disapprovedTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disapprovedData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Actions here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div id="done">
            <table id="doneTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Seller Name</th>
                        <th>Buyer Name</th>
                        <th>Item Sold</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doneData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><!-- Actions here --></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>
