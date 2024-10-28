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
function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}
$user = $_SESSION['user']['username']; 

switch ($action) {
    case 'get':
        // Read a resident by ID
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM tblresident WHERE resident_id = $id";
        $result = mysqli_query($conn, $query);
        $resident = mysqli_fetch_assoc($result);
        
        if ($resident) {
            $response['success'] = true;
            $response['data'] = $resident;
            logAction($conn, "Retrieved resident ID $id", $user);
        } else {
            $response['message'] = "Resident not found.";
            logAction($conn, "Failed to retrieve resident ID $id: Resident not found", $user);
        }
        break;

    case 'create':
        // Create a new resident
        $data = $_POST; // Get the JSON payload

        // Validate required fields
        $requiredFields = ['fname', 'mname', 'lname', 'suffix', 'bday', 'age', 'houseNo', 
                           'purok', 'brgy', 'municipality', 'province', 'civil_status', 
                           'year_stayed', 'education', 'gender', 'birthplace', 
                           'head_fam', 'occupation', 'voter'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $response['message'] = "Field '$field' is required.";
                logAction($conn, "Failed to create resident: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        }

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['image']['name']);
            $targetDir = "../../../assets/images/pfp/";
            $targetFile = $targetDir . $imageName;

            // Move the uploaded file to the target directory
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $response['message'] = "Error uploading image.";
                logAction($conn, "Failed to create resident: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        } else {
            $response['message'] = "Image file is required.";
            logAction($conn, "Failed to create resident: $response[message]", $user);
            echo json_encode($response);
            exit;
        }

        // Sanitize input data
        // (Sanitization code remains unchanged)

        // Prepare and execute the insert query
        $query = "INSERT INTO tblresident (fname, mname, lname, suffix, bday, age, houseNo, 
                                            purok, brgy, municipality, province, civil_status, 
                                            year_stayed, education, gender, birthplace, 
                                            head_fam, occupation, voter, image) 
                  VALUES ('$fname', '$mname', '$lname', '$suffix', '$bday', $age, $houseNo, 
                          '$purok', '$brgy', '$municipality', '$province', '$civil_status', 
                          '$year_stayed', '$education', '$gender', '$birthplace', 
                          '$head_fam', '$occupation', '$voter', '$imageName')";

        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident created successfully.";
            $response['data'] = ['id' => mysqli_insert_id($conn)];
            logAction($conn, "Created resident ID " . $response['data']['id'], $user);
        } else {
            $response['message'] = "Error creating Resident: " . mysqli_error($conn);
            logAction($conn, "Failed to create resident: $response[message]", $user);
        }
        break;

    case 'update':
        // Update an existing resident
        $data = $_POST; // Get the JSON payload

        // Validate required fields
        $requiredFields = ['resident_id', 'fname', 'mname', 'lname', 'suffix', 'bday', 
                           'age', 'houseNo', 'purok', 'brgy', 'municipality', 
                           'province', 'civil_status', 'year_stayed', 'education', 
                           'gender', 'birthplace', 'head_fam', 'occupation', 'voter'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                $response['message'] = "Field '$field' is required.";
                logAction($conn, "Failed to update resident: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        }

        // Sanitize input data
        // (Sanitization code remains unchanged)

        // Handle optional image upload
        // (Image upload handling code remains unchanged)

        // Prepare the update query
        // (Query preparation code remains unchanged)

        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident updated successfully.";
            logAction($conn, "Updated resident ID $id", $user);
        } else {
            $response['message'] = "Error updating Resident: " . mysqli_error($conn);
            logAction($conn, "Failed to update resident ID $id: $response[message]", $user);
        }
        break;

    case 'delete':
        // Delete a resident by ID
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tblresident WHERE resident_id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident deleted successfully.";
            logAction($conn, "Deleted resident ID $id", $user);
        } else {
            $response['message'] = "Error deleting Resident: " . mysqli_error($conn);
            logAction($conn, "Failed to delete resident ID $id: $response[message]", $user);
        }
        break;
    case 'setAdmin':
        // Set a resident as an admin
        $id = (int)$_GET['id'];
        
        // Update the resident's role (assuming you have a column named 'role' in your tblresident)
        $query = "UPDATE tblregistered_account SET isAdmin = '1' WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident ID $id has been set as admin.";
            logAction($conn, "Set resident ID $id as admin", $user);
        } else {
            $response['message'] = "Error setting resident as admin: " . mysqli_error($conn);
            logAction($conn, "Failed to set resident ID $id as admin: $response[message]", $user);
        }
        break;
    case 'removeAdmin':
        // Remove admin status
        $id = (int)$_GET['id'];
        $query = "UPDATE tblregistered_account SET isAdmin = '0' WHERE id = $id"; // Assuming '0' is not admin
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "User removed from admin.";
            logAction($conn, "User ID $id removed from admin", $user);
        } else {
            $response['message'] = "Error removing admin: " . mysqli_error($conn);
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
