<?php
// Start session
session_start();
require "../../../db_connect"; // Ensure this points to your actual DB connection file

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    die("User not logged in.");
}

$user = $_SESSION['user']; // Assuming you store user details in session
$user_id = $user['id'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file = $_FILES['image'];

        // Validate the file
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($file['type'], $allowedTypes)) {
            // Specify upload directory
            $uploadDir = '../../../../assets/images/pfp/'; // Ensure this directory is writable
            $fileName = time() . '_' . basename($file['name']);
            $targetFile = $uploadDir . $fileName;

            // Move the uploaded file
            if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                // Update the database with just the image name
                $imageName = $fileName; // Store only the name in the database
                $sql = "UPDATE tblregistered_account SET image = '$imageName' WHERE id = $user_id";
                
                if ($conn->query($sql) === TRUE) {
                    // Update the session with the new image name
                    $_SESSION['user']['image'] = $imageName;

                    echo json_encode([
                        "status" => "success",
                        "message" => "Profile picture updated successfully!",
                        "image" => $imageName
                    ]);
                } else {
                    echo json_encode(["status" => "error", "message" => "Database update failed: " . $conn->error]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to move uploaded file."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Invalid file type."]);
        }
    } else {
        // If no image uploaded, use existing image
        $currentImage = $user['image']; // Get current image from session
        
        echo json_encode([
            "status" => "success",
            "message" => "No new image uploaded. Using existing image.",
            "image" => $currentImage
        ]);
    }
}

$conn->close();
?>
