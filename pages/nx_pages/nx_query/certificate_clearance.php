<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require 'vendor/autoload.php';

require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

session_start(); // Start the session to access session variables

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';

function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

switch ($action) {
    case 'updateNotes':
        // Get data from the POST request
        $id = $_POST['id'] ?? '';
        $notes = $_POST['notes'] ?? ''; // New field for notes

        // Validate input
        if (empty($id) || empty($notes)) {
            $response['message'] = "ID and notes are required.";
            break;
        }

        // Construct the SQL query to update the notes
        $query = "UPDATE clearance_cert SET note = '$notes' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Notes updated successfully.";
            logAction($conn, "Updated notes for clearance_cert ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'create':
        // Get data from the POST request
        $fname = $_POST['fname'] ?? '';
        $mname = $_POST['mname'] ?? '';
        $lname = $_POST['lname'] ?? '';
        $status = $_POST['status'] ?? '';
        $certificateAmount = $_POST['certificateAmount'] ?? 0;
        $bcNo = $_POST['bcNo'] ?? '';
        $dateIssued = $_POST['dateIssued'] ?? '';
        $purposes = $_POST['purposes'] ?? ''; // New field

        // Simple input validation
        if (empty($fname) || empty($lname) || empty($status) || empty($bcNo) || empty($dateIssued) || empty($purposes)) {
            $response['message'] = "First name, last name, status, BC No, date issued, and purposes are required.";
            break;
        }

        // Construct the SQL query
        $query = "INSERT INTO clearance_cert (fname, mname, lname, status, amount, bcNo, date_issued, purpose) 
                  VALUES ('$fname', '$mname', '$lname', '$status', $certificateAmount, '$bcNo', '$dateIssued', '$purposes')";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Certificate added successfully.";
            $response['data'] = [
                'id' => mysqli_insert_id($conn), // Get the last inserted ID
                'fname' => $fname,
                'mname' => $mname,
                'lname' => $lname,
                'status' => $status,
                'amount' => $certificateAmount,
                'bcNo' => $bcNo,
                'dateIssued' => $dateIssued,
                'purpose' => $purposes // Include purposes in the response
            ];
            logAction($conn, "Created clearance certificate for $fname $lname", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'delete':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to delete a record.";
            break;
        }

        // Construct the SQL query to delete the record
        $query = "DELETE FROM clearance_cert WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record deleted successfully.";
            logAction($conn, "Deleted clearance certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM clearance_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Health Worker not found.";
        }
        break;

    case 'updateApprove':
        // Get data from the POST request
        $id = $_POST['id'] ?? '';
        $amount = $_POST['amount'] ?? 0;
        $bcNo = $_POST['bcNo'] ?? '';
        $dateIssued = $_POST['date_issued'] ?? '';
        $purposes = $_POST['purposes'] ?? ''; // New field for purposes

        // Construct the SQL query to update the specified fields
        $query = "UPDATE clearance_cert SET amount = $amount, bcNo = '$bcNo', date_issued = '$dateIssued', purpose = '$purposes' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record updated successfully.";
            logAction($conn, "Updated clearance certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'setAsDone':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }

        // Construct the SQL query to update the status to "Done"
        $query = "UPDATE clearance_cert SET status = 'Done' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as done successfully.";
            logAction($conn, "Marked clearance certificate ID $id as done", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'setAsApprove':
        $id = $_POST['id'] ?? '';

        if (empty($id)) {
            $response['message'] = "ID is required to set the record as approved.";
            break;
        }

        $ownerQuery = "SELECT ownerId FROM clearance_cert WHERE id = $id";
        $ownerResult = mysqli_query($conn, $ownerQuery);

        if ($ownerResult && mysqli_num_rows($ownerResult) > 0) {
            $ownerData = mysqli_fetch_assoc($ownerResult);
            $ownerId = $ownerData['ownerId'];


                $contactQuery = "SELECT * FROM tblregistered_account WHERE id = $ownerId";
                $contactResult = mysqli_query($conn, $contactQuery);

                if ($contactResult && mysqli_num_rows($contactResult) > 0) {
                    $contactData = mysqli_fetch_assoc($contactResult);
                    $contactNumber = $contactData['contact'];

                    $query = "UPDATE clearance_cert SET status = 'Approved' WHERE id = $id";

                    if (mysqli_query($conn, $query)) {
                        $response['success'] = true;
                        $response['message'] = "Record marked as Approved successfully.";
                        logAction($conn, "Approved clearance certificate ID $id", $_SESSION['user']['username']);

                        $telerivetApiKey = 'H_RkO_06nvYxPfDda3r949iavvgJtEc0ZnBW';
                        $projectId = 'PJ3d74c709991602b6';
                        $message = "Your certificate has been approved.";

                        $api = new Telerivet_API($telerivetApiKey);
                        $project = $api->initProjectById($projectId);
                        $response = $project->sendMessage([
                            'to_number' => $contactNumber,
                            'content' => $message
                        ]);


                    } else {
                        $response['message'] = "Error updating record: " . mysqli_error($conn);
                    }
                } else {
                    $response['message'] = "No contact found for owner ID $ownerId.";
                }
        } else {
            $response['message'] = "No owner found for certificate ID $id.";
        }
        break;

    case 'setDisapproved':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as disapproved.";
            break;
        }

        // Construct the SQL query to update the status to "Disapproved"
        $query = "UPDATE clearance_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
            logAction($conn, "Disapproved clearance certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
