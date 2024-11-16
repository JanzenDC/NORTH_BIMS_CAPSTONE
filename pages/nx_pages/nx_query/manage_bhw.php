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

// Function to log actions
function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

$action = $_GET['action'] ?? '';
$user = $_SESSION['user']['username']; 

switch ($action) {
    case 'create':
// Create
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$mname = mysqli_real_escape_string($conn, $_POST['mname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$suffix = mysqli_real_escape_string($conn, $_POST['suffix']);
$position = mysqli_real_escape_string($conn, $_POST['position']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$bday = mysqli_real_escape_string($conn, $_POST['bday']);

// Check if an image is uploaded
if ($_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    // No image uploaded, use a default image
    $image = '../../../assets/images/pfp/default.jpg'; // Set default image name
} else {
    // Image uploaded, move it to the desired directory
    $image = $_FILES['image']['name'];
    if (!move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image")) {
        $response['message'] = "Error uploading image.";
        logAction($conn, "Failed to upload image for Health Worker: $response[message]", $user);
        exit; // Stop the execution if image upload fails
    }
}

// Insert data into the database
$query = "INSERT INTO tblhealthworker (fname, mname, lname, suffix, position, contact, bday, image) 
          VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
if (mysqli_query($conn, $query)) {
    $response['success'] = true;
    $response['message'] = "Health Worker created successfully.";
    logAction($conn, "Created Barangay Health Worker Data for $fname $lname", $user);
} else {
    $response['message'] = "Error creating Health Worker: " . mysqli_error($conn);
    logAction($conn, "Failed to create Health Worker: " . mysqli_error($conn), $user);
}
break;

    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM tblhealthworker WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
            logAction($conn, "Retrieved Barangay Health Worker Data for $fname $lname", $user);
        } else {
            $response['message'] = "Health Worker not found.";
        }
        break;

    case 'update':
        // Update
        $id = (int)$_POST['id'];
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $mname = mysqli_real_escape_string($conn, $_POST['mname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $suffix = mysqli_real_escape_string($conn, $_POST['suffix']);
        $position = mysqli_real_escape_string($conn, $_POST['position']);
        $contact = mysqli_real_escape_string($conn, $_POST['contact']);
        $bday = mysqli_real_escape_string($conn, $_POST['bday']);
        
        // Initialize $image variable
        $image = '';

        // Check if the image file is uploaded
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image");
        }

        // Build the update query
        if ($image) {
            $query = "UPDATE tblhealthworker SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday', image='$image' WHERE id=$id";
        } else {
            $query = "UPDATE tblhealthworker SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday' WHERE id=$id";
        }

        // Execute query and handle response
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Health Worker updated successfully.";
            logAction($conn, "Updated Barangay Health Worker Data for $fname $lname", $user);
        } else {
            $response['message'] = "Error updating Health Worker: " . mysqli_error($conn);
            error_log("SQL Error: " . mysqli_error($conn)); // Log SQL error for debugging
        }
        break;

        case 'delete':
            // Delete
            $id = (int)$_GET['id'];

            // Query to retrieve fname and lname for the specified ID
            $query = "SELECT fname, lname FROM tblhealthworker WHERE id = $id";
            $result = mysqli_query($conn, $query);
            
            if ($result && mysqli_num_rows($result) > 0) {
                // Fetch the health worker's details
                $worker = mysqli_fetch_assoc($result);
                $fname = $worker['fname'];
                $lname = $worker['lname'];

                // Proceed with deletion
                $query = "DELETE FROM tblhealthworker WHERE id = $id";
                if (mysqli_query($conn, $query)) {
                    $response['success'] = true;
                    $response['message'] = "Barangay Health Worker deleted successfully.";
                    logAction($conn, "Deleted Barangay Health Worker Data for $fname $lname", $user);
                } else {
                    $response['message'] = "Error deleting Barangay Health Worker: " . mysqli_error($conn);
                    logAction($conn, "Failed to delete Barangay Health Worker ID $id: " . mysqli_error($conn), $user);
                }
            } else {
                $response['message'] = "Barangay Health Worker not found.";
                logAction($conn, "Failed to retrieve Barangay Health Worker ID $id: Not found", $user);
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
