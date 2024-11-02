<?php
// activity_query.php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php";
session_start();
$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

// Function to log actions
function logAction($conn, $user, $action) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES ('$user', '$logdate', '$action')";
    $conn->query($sql);
}

// Get user info (replace with your user authentication logic)
$user = $_SESSION['user']['username']; // Replace this with the actual user

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        // Capture POST data
        $complainant = $conn->real_escape_string($_POST['complainant']);
        $cAddress = $conn->real_escape_string($_POST['cAddress']);
        $personToComplaint = $conn->real_escape_string($_POST['personToComplaint']);
        $pAddress = $conn->real_escape_string($_POST['pAddress']);
        $complaint = $conn->real_escape_string($_POST['complaint']);
        $actionValue = $conn->real_escape_string($_POST['action']);
        $status = $conn->real_escape_string($_POST['status']);
        
        // Getting current year and date
        $yearRecorded = date('Y');
        $currentDate = date('Y-m-d');

        // Prepare SQL statement
        $sql = "INSERT INTO tblblotter (yearRecorded, date, complainant, caddress, personToComplaint, paddress, complaint, action, status, reference) 
                VALUES ('$yearRecorded', '$currentDate', '$complainant', '$cAddress', '$personToComplaint', '$pAddress', '$complaint', '$actionValue', '$status', '')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            // Log the action
            logAction($conn, $user, "Added a new blotter: $complainant");
            $response['success'] = true;
            $response['message'] = 'Blotter added successfully!';
            $response['data'] = [
                'id' => $conn->insert_id,
                'complainant' => $complainant,
                'status' => $status,
            ];
        } else {
            $response['message'] = 'Error: ' . $conn->error;
        }
        break;
    case 'dismissed':
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']); // Get the ID from POST data

            // Update the status in the database
            $sql = "UPDATE tblblotter SET status = 'Dismissed' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Case dismissed successfully.';
            } else {
                $response['message'] = 'Error dismissing case: ' . $conn->error;
            }
        } else {
            $response['message'] = 'No ID provided.';
        }
        break;
    case 'reffered':
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']); // Get the ID from POST data

            // Update the status in the database
            $sql = "UPDATE tblblotter SET status = 'Referred' WHERE id = $id";
            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Case Referred successfully.';
            } else {
                $response['message'] = 'Error dismissing case: ' . $conn->error;
            }
        } else {
            $response['message'] = 'No ID provided.';
        }
        break;
    case 'edit':
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $complainant = $conn->real_escape_string($_POST['complainant']);
            $cAddress = $conn->real_escape_string($_POST['cAddress']);
            $personToComplaint = $conn->real_escape_string($_POST['personToComplaint']);
            $pAddress = $conn->real_escape_string($_POST['pAddress']);
            $complaint = $conn->real_escape_string($_POST['complaint']);
            $action = $conn->real_escape_string($_POST['action']);
            $status = $conn->real_escape_string($_POST['status']);

            // Initialize image file handling
            $imageFileName = null;
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                $originalFileName = basename($_FILES['image']['name']);
                $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
                $uniqueFileName = uniqid('blotter_', true) . '.' . $fileExtension; // Generate a unique filename
                $targetDirectory = '../../../assets/images/blotter/'; // Define your upload directory
                $targetFilePath = $targetDirectory . $uniqueFileName;

                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $imageFileName = $uniqueFileName; // Set the unique filename
                } else {
                    $response['message'] = 'Error uploading image.';
                    break;
                }
            }

            // Update the blotter entry
            $sql = "UPDATE tblblotter SET 
                    complainant='$complainant', 
                    caddress='$cAddress', 
                    personToComplaint='$personToComplaint', 
                    paddress='$pAddress', 
                    complaint='$complaint', 
                    action='$action', 
                    status='$status'";
            
            if ($imageFileName) {
                // If there's a new image, include it in the update
                $sql .= ", reference='$imageFileName'"; // Assuming there's an 'image' column in the table
            }

            $sql .= " WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                // Clear existing supporting details for the blotter ID
                $conn->query("DELETE FROM tblblotter_pagpapatunay WHERE id=$id");

                // Insert new supporting details
                if (isset($_POST['supportingDetails'])) {
                    foreach ($_POST['supportingDetails'] as $detail) {
                        $description = $conn->real_escape_string($detail);
                        $insertSql = "INSERT INTO tblblotter_pagpapatunay (blotterId, id, descriptionn) VALUES (NULL, $id, '$description')";
                        $conn->query($insertSql);
                    }
                }

                $response['success'] = true;
                $response['message'] = 'Blotter updated successfully.';
            } else {
                $response['message'] = 'Error updating blotter: ' . $conn->error;
            }
        } else {
            $response['message'] = 'No ID provided.';
        }
        break;
    case 'get':
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            
            // Fetch the main blotter details
            $sql = "SELECT * FROM tblblotter WHERE id = $id";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                $response['success'] = true;
                $response['data'] = $result->fetch_assoc();

                // Fetch the supporting details
                $supportingSql = "SELECT descriptionn FROM tblblotter_pagpapatunay WHERE id = $id";
                $supportingResult = $conn->query($supportingSql);
                $supportingDetails = [];

                while ($detail = $supportingResult->fetch_assoc()) {
                    $supportingDetails[] = $detail['descriptionn'];
                }

                // Add the supporting details to the response
                $response['data']['supportingDetails'] = $supportingDetails;

            } else {
                $response['message'] = 'No record found.';
            }
        } else {
            $response['message'] = 'No ID provided.';
        }
        break;

    case 'updateStatus':
        if (isset($_POST['id']) && isset($_POST['status'])) {
            $id = intval($_POST['id']);
            $status = $conn->real_escape_string($_POST['status']);

            // Update the status in the database
            $sql = "UPDATE tblblotter SET status='$status' WHERE id=$id";

            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Status updated successfully.';
            } else {
                $response['message'] = 'Error updating status: ' . $conn->error;
            }
        } else {
            $response['message'] = 'No ID or status provided.';
        }
        break;

    default:
        $response['message'] = "Invalid action";
}

echo json_encode($response);
$conn->close();
?>
