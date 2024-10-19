<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'delete':
        // Delete a record
        $id = $_POST['id'] ?? '';
        
        // Validate the ID
        if (empty($id)) {
            $response['message'] = "ID is required to delete the record.";
        } else {
            // Construct the SQL DELETE query
            $query = "DELETE FROM livestock_cert WHERE id = '$id'";

            if (mysqli_query($conn, $query)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Record deleted successfully.";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error deleting record: " . mysqli_error($conn);
            }
        }
        break;
    case 'updateNote':
        // Update the note for the certificate
        $id = $_POST['id'] ?? '';
        $note = $_POST['note'] ?? '';

        // Validate required fields
        if (empty($id) || empty($note)) {
            $response['message'] = "Certificate ID and Note are required.";
        } else {
            // Escape user input for safety
            $note = mysqli_real_escape_string($conn, $note);

            // Construct SQL query to update the note in livestock_cert
            $sql = "UPDATE livestock_cert SET note='$note' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Note updated successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating note: " . mysqli_error($conn);
            }
        }
        break;
    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM livestock_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Livestock not found.";
        }
        break;
    case 'create':
        
        // Get data from the POST request
        $sellerName = $_POST['sellerName'] ?? '';
        $sellerAddress = $_POST['sellerAddress'] ?? '';
        $buyerName = $_POST['buyerName'] ?? '';
        $buyerAddress = $_POST['buyerAddress'] ?? '';
        $itemSold = $_POST['itemSold'] ?? '';
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0; // Ensure it's an integer
        $age = $_POST['ageOfAnimal'] ?? '';
        $sex = $_POST['sexOfAnimal'] ?? '';
        $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0.0; // Ensure it's a float
        $amountInWords = $_POST['amountInWords'] ?? '';
        $transactionDate = $_POST['transactionDate'] ?? '';
        $cowlicks = $_POST['cowlicks'] ?? '';
        $brandOfMunicipality = $_POST['brandOfMunicipality'] ?? '';
        $brandOfOwner = $_POST['brandOfOwner'] ?? '';
        $certificateAmount = isset($_POST['certificateAmount']) ? (float)$_POST['certificateAmount'] : 0.0; // Ensure it's a float
        $dateOfPickup = $_POST['dateOfPickup'] ?? '';
        $note = $_POST['note'] ?? ''; // Optional note field
        
        // Default status to "Walk-In" if not provided
        $status = "Walk-In";

        // Validate required fields

        // Construct the SQL query to insert the new record
        $query = "INSERT INTO livestock_cert 
            (sellerName, sellerAddress, buyerName, buyerAddress, itemSold, 
            quantity, age, sex, amount, amount_words, transacDate, cowlicks, 
            brandMun, brandOwn, cert_amount, date_of_pickup, status, note)
            VALUES 
            ('$sellerName', '$sellerAddress', '$buyerName', '$buyerAddress', 
            '$itemSold', $quantity, '$age', '$sex', $amount, '$amountInWords', 
            '$transactionDate', '$cowlicks', '$brandOfMunicipality', '$brandOfOwner', 
            $certificateAmount, '$dateOfPickup', '$status', '$note')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record created successfully.";
            $response['data'] = [
                'id' => mysqli_insert_id($conn), // Return the ID of the newly created record
                'sellerName' => $sellerName,
                'buyerName' => $buyerName
            ];
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'setAsApprove':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }
        $query = "UPDATE livestock_cert SET status = 'Approved' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'setDisapproved':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }
        $query = "UPDATE livestock_cert SET status = 'Disapproved' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;
    case 'mark_done':
        // Mark certificate as done
        $id = $_POST['id'] ?? '';

        // Validate the ID
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            // Update the status of the certificate to 'Done'
            $sql = "UPDATE livestock_cert SET status = 'Done' WHERE id = '$id'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate marked as done successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . mysqli_error($conn);
            }
        }
        break;
    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
