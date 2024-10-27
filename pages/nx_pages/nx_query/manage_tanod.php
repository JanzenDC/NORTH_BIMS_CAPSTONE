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

function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

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
        $image = $_FILES['image']['name'];

        if (move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image")) {
            $query = "INSERT INTO tbltanod (fname, mname, lname, suffix, position, contact, bday, image) 
                      VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = "Official created successfully.";
                logAction($conn, "Created official: $fname $lname", $user);
            } else {
                $response['message'] = "Error creating official: " . mysqli_error($conn);
                logAction($conn, "Failed to create official: " . mysqli_error($conn), $user);
            }
        } else {
            $response['message'] = "Error uploading image.";
            logAction($conn, "Failed to upload image for official: $response[message]", $user);
        }
        break;

    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM tbltanod WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
            logAction($conn, "Retrieved official ID $id", $user);
        } else {
            $response['message'] = "Barangay Tanod not found.";
            logAction($conn, "Failed to retrieve official ID $id: Not found", $user);
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
            logAction($conn, "Updated official ID $id", $user);
        } else {
            $response['message'] = "Error updating official: " . mysqli_error($conn);
            logAction($conn, "Failed to update official ID $id: " . mysqli_error($conn), $user);
        }
        break;

    case 'delete':
        // Delete
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tbltanod WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Official deleted successfully.";
            logAction($conn, "Deleted official ID $id", $user);
        } else {
            $response['message'] = "Error deleting official: " . mysqli_error($conn);
            logAction($conn, "Failed to delete official ID $id: " . mysqli_error($conn), $user);
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
