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
    case 'update':
        // Update
        $id = (int)$_GET['id'];
        $data = json_decode(file_get_contents("php://input"), true); // Get the JSON payload

        // Check if the isApproved field is present
        if (isset($data['isApproved'])) {
            $isApproved = (int)$data['isApproved'];

            $query = "UPDATE tblregistered_account SET isApproved = $isApproved WHERE id = $id";
            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = "Resident updated successfully.";
            } else {
                $response['message'] = "Error updating Resident: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "Required fields are missing.";
        }
    break;
    case 'delete':
        // Delete
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tblregistered_account WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident deleted successfully.";
        } else {
            $response['message'] = "Error deleting Resident: " . mysqli_error($conn);
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
