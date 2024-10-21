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
    case 'updateAmount':
        $hiddenID = (int)$_POST['hiddenID'] ?? 0;
        $amountEdit = mysqli_real_escape_string($conn, $_POST['AmountEdit'] ?? '');

        if ($hiddenID <= 0 || empty($amountEdit)) {
            $response['message'] = "Invalid ID or amount.";
            echo json_encode($response);
            exit;
        }

        $query = "UPDATE vehicle_cert SET amount = $amountEdit WHERE id = $hiddenID";

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
        $query = "UPDATE vehicle_cert SET status = 'Approved' WHERE id = $id";

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
        $query = "UPDATE vehicle_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;
    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM vehicle_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Land Certificate data not found.";
        }
        break;
    case 'create':
        // Get data from POST request
        $sellerName = mysqli_real_escape_string($conn, $_POST['sellerName'] ?? '');
        $sellerAddress = mysqli_real_escape_string($conn, $_POST['sellerAddress'] ?? '');
        $amount = mysqli_real_escape_string($conn, $_POST['amount'] ?? '');
        $amount_words = mysqli_real_escape_string($conn, $_POST['amount_words'] ?? '');
        $buyerName = mysqli_real_escape_string($conn, $_POST['buyerName'] ?? '');
        $buyerAddress = mysqli_real_escape_string($conn, $_POST['buyerAddress'] ?? '');
        $make = mysqli_real_escape_string($conn, $_POST['make'] ?? '');
        $plateNum = mysqli_real_escape_string($conn, $_POST['plateNum'] ?? '');
        $engineNum = mysqli_real_escape_string($conn, $_POST['engineNum'] ?? '');
        $chasisNum = mysqli_real_escape_string($conn, $_POST['chasisNum'] ?? '');
        $denomination = mysqli_real_escape_string($conn, $_POST['denomination'] ?? '');
        $fuel = mysqli_real_escape_string($conn, $_POST['fuel'] ?? '');
        $bodyType = mysqli_real_escape_string($conn, $_POST['bodyType'] ?? '');
        $crNo = mysqli_real_escape_string($conn, $_POST['crNo'] ?? '');
        $date = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
        $witness = mysqli_real_escape_string($conn, $_POST['witness'] ?? '');
        $locationTran = mysqli_real_escape_string($conn, $_POST['locationTran'] ?? '');
        $cert_amount = mysqli_real_escape_string($conn, $_POST['cert_amount'] ?? '');
        $note = mysqli_real_escape_string($conn, $_POST['note'] ?? '');
        $date_of_pickup = mysqli_real_escape_string($conn, $_POST['date_of_pickup'] ?? '');

        // Validate required fields
        // if (empty($sellerName) || empty($buyerName) || empty($amount)) {
        //     $response['message'] = "Required fields are missing.";
        //     echo json_encode($response);
        //     exit;
        // }

        // Set default status to 'Walk-in'
        $status = 'Walk-in';

        // Construct the SQL query
        $query = "INSERT INTO vehicle_cert (
                    sellerName, sellerAddress, amount, amount_words, 
                    buyerName, buyerAddress, make, plateNum, 
                    engineNum, chasisNum, denomination, fuel, 
                    bodyType, crNo, date, witness, 
                    locationTran, cert_amount, status, note, date_of_pickup
                  ) VALUES (
                    '$sellerName', 
                    '$sellerAddress', 
                    '$amount', 
                    '$amount_words', 
                    '$buyerName', 
                    '$buyerAddress', 
                    '$make', 
                    '$plateNum', 
                    '$engineNum', 
                    '$chasisNum', 
                    '$denomination', 
                    '$fuel', 
                    '$bodyType', 
                    '$crNo', 
                    '$date', 
                    '$witness', 
                    '$locationTran', 
                    '$cert_amount',
                    '$status', 
                    '$note', 
                    '$date_of_pickup'
                  )";

        // Execute the query and handle the response
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

    case 'mark_done':
        // Mark certificate as done
        $id = $_POST['id'] ?? '';

        // Validate the ID
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            // Update the status of the certificate to 'Done'
            $sql = "UPDATE vehicle_cert SET status = 'Done' WHERE id = '$id'";

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
