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

// Function to capitalize first letter of each word
function capitalizeFirstLetter($string) {
    return ucwords(strtolower($string)); // Capitalize the first letter of each word, ensuring the rest are lowercase
}

$action = $_GET['action'] ?? '';
$user = $_SESSION['user']['username']; 
switch ($action) {
case 'create':
    // Create
    $fname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['fname']));
    $mname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['mname']));
    $lname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['lname']));
    $suffix = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['suffix']));
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
            logAction($conn, "Failed to upload image for Official: $response[message]", $user);
            exit; // Stop the execution if image upload fails
        }
    }

    // Insert data into the database
    $query = "INSERT INTO tblofficial (fname, mname, lname, suffix, position, contact, bday, image) 
              VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
        $response['message'] = "Officials created successfully.";
        logAction($conn, "Created Barangay Official Data for $fname $lname with Position of $position", $user);
    } else {
        $response['message'] = "Error creating Officials: " . mysqli_error($conn);
    }
    break;


    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM tblofficial WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
            // logAction($conn, "Retrieved Barangay Official Data for $fname $lname with Position of $position", $user);
        } else {
            $response['message'] = "Officials not found.";
        }
        break;

    case 'update':
        // Update
        $id = (int)$_POST['id'];
        $fname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['fname']));
        $mname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['mname']));
        $lname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['lname']));
        $suffix = capitalizeFirstLetter(mysqli_real_escape_string($conn, $_POST['suffix']));
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
            $query = "UPDATE tblofficial SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday', image='$image' WHERE id=$id";
        } else {
            $query = "UPDATE tblofficial SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday' WHERE id=$id";
        }

        // Execute query and handle response
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Barangay Officials updated successfully.";
            logAction($conn, "Updated Barangay Official Data for $lname $fname with Position of $position", $user);
        } else {
            $response['message'] = "Error updating Officials: " . mysqli_error($conn);
            error_log("SQL Error: " . mysqli_error($conn)); // Log SQL error for debugging
        }
        break;

case 'delete':
    // Delete
    $id = (int)$_GET['id'];

    // Retrieve the fname, lname, and position for the specified official ID
    $query = "SELECT fname, lname, position FROM tblofficial WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fname = $row['fname'];
        $lname = $row['lname'];
        $position = $row['position'];

        // Proceed with deletion
        $deleteQuery = "DELETE FROM tblofficial WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Officials deleted successfully.";
            logAction($conn, "Deleted Barangay Official Data for $fname $lname with position of $position", $user);
        } else {
            $response['success'] = false;
            $response['message'] = "Error deleting officials: " . $deleteStmt->error;
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Official not found.";
    }

    break;

default:
    $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
