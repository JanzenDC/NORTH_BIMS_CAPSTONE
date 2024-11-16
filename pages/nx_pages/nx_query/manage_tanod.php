<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
session_start();
require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';
$user = $_SESSION['user']['username']; // Assuming user session is started

// Function to capitalize the first letter of each word in a string
function capitalizeFirstLetter($string) {
    return ucwords(strtolower($string)); // Capitalize first letter of each word
}

function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

switch ($action) {
 case 'create':
    // Create
    $fname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['fname']));
    $mname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['mname']));
    $lname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['lname']));
    $suffix = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['suffix']));
    $position = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['position']));
    $schedule = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['sched']));
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $bday = mysqli_real_escape_string($conn, $_POST['bday']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);
    // Handle file upload (validate image type and size)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
        // If no image is uploaded, set the default image
    $image = '../../../assets/images/pfp/default.jpg'; // Set default image name
    } else {
        $image = $_FILES['image']['name'];
        $imageTmp = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageExt = strtolower(pathinfo($image, PATHINFO_EXTENSION));

        // Allowed image types and size validation
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $maxSize = 5 * 1024 * 1024; // 5MB max size
        if (!in_array($imageExt, $allowedExtensions)) {
            $response['message'] = "Invalid image format. Only JPG, JPEG, and PNG are allowed.";
            logAction($conn, "Failed to upload image for official: Invalid format", $user);
            echo json_encode($response);
            exit;
        }
        if ($imageSize > $maxSize) {
            $response['message'] = "Image size exceeds the 5MB limit.";
            logAction($conn, "Failed to upload image for official: Exceeds size limit", $user);
            echo json_encode($response);
            exit;
        }

        // Move uploaded image to the desired directory
        if (!move_uploaded_file($imageTmp, "../../../assets/images/pfp/$image")) {
            $response['message'] = "Error uploading image.";
            logAction($conn, "Failed to upload image for official: $response[message]", $user);
            echo json_encode($response);
            exit;
        }
    }

    // Insert the data into the database
    $query = "INSERT INTO tbltanod (fname, mname, lname, suffix, position, contact, bday, image) 
              VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
        $response['message'] = "Official created successfully.";
        logAction($conn, "Created Barangay Police Data for $fname $lname", $user);
    } else {
        $response['message'] = "Error creating official: " . mysqli_error($conn);
        logAction($conn, "Failed to create official: " . mysqli_error($conn), $user);
    }
    break;

case 'get':
    // Read
    $id = (int)$_GET['id'];

    // Query to retrieve fname and lname for the specified ID
    $query = "SELECT fname, lname FROM tbltanod WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    // Fetch the official's data
    $official = mysqli_fetch_assoc($result);
    
    if ($official) {
        // Extract fname and lname
        $fname = $official['fname'];
        $lname = $official['lname'];

        // Retrieve all data for the specified official
        $query = "SELECT * FROM tbltanod WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $officialData = mysqli_fetch_assoc($result);
        
        if ($officialData) {
            $response['success'] = true;
            $response['data'] = $officialData;
            logAction($conn, "Retrieved Barangay Police Data for $fname $lname", $user);
        } else {
            $response['message'] = "Barangay Tanod data not found.";
            logAction($conn, "Failed to Retrieve Barangay Police Data for $fname $lname : Not found", $user);
        }
    } else {
        $response['message'] = "Barangay Tanod not found.";
        logAction($conn, "Failed to retrieve Barangay Tanod ID $id: Not found", $user);
    }
    break;

    case 'update':
        // Update
        $id = (int)$_POST['id'];
        $fname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['fname']));
        $mname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['mname']));
        $lname = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['lname']));
        $suffix = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['suffix']));
        $position = mysqli_real_escape_string($conn, capitalizeFirstLetter($_POST['position']));
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $bday = mysqli_real_escape_string($conn, $_POST['bday']);
        
        // Initialize $image variable
        $image = '';

        // Check if the image file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            if (!move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image")) {
                $response['message'] = "Error uploading image.";
                logAction($conn, "Failed to upload image for official ID $id: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        }

        // Build the update query
        if ($image) {
            $query = "UPDATE tbltanod SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday', image='$image' WHERE id=$id";
        } else {
            $query = "UPDATE tbltanod SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday' WHERE id=$id";
        }

        // Execute query and handle response
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Official updated successfully.";
            logAction($conn, "Updated Barangay Police Data for $fname $lname", $user);
        } else {
            $response['message'] = "Error updating official: " . mysqli_error($conn);
            logAction($conn, "Failed to update official ID $id: " . mysqli_error($conn), $user);
        }
        break;

case 'delete':
    // Delete
    $id = (int)$_GET['id'];

    // Query to retrieve fname and lname for the specified ID
    $query = "SELECT fname, lname FROM tbltanod WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the official's details
        $official = mysqli_fetch_assoc($result);
        $fname = $official['fname'];
        $lname = $official['lname'];

        // Proceed with deletion
        $query = "DELETE FROM tbltanod WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Barangay Tanod deleted successfully.";
            logAction($conn, "Deleted Barangay Police Data for $fname $lname", $user);
        } else {
            $response['message'] = "Error deleting Barangay Tanod: " . mysqli_error($conn);
            logAction($conn, "Failed to delete Barangay Tanod ID $id: " . mysqli_error($conn), $user);
        }
    } else {
        $response['message'] = "Barangay Tanod not found.";
        logAction($conn, "Failed to retrieve Barangay Tanod ID $id: Not found", $user);
    }
    break;

default:
    $response['message'] = "Invalid action.";
    logAction($conn, "Invalid action attempted: $action", $user);
}


// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>