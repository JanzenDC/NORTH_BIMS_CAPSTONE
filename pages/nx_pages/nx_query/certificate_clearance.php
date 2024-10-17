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
