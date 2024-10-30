<?php
$userid = $_SESSION['user']['id'];
// Fetch walk-in data from the database
$sqlWalkin = "SELECT * FROM livestock_cert WHERE status = 'Walk-in' AND created_by ='$userid'";
$resultWalkin = $conn->query($sqlWalkin);
$walkinData = $resultWalkin->fetch_all(MYSQLI_ASSOC);

// Fetch other data as needed
$sqlNew = "SELECT * FROM livestock_cert WHERE status = 'New' AND created_by ='$userid'";
$resultNew = $conn->query($sqlNew);
$newData = $resultNew->fetch_all(MYSQLI_ASSOC);

$sqlApproved = "SELECT * FROM livestock_cert WHERE status = 'Approved' AND created_by ='$userid'";
$resultApproved = $conn->query($sqlApproved);
$approvedData = $resultApproved->fetch_all(MYSQLI_ASSOC);

$sqlDisapproved = "SELECT * FROM livestock_cert WHERE status = 'Disapproved' AND created_by ='$userid'";
$resultDisapproved = $conn->query($sqlDisapproved);
$disapprovedData = $resultDisapproved->fetch_all(MYSQLI_ASSOC);

$sqlDone = "SELECT * FROM livestock_cert WHERE status = 'Done' AND created_by ='$userid'";
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
    $('#walkinTable, #newTable, #approvedTable, #disapprovedTable, #doneTable').DataTable({
        "scrollX": true // Enable horizontal scrolling
    });
    
    // Initialize jQuery UI Tabs
    $("#tabs").tabs();

    // Initialize dialog for adding certificate
    $("#addCertificateDialog").dialog({
        autoOpen: false, // Don't open it immediately
        modal: true,
        width: 900,
    });

    // Open dialog on button click
    $("#openDialogButton").click(function() {
        $("#addCertificateDialog").dialog("open");
    });

    $('#editCertificateForm').on('submit', function(event) {
    event.preventDefault();
    
    const formData = {
        id: document.getElementById('editIDs').value,
        note: document.getElementById('editNote').value
    };
    console.log(formData)
    $.ajax({
        url: 'nx_query/certificate_livestock.php?action=updateNote',
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

    $('#editDialog').dialog({
        title: "Edit Certificate Notes",
        modal: true,
        autoOpen: false,
        width: 400,
    });
});

function addRecord(event) {
    event.preventDefault();

    const formData = new FormData(document.getElementById('addCertificateForm'));
    
    $.ajax({
        url: 'nx_query/certificate_livestock.php?action=create',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $('button[type="submit"]').prop('disabled', true).text('Submitting...');
        },
        success: function(response) {
            try {
                // First check if response is already an object
                const result = typeof response === 'object' ? response : JSON.parse(response);
                
                if (result.success) {
                    swal("Success", "Certificate added successfully!", "success")
                        .then(() => {
                            location.reload();
                            $('#addCertificateDialog').dialog("close");
                        });
                } else {
                    swal("Error", result.message || "Failed to add certificate", "error");
                }
            } catch (e) {
                console.error('Parse error:', e);
                // If we get here, the response wasn't valid JSON
                swal("Error", "Server returned an invalid response", "error");
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
        },
        complete: function() {
            $('button[type="submit"]').prop('disabled', false).text('Request');
        }
    });
}
</script>

<div class="p-3 w-full bg-white">
    <h1 class="text-3xl font-bold">Livestock Sale Certificate</h1>
    <hr class="mb-3 mt-3">
    <div>
        <button id="openDialogButton" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Request</button>
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
                        <th>Seller Name</th>
                        <th>Seller Address</th>
                        <th>Amount</th>
                        <th>Amount in Words</th>
                        <th>Buyer Name</th>
                        <th>Buyer Address</th>
                        <th>Kind of Animal</th>
                        <th>Quantity</th>
                        <th>Age of Animal</th>
                        <th>Sex of Animal</th>
                        <th>Cowlicks</th>
                        <th>Brand of Municipality</th>
                        <th>Brand of Owner</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($walkinData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['sellerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount_words']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['sex']); ?></td>
                        <td><?php echo htmlspecialchars($data['cowlicks']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandMun']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandOwn']); ?></td>
                        <td><?php echo htmlspecialchars($data['transacDate']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td class="flex space-x-2">
                            <button class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-200">Generate</button>
                            <button class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-200" onclick="doneCert(<?php echo htmlspecialchars($data['id']); ?>)">Done</button>
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
                        <th>Seller Name</th>
                        <th>Seller Address</th>
                        <th>Amount</th>
                        <th>Amount in Words</th>
                        <th>Buyer Name</th>
                        <th>Buyer Address</th>
                        <th>Kind of Animal</th>
                        <th>Quantity</th>
                        <th>Age of Animal</th>
                        <th>Sex of Animal</th>
                        <th>Cowlicks</th>
                        <th>Brand of Municipality</th>
                        <th>Brand of Owner</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($newData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['sellerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount_words']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['sex']); ?></td>
                        <td><?php echo htmlspecialchars($data['cowlicks']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandMun']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandOwn']); ?></td>
                        <td><?php echo htmlspecialchars($data['transacDate']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
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
                        <th>Seller Address</th>
                        <th>Amount</th>
                        <th>Amount in Words</th>
                        <th>Buyer Name</th>
                        <th>Buyer Address</th>
                        <th>Kind of Animal</th>
                        <th>Quantity</th>
                        <th>Age of Animal</th>
                        <th>Sex of Animal</th>
                        <th>Cowlicks</th>
                        <th>Brand of Municipality</th>
                        <th>Brand of Owner</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($approvedData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['sellerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount_words']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['sex']); ?></td>
                        <td><?php echo htmlspecialchars($data['cowlicks']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandMun']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandOwn']); ?></td>
                        <td><?php echo htmlspecialchars($data['transacDate']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
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
                        <th>Seller Address</th>
                        <th>Amount</th>
                        <th>Amount in Words</th>
                        <th>Buyer Name</th>
                        <th>Buyer Address</th>
                        <th>Kind of Animal</th>
                        <th>Quantity</th>
                        <th>Age of Animal</th>
                        <th>Sex of Animal</th>
                        <th>Cowlicks</th>
                        <th>Brand of Municipality</th>
                        <th>Brand of Owner</th>
                        <th>Transaction Date</th>
                        <th>Status</th>
                        <th>Certificate Amount</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($disapprovedData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['sellerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount_words']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['sex']); ?></td>
                        <td><?php echo htmlspecialchars($data['cowlicks']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandMun']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandOwn']); ?></td>
                        <td><?php echo htmlspecialchars($data['transacDate']); ?></td>
                        <td><?php echo htmlspecialchars($data['status']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
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
                        <th>Seller Name</th>
                        <th>Seller Address</th>
                        <th>Amount</th>
                        <th>Amount in Words</th>
                        <th>Buyer Name</th>
                        <th>Buyer Address</th>
                        <th>Kind of Animal</th>
                        <th>Quantity</th>
                        <th>Age of Animal</th>
                        <th>Sex of Animal</th>
                        <th>Cowlicks</th>
                        <th>Brand of Municipality</th>
                        <th>Brand of Owner</th>
                        <th>Transaction Date</th>
                        <th>Certificate Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($doneData as $data): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['sellerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['sellerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount']); ?></td>
                        <td><?php echo htmlspecialchars($data['amount_words']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerName']); ?></td>
                        <td><?php echo htmlspecialchars($data['buyerAddress']); ?></td>
                        <td><?php echo htmlspecialchars($data['itemSold']); ?></td>
                        <td><?php echo htmlspecialchars($data['quantity']); ?></td>
                        <td><?php echo htmlspecialchars($data['age']); ?></td>
                        <td><?php echo htmlspecialchars($data['sex']); ?></td>
                        <td><?php echo htmlspecialchars($data['cowlicks']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandMun']); ?></td>
                        <td><?php echo htmlspecialchars($data['brandOwn']); ?></td>
                        <td><?php echo htmlspecialchars($data['transacDate']); ?></td>
                        <td><?php echo htmlspecialchars($data['cert_amount']); ?></td>
                        <td>
                            <div class="bg-green-400 p-2 text-center rounded-full border border-green-700 text-white">
                                <?php echo htmlspecialchars($data['status']); ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>




    
<div id="addCertificateDialog" title="Request" style="display:none;" class="p-6 bg-white rounded-lg shadow-md max-w-4xl mx-auto">
    <form id="addCertificateForm" onsubmit="addRecord(event)">
        <h2 class="text-xl font-bold mb-4">Request</h2>
        <input type="hidden" id="created_by" value="<?= $userid ?>" name="created_by" class="mt-1 p-2 border rounded w-full" placeholder="Enter seller name" required>
        <!-- Page 1: Seller and Buyer Information -->
        <div id="page1" class="page">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Seller Information Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Seller Information</h3>
                    <label for="sellerName" class="block text-gray-700">Seller Name:</label>
                    <input type="text" id="sellerName" name="sellerName" class="mt-1 p-2 border rounded w-full" placeholder="Enter seller name" required>
                    
                    <label for="sellerAddress" class="block text-gray-700 mt-2">Seller Address:</label>
                    <input type="text" id="sellerAddress" name="sellerAddress" class="mt-1 p-2 border rounded w-full" placeholder="Enter seller address" required>
                </div>

                <!-- Buyer Information Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Buyer Information</h3>
                    <label for="buyerName" class="block text-gray-700">Buyer Name:</label>
                    <input type="text" id="buyerName" name="buyerName" class="mt-1 p-2 border rounded w-full" placeholder="Enter buyer name" required>
                    
                    <label for="buyerAddress" class="block text-gray-700 mt-2">Buyer Address:</label>
                    <input type="text" id="buyerAddress" name="buyerAddress" class="mt-1 p-2 border rounded w-full" placeholder="Enter buyer address" required>
                </div>
            </div>
        </div>

        <!-- Page 2: Animal and Transaction Details -->
        <div id="page2" class="page hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Animal Details Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Animal Details</h3>
                    <label for="kindOfAnimal" class="block text-gray-700">Kind of Animal:</label>
                    <input type="text" id="kindOfAnimal" name="kindOfAnimal" class="mt-1 p-2 border rounded w-full" placeholder="Enter kind of animal" required>
                    
                    <label for="quantity" class="block text-gray-700 mt-2">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" class="mt-1 p-2 border rounded w-full" placeholder="Enter quantity" required>
                    
                    <label for="ageOfAnimal" class="block text-gray-700 mt-2">Age of Animal:</label>
                    <input type="text" id="ageOfAnimal" name="ageOfAnimal" class="mt-1 p-2 border rounded w-full" placeholder="Enter age of animal" required>
                    
                    <label for="sexOfAnimal" class="block text-gray-700 mt-2">Sex of Animal:</label>
                    <input type="text" id="sexOfAnimal" name="sexOfAnimal" class="mt-1 p-2 border rounded w-full" placeholder="Enter sex of animal" required>
                </div>

                <!-- Transaction Details Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Transaction Details</h3>
                    <label for="amount" class="block text-gray-700">Amount:</label>
                    <input type="number" id="amount" name="amount" class="mt-1 p-2 border rounded w-full" placeholder="Enter amount" required>
                    
                    <label for="amountInWords" class="block text-gray-700 mt-2">Amount in Words:</label>
                    <input type="text" id="amountInWords" name="amountInWords" class="mt-1 p-2 border rounded w-full" placeholder="Enter amount in words" required>

                    <label for="transactionDate" class="block text-gray-700 mt-2">Transaction Date:</label>
                    <input type="date" id="transactionDate" name="transactionDate" class="mt-1 p-2 border rounded w-full" required>
                </div>
            </div>
        </div>

        <!-- Page 3: Additional and Pickup Information -->
        <div id="page3" class="page hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Additional Details Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Additional Details</h3>
                    <label for="cowlicks" class="block text-gray-700">Cowlicks:</label>
                    <input type="text" id="cowlicks" name="cowlicks" class="mt-1 p-2 border rounded w-full" placeholder="Enter cowlicks">
                    
                    <label for="brandOfMunicipality" class="block text-gray-700 mt-2">Brand of Municipality:</label>
                    <input type="text" id="brandOfMunicipality" name="brandOfMunicipality" class="mt-1 p-2 border rounded w-full" placeholder="Enter brand of municipality">

                    <label for="brandOfOwner" class="block text-gray-700 mt-2">Brand of Owner:</label>
                    <input type="text" id="brandOfOwner" name="brandOfOwner" class="mt-1 p-2 border rounded w-full" placeholder="Enter brand of owner">
                </div>

                <!-- Pickup Information Panel -->
                <div class="bg-gray-100 p-4 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-2">Pickup Information</h3>
                    <label for="certificateAmount" class="block text-gray-700">Certificate Amount:</label>
                    <input type="number" id="certificateAmount" name="certificateAmount" class="mt-1 p-2 border rounded w-full" placeholder="Enter certificate amount">
                    
                    <label for="dateOfPickup" class="block text-gray-700 mt-2">Date of Pickup:</label>
                    <input type="date" id="dateOfPickup" name="dateOfPickup" class="mt-1 p-2 border rounded w-full">
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-4">
            <button id="prevButton" type="button" class="bg-gray-300 text-gray-700 hover:bg-gray-400 rounded px-4 py-2" disabled>Previous</button>
            <button id="nextButton" type="button" class="bg-green-500 text-white hover:bg-green-600 rounded px-4 py-2">Next</button>
        </div>

        <button type="submit" id="addCertificateButton" class="bg-green-500 text-white hover:bg-green-600 rounded w-full py-2 mt-4 hidden">Request</button>
    </form>
</div>

<div id="editDialog" style="display: none; width: 600px;">
    <form id="editCertificateForm">
        <input type="hidden" id="editIDs" name="id" />
        <label for="editNote" class="block mb-2 font-medium">Notes:</label>
        <textarea id="editNote" name="note" rows="4" class="w-full border-2 border-green-500 rounded-lg p-2 resize-none"></textarea>
        <button type="submit" class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 transition duration-200">Update</button>
    </form>
</div>

<script>
    const pages = document.querySelectorAll('.page');
    let currentPage = 0;

    function updateButtons() {
        document.getElementById('prevButton').disabled = currentPage === 0;
        document.getElementById('nextButton').style.display = currentPage === pages.length - 1 ? 'none' : 'inline-block';
        document.getElementById('addCertificateButton').style.display = currentPage === pages.length - 1 ? 'inline-block' : 'none';
    }

    function showPage(index) {
        pages.forEach((page, i) => {
            page.classList.toggle('hidden', i !== index);
        });
        updateButtons();
    }

    document.getElementById('prevButton').addEventListener('click', () => {
        if (currentPage > 0) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.getElementById('nextButton').addEventListener('click', () => {
        if (currentPage < pages.length - 1) {
            currentPage++;
            showPage(currentPage);
        }
    });

    // Initial setup
    showPage(currentPage);
</script>
