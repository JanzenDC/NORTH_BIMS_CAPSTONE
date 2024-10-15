<?php
require "../../db_connect.php";
header('Content-Type: application/json; charset=utf-8');

// Determine the action based on POST data
$action = $_POST['action'] ?? '';

if ($action === 'add') {
    // Adding an official
    $fname = $_POST['first_name'];
    $mname = $_POST['middle_name'];
    $lname = $_POST['last_name'];
    $position = $_POST['position'];
    $contact = $_POST['contact'];
    $bday = $_POST['bday'];
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageName = uniqid() . '-' . basename($image['name']);
        $targetPath = "../../assets/images/pfp/" . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $sql = "INSERT INTO tblofficial (fname, mname, lname, position, contact, bday, image) VALUES ('$fname', '$mname', '$lname', '$position', '$contact', '$bday', '$imageName')";
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to upload image."]);
            exit;
        }
    } else {
        // No image uploaded, set default image
        $imageName = 'default.png';
        $sql = "INSERT INTO tblofficial (fname, mname, lname, position, contact, bday, image) VALUES ('$fname', '$mname', '$lname', '$position', '$contact', '$bday', '$imageName')";
    }
    
    // Execute the insert query
    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Official added successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to add official."]);
    }

} elseif ($action === 'update') {
    // Updating an official
    $id = $_POST['id'];
    $fname = $_POST['first_name'];
    $mname = $_POST['middle_name'];
    $lname = $_POST['last_name'];
    $position = $_POST['position'];
    $contact = $_POST['contact'];
    $bday = $_POST['bday'];
    
    // Check if a new image is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageName = uniqid() . '-' . basename($image['name']);
        $targetPath = "../../assets/images/pfp/" . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $targetPath)) {
            $sql = "UPDATE tblofficial SET fname='$fname', mname='$mname', lname='$lname', position='$position', contact='$contact', bday='$bday', image='$imageName' WHERE id='$id'";
            
            if (mysqli_query($conn, $sql)) {
                echo json_encode(["status" => "success", "message" => "Official updated successfully!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update official."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to upload image."]);
        }
    } else {
        // No new image uploaded, update other fields
        $sql = "UPDATE tblofficial SET fname='$fname', mname='$mname', lname='$lname', position='$position', contact='$contact', bday='$bday' WHERE id='$id'";
        
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Official updated successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update official."]);
        }
    }

} elseif ($action === 'delete') {
    // Deleting an official
    $id = $_POST['id'];

    $sql = "DELETE FROM tblofficial WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(["status" => "success", "message" => "Official deleted successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to delete official."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid action."]);
}

mysqli_close($conn);
?>
