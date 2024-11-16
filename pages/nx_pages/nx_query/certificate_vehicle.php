<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
session_start();
require 'vendor/autoload.php';
require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

// Function to log actions
function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

$action = $_GET['action'] ?? '';
$user = $_SESSION['user']['username']; // Replace with actual user identification logic

switch ($action) {
    case 'updateAmount':
        $hiddenID = (int)$_POST['hiddenID'] ?? 0;
        $amountEdit = $_POST['AmountEdit'] ?? '';

        if ($hiddenID <= 0 || empty($amountEdit)) {
            $response['message'] = "Invalid ID or amount.";
            echo json_encode($response);
            exit;
        }

        $stmt = $conn->prepare("UPDATE vehicle_cert SET amount = ? WHERE id = ?");
        $stmt->bind_param("si", $amountEdit, $hiddenID);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Amount updated successfully.";
            logAction($conn, "Updated amount for ID: $hiddenID", $user);
        } else {
            $response['message'] = "Failed to update amount: " . $stmt->error;
        }
        break;

    case 'setAsApprove':
        $id = (int)$_POST['id'] ?? 0;

        if ($id <= 0) {
            $response['message'] = "ID is required to set the record as approved.";
            break;
        }

        $sellerQuery = "SELECT sellerid FROM vehicle_cert WHERE id = $id";
        $sellerResult = mysqli_query($conn, $sellerQuery);

        if ($sellerResult && mysqli_num_rows($sellerResult) > 0) {
            $sellerData = mysqli_fetch_assoc($sellerResult);
            $sellerid = $sellerData['sellerid'];

            if ($sellerid != 0) {
                $contactQuery = "SELECT resident_id, contact FROM tblregistered_account WHERE id = $sellerid";
                $contactResult = mysqli_query($conn, $contactQuery);

                if ($contactResult && mysqli_num_rows($contactResult) > 0) {
                    $contactData = mysqli_fetch_assoc($contactResult);
                    $contactNumber = $contactData['contact'];

                    $updateQuery = "UPDATE vehicle_cert SET status = 'Approved' WHERE id = $id";
                    if (mysqli_query($conn, $updateQuery)) {
                        $response['success'] = true;
                        $response['message'] = "Record marked as Approved successfully.";
                        logAction($conn, "Approved record with ID: $id", $_SESSION['user']['username']);

                        $telerivetApiKey = 'H_RkO_uw1HficmdKffr9OWNG1s2Isd8sP5S2';
                        $projectId = 'PJ3d74c709991602b6';
                        $message = "Your certificate has been approved.";

                        try {
                            $api = new Telerivet_API($telerivetApiKey);
                            $project = $api->initProjectById($projectId);
                            $project->sendMessage([
                                'to_number' => $userPhone,
                                'content' => $contactNumber
                            ]);
                            $response['message'] = "SMS sent successfully.";
                        } catch (Exception $e) {
                            $response['message'] = "Error sending SMS: " . $e->getMessage();
                        }
                    } else {
                        $response['message'] = "Error updating record: " . mysqli_error($conn);
                    }
                } else {
                    $response['message'] = "No contact found for seller ID $sellerid.";
                }
            } else {
                $response['message'] = "Seller ID is zero, not sending Telerivet message.";
            }
        } else {
            $response['message'] = "No seller found for certificate ID $id.";
        }
        break;


    case 'setDisapproved':
        $id = (int)$_POST['id'] ?? 0;

        if ($id <= 0) {
            $response['message'] = "ID is required to set the record as disapproved.";
            break;
        }

        $stmt = $conn->prepare("UPDATE vehicle_cert SET status = 'Disapproved' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
            logAction($conn, "Disapproved record with ID: $id", $user);
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        break;

    case 'get':
        $id = (int)$_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM vehicle_cert WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $official = $result->fetch_assoc();
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Vehicle Certificate data not found.";
        }
        break;

    case 'create':
        $sellerName = $_POST['sellerName'] ?? '';
        $sellerAddress = $_POST['sellerAddress'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $amount_words = $_POST['amount_words'] ?? '';
        $buyerName = $_POST['buyerName'] ?? '';
        $buyerAddress = $_POST['buyerAddress'] ?? '';
        $make = $_POST['make'] ?? '';
        $plateNum = $_POST['plateNum'] ?? '';
        $engineNum = $_POST['engineNum'] ?? '';
        $chasisNum = $_POST['chasisNum'] ?? '';
        $denomination = $_POST['denomination'] ?? '';
        $fuel = $_POST['fuel'] ?? '';
        $bodyType = $_POST['bodyType'] ?? '';
        $crNo = $_POST['crNo'] ?? '';
        $date = $_POST['date'] ?? '';
        $witness = $_POST['witness'] ?? '';
        $locationTran = $_POST['locationTran'] ?? '';
        $cert_amount = $_POST['cert_amount'] ?? '';
        $note = $_POST['note'] ?? '';
        $date_of_pickup = $_POST['date_of_pickup'] ?? '';

        // Set default status to 'Walk-in'
        $status = 'Walk-in';

        $stmt = $conn->prepare("INSERT INTO vehicle_cert (
                    sellerName, sellerAddress, amount, amount_words, 
                    buyerName, buyerAddress, make, plateNum, 
                    engineNum, chasisNum, denomination, fuel, 
                    bodyType, crNo, date, witness, 
                    locationTran, cert_amount, status, note, date_of_pickup
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssssssssssssss", 
            $sellerName, $sellerAddress, $amount, $amount_words, 
            $buyerName, $buyerAddress, $make, $plateNum, 
            $engineNum, $chasisNum, $denomination, $fuel, 
            $bodyType, $crNo, $date, $witness, 
            $locationTran, $cert_amount, $status, $note, $date_of_pickup);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Certificate created successfully.";
            $response['data'] = [
                'id' => $stmt->insert_id, // Return the ID of the new record
            ];
            logAction($conn, "Created certificate with ID: " . $stmt->insert_id, $user);
        } else {
            $response['message'] = "Failed to create certificate: " . $stmt->error;
        }
        break;

    case 'mark_done':
        $id = (int)$_POST['id'] ?? 0;

        if ($id <= 0) {
            $response['message'] = "Certificate ID is required.";
        } else {
            $stmt = $conn->prepare("UPDATE vehicle_cert SET status = 'Done' WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate marked as done successfully!";
                    logAction($conn, "Marked certificate as done with ID: $id", $user);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . $stmt->error;
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
