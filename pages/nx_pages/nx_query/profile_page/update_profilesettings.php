<?php
// Turn off error reporting to prevent HTML output
error_reporting(0);
ini_set('display_errors', 0);

// Function to safely encode JSON
function safeJsonEncode($data) {
    return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
}

// Function to output JSON response and exit
function jsonResponse($status, $message, $data = null) {
    $response = ['status' => $status, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo safeJsonEncode($response);
    exit;
}

// Start output buffering to catch any unexpected output
ob_start();

session_start();

// Set security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Content-Security-Policy: default-src 'self'");

// Set caching headers to prevent caching of this response
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Set content type to JSON
header('Content-Type: application/json; charset=utf-8');

require "../../../db_connect.php";

if (!isset($_SESSION['user'])) {
    jsonResponse("error", "User not logged in");
}

$userId = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputData = [];
    $fields = ['fname', 'mname', 'lname', 'suffix', 'bday', 'age', 'gender', 'contact', 'houseNo', 'street', 'brgy', 'municipality', 'province', 'email', 'username', 'id_type'];

    foreach ($fields as $field) {
        $inputData[$field] = isset($_POST[$field]) ? $conn->real_escape_string($_POST[$field]) : null;
    }

    // Handle file upload
    if (isset($_FILES['id_file']) && $_FILES['id_file']['error'] == 0) {
        $uploadDir = '../../../../assets/images/id/';
        $fileName = uniqid() . '_' . basename($_FILES['id_file']['name']);
        $targetFile = $uploadDir . $fileName;
        
        if (move_uploaded_file($_FILES['id_file']['tmp_name'], $targetFile)) {
            $inputData['id_file'] = $fileName;
        } else {
            jsonResponse("error", "Failed to upload file");
        }
    }

    $updateFields = [];
    foreach ($inputData as $key => $value) {
        if ($value !== null) {
            $updateFields[] = "$key='$value'";
        }
    }

    if (!empty($_POST['password'])) {
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $updateFields[] = "password='$hashedPassword'";
    }

    if (empty($updateFields)) {
        jsonResponse("error", "No fields to update");
    }

    $sql = "UPDATE tblregistered_account SET " . implode(", ", $updateFields) . " WHERE id='$userId'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user'] = array_merge($_SESSION['user'], array_filter($inputData, function($value) {
            return $value !== null;
        }));
        jsonResponse("success", "Successfully updated user profile.");
    } else {
        jsonResponse("error", "Database error: " . $conn->error);
    }
} else {
    jsonResponse("error", "Invalid request method");
}

$conn->close();

// Catch any unexpected output
$unexpectedOutput = ob_get_clean();
if (!empty($unexpectedOutput)) {
    error_log("Unexpected output in update_profilesettings.php: " . $unexpectedOutput);
    jsonResponse("error", "An unexpected error occurred. Please try again later.");
}
?>