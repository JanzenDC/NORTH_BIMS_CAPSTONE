<?php
// Start session
session_start();
require "../../../db_connect.php"; // Ensure this points to your actual DB connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    jsonResponse("error", "User not logged in.");
}

$user = $_SESSION['user']; // Assuming you store user details in session
$user_id = $user['id'];

// Function to send JSON responses
function jsonResponse($status, $message, $image = null) {
    $response = ["status" => $status, "message" => $message];
    if ($image) {
        $response["image"] = $image;
    }
    echo json_encode($response);
    exit; // Ensure no further output is sent
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['id_image']) && $_FILES['id_image']['error'] == 0) {
        $file = $_FILES['id_image'];

        // Validate the file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes)) {
            // Specify upload directory
            $uploadDir = '../../../../assets/images/id/'; // Ensure this directory is writable
            $fileName = time() . '_' . basename($file['name']);
            $targetFile = $uploadDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Update the database with just the image name
                $sql = "UPDATE tblregistered_account SET id_file = '$fileName' WHERE id = $user_id"; // Adjusted field name

                if ($conn->query($sql) === TRUE) {
                    // Update the session with the new image name
                    $_SESSION['user']['id_file'] = $fileName; // Adjusted session variable

                    jsonResponse("success", "ID image updated successfully!", $fileName);
                } else {
                    jsonResponse("error", "Database update failed: " . $conn->error);
                }
            } else {
                jsonResponse("error", "Failed to move uploaded file.");
            }
        } else {
            jsonResponse("error", "Invalid file type.");
        }
    } else {
        // If no image uploaded, use existing image
        $currentImage = $user['id_file']; // Get current ID image from session
        
        jsonResponse("success", "No new ID image uploaded. Using existing image.", $currentImage);
    }
}

$conn->close();
?>
