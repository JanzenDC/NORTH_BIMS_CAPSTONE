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
    case 'create':
        // Get data from POST request
        $sellerName      = mysqli_real_escape_string($conn, $_POST['sellerName'] ?? '');
        $sellerAddress   = mysqli_real_escape_string($conn, $_POST['sellerAddress'] ?? '');
        $buyerName       = mysqli_real_escape_string($conn, $_POST['buyerName'] ?? '');
        $buyerAddress    = mysqli_real_escape_string($conn, $_POST['buyerAddress'] ?? '');
        $landArea        = mysqli_real_escape_string($conn, $_POST['landArea'] ?? '');
        $propertySold    = mysqli_real_escape_string($conn, $_POST['propertySold'] ?? '');
        $amount          = (int)($_POST['amount'] ?? 0);
        $amount_words    = mysqli_real_escape_string($conn, $_POST['amount_words'] ?? '');
        $legalAgree      = mysqli_real_escape_string($conn, $_POST['legalAgree'] ?? '');
        $paymentConfirm   = mysqli_real_escape_string($conn, $_POST['paymentConfirm'] ?? '');
        $confirmationPay = mysqli_real_escape_string($conn, $_POST['confirmationPay'] ?? '');
        $date            = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
        $witness         = mysqli_real_escape_string($conn, $_POST['witness'] ?? '');
        $notarizeDate    = mysqli_real_escape_string($conn, $_POST['notarizeDate'] ?? '');
        $locationNota    = mysqli_real_escape_string($conn, $_POST['locationNota'] ?? '');
        $status          = mysqli_real_escape_string($conn, $_POST['status'] ?? 'Walk-in');
        $cert_amount     = mysqli_real_escape_string($conn, $_POST['cert_amount'] ?? '');
        $date_of_pickup  = mysqli_real_escape_string($conn, $_POST['date_of_pickup'] ?? '');
        $note            = mysqli_real_escape_string($conn, $_POST['note'] ?? '');

        // Validate required fields
        // if (empty($sellerName) || empty($buyerName) || empty($landArea)) {
        //     $response['message'] = "Required fields are missing.";
        //     echo json_encode($response);
        //     exit;
        // }

        // Construct the SQL query without sellerId
        $query = "
            INSERT INTO land_cert (
                sellerName, sellerAddress, buyerName, buyerAddress, landArea, 
                propertySold, amount, amount_words, legalAgree, 
                paymentConfirm, confirmationPay, date, witness, 
                notarizeDate, locationNota, status, cert_amount, 
                date_of_pickup, note
            ) VALUES (
                '$sellerName', 
                '$sellerAddress', 
                '$buyerName', 
                '$buyerAddress', 
                '$landArea', 
                '$propertySold', 
                $amount, 
                '$amount_words', 
                '$legalAgree', 
                '$paymentConfirm', 
                '$confirmationPay', 
                '$date', 
                '$witness', 
                '$notarizeDate', 
                '$locationNota', 
                '$status', 
                '$cert_amount', 
                '$date_of_pickup', 
                '$note'
            )";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Certificate created successfully.";
            $response['data'] = [
                'id' => mysqli_insert_id($conn), // Return the ID of the new record
            ];
        } else {
            $response['message'] = "Failed to create certificate: " . mysqli_error($conn);
        }
        break;


    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM land_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Land Certificate data not found.";
        }
        break;
    case 'updateAmount':
        $hiddenID = (int)$_POST['hiddenID'] ?? 0;
        $amountEdit = mysqli_real_escape_string($conn, $_POST['AmountEdit'] ?? '');

        if ($hiddenID <= 0 || empty($amountEdit)) {
            $response['message'] = "Invalid ID or amount.";
            echo json_encode($response);
            exit;
        }

        $query = "UPDATE land_cert SET amount = $amountEdit WHERE id = $hiddenID";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Amount updated successfully.";
        } else {
            $response['message'] = "Failed to update amount: " . mysqli_error($conn);
        }
        break;
    case 'setAsApprove':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }

        // Construct the SQL query to update the status to "Done"
        $query = "UPDATE land_cert SET status = 'Approved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;
    case 'setDisapproved':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }

        // Construct the SQL query to update the status to "Done"
        $query = "UPDATE land_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
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
            $sql = "UPDATE land_cert SET status = 'Done' WHERE id = '$id'";

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
