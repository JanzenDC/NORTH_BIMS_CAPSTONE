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
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$bday = mysqli_real_escape_string($conn, $_POST['bday']);

// Check if an image was uploaded
if ($_FILES['image']['error'] == UPLOAD_ERR_NO_FILE) {
    // No image uploaded, use a default image
    $image = '../../../assets/images/pfp/default.jpg'; // Set default image name
} else {
    // Image uploaded, move it to the desired directory
    $image = $_FILES['image']['name'];
    if (move_uploaded_file($_FILES['image']['tmp_name'], "../../../assets/images/pfp/$image")) {
        // Successfully uploaded image
    } else {
        $response['message'] = "Error uploading image.";
        logAction($conn, "Failed to upload image for Sangguniang Kabataan: $response[message]", $user);
        exit; // Stop the execution if image upload fails
    }
}

// Insert data into the database
$query = "INSERT INTO tblkabataan (fname, mname, lname, suffix, position, contact, bday, image) 
          VALUES ('$fname', '$mname', '$lname', '$suffix', '$position', '$contact', '$bday', '$image')";
if (mysqli_query($conn, $query)) {
    $response['success'] = true;
    $response['message'] = "Sangguniang Kabataan created successfully.";
    logAction($conn, "Created Sangguniang Kabataan Data for $fname $lname with position $position", $user);
} else {
    $response['message'] = "Error creating Sangguniang Kabataan: " . mysqli_error($conn);
    logAction($conn, "Failed to create Sangguniang Kabataan: " . mysqli_error($conn), $user);
}
break;

case 'get':
    // Read
    $id = (int)$_GET['id'];
    
    // Query to retrieve data from tblkabataan, including fname, lname, and position
    $query = "SELECT fname, lname, position FROM tblkabataan WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    // Fetch the official's data
    $official = mysqli_fetch_assoc($result);
    
    if ($official) {
        // Get the fname, lname, and position values from the fetched result
        $fname = $official['fname'];
        $lname = $official['lname'];
        $position = $official['position'];
        
        // Set the response for success
        $response['success'] = true;
        $response['data'] = $official;

    } else {
        // Handle the case when the data is not found
        $response['message'] = "Sangguniang Kabataan not found.";
        logAction($conn, "Failed to retrieve Sangguniang Kabataan ID $id: Not found", $user);
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
                logAction($conn, "Failed to upload image for Sangguniang Kabataan ID $id: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        }

        // Build the update query
        if ($image) {
            $query = "UPDATE tblkabataan SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday', image='$image' WHERE id=$id";
        } else {
            $query = "UPDATE tblkabataan SET fname='$fname', mname='$mname', lname='$lname', suffix='$suffix', 
                      position='$position', contact='$contact', bday='$bday' WHERE id=$id";
        }

        // Execute query and handle response
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Sangguniang Kabataan updated successfully.";
            logAction($conn, "Updated Sangguniang Kabataan Data for $fname $lname with posiiton of $position", $user);
        } else {
            $response['message'] = "Error updating Sangguniang Kabataan: " . mysqli_error($conn);
            logAction($conn, "Failed to update Sangguniang Kabataan ID $id: " . mysqli_error($conn), $user);
        }
        break;

case 'delete':
    // Delete
    $id = (int)$_GET['id'];

    // Step 1: Retrieve fname, lname, and position for the Sangguniang Kabataan before deletion
    $query = "SELECT fname, lname, position FROM tblkabataan WHERE id = $id";
    $result = mysqli_query($conn, $query);
    
    // Check if the official exists
    if ($result && mysqli_num_rows($result) > 0) {
        $official = mysqli_fetch_assoc($result);
        $fname = $official['fname'];
        $lname = $official['lname'];
        $position = $official['position'];

        // Step 2: Perform the deletion
        $deleteQuery = "DELETE FROM tblkabataan WHERE id = $id";
        if (mysqli_query($conn, $deleteQuery)) {
            $response['success'] = true;
            $response['message'] = "Sangguniang Kabataan deleted successfully.";
            // Log the deletion with the official's name and position
            logAction($conn, "Deleted Sangguniang Kabataan Data for $fname $lname with position of $position", $user);
        } else {
            $response['message'] = "Error deleting Sangguniang Kabataan: " . mysqli_error($conn);
            logAction($conn, "Failed to delete Sangguniang Kabataan ID $id: " . mysqli_error($conn), $user);
        }
    } else {
        $response['message'] = "Sangguniang Kabataan not found.";
        logAction($conn, "Failed to find Sangguniang Kabataan ID $id for deletion", $user);
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
