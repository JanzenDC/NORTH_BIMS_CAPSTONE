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
        $image = $_FILES['image']['name'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image")) {
            $query = "INSERT INTO tblofficial (fname, mname, lname, suffix, position, contact, bday, image) 
                      VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = "Officials created successfully.";
                logAction($conn, "Created Official: $fname $lname", $user);
            } else {
                $response['message'] = "Error creating Officials: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "Error uploading image.";
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
            logAction($conn, "Retrieved Official ID: $id", $user);
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
            $response['message'] = "Officials updated successfully.";
            logAction($conn, "Updated Official ID: $id", $user);
        } else {
            $response['message'] = "Error updating Officials: " . mysqli_error($conn);
            error_log("SQL Error: " . mysqli_error($conn)); // Log SQL error for debugging
        }
        break;

    case 'delete':
        // Delete
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tblofficial WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Officials deleted successfully.";
            logAction($conn, "Deleted Official ID: $id", $user);
        } else {
            $response['message'] = "Error deleting Officials: " . mysqli_error($conn);
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
