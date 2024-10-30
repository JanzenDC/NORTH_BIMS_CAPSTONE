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
        $data = $_POST;

        // Validate required fields
        $requiredFields = ['fname', 'mname', 'lname', 'suffix', 'bday', 'age', 'houseNo', 
                        'purok', 'civil_status', 'year_stayed', 'education', 'gender', 
                        'birthplace', 'head_fam', 'occupation', 'voter', 'image'];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $response['message'] = "Field '$field' is required.";
                logAction($conn, "Failed to create resident: $response[message]", $user);
                                echo json_encode($response);
                exit;
            }
        }

        $brgy = isset($data['brgy']) ? mysqli_real_escape_string($conn, $data['brgy']) : 'North Poblacion';
        $municipality = isset($data['municipality']) ? mysqli_real_escape_string($conn, $data['municipality']) : 'Gabaldon';
        $province = isset($data['province']) ? mysqli_real_escape_string($conn, $data['province']) : 'Nueva Ecija';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['image']['name']);
            $targetDir = "../../../assets/images/Identification_card/";
            $targetFile = $targetDir . $imageName;

            // Move the uploaded file to the target directory
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $response['message'] = "Error uploading image.";
            }
        }

        // Sanitize input data
        $fname = mysqli_real_escape_string($conn, $data['fname']);
        $mname = mysqli_real_escape_string($conn, $data['mname']);
        $lname = mysqli_real_escape_string($conn, $data['lname']);
        $suffix = mysqli_real_escape_string($conn, $data['suffix']);
        $bday = mysqli_real_escape_string($conn, $data['bday']);
        $age = (int) $data['age'];
        $houseNo = mysqli_real_escape_string($conn, $data['houseNo']);
        $purok = mysqli_real_escape_string($conn, $data['purok']);
        // Use the set default values above
        $civil_status = mysqli_real_escape_string($conn, $data['civil_status']);
        $year_stayed = mysqli_real_escape_string($conn, $data['year_stayed']);
        $education = mysqli_real_escape_string($conn, $data['education']);
        $gender = mysqli_real_escape_string($conn, $data['gender']);
        $birthplace = mysqli_real_escape_string($conn, $data['birthplace']);
        $head_fam = mysqli_real_escape_string($conn, $data['head_fam']);
        $occupation = mysqli_real_escape_string($conn, $data['occupation']);
        $voter = mysqli_real_escape_string($conn, $data['voter']);

        // Prepare and execute the insert query
        $query = "INSERT INTO tblresident (fname, mname, lname, suffix, bday, age, houseNo, 
                                            purok, brgy, municipality, province, civil_status, 
                                            year_stayed, education, gender, birthplace, 
                                            head_fam, occupation, voter, image) 
                VALUES ('$fname', '$mname', '$lname', '$suffix', '$bday', $age, '$houseNo', 
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
        $id = mysqli_real_escape_string($conn, $data['resident_id']);
        $fname = mysqli_real_escape_string($conn, $data['fname']);
        $mname = mysqli_real_escape_string($conn, $data['mname']);
        $lname = mysqli_real_escape_string($conn, $data['lname']);
        $suffix = mysqli_real_escape_string($conn, $data['suffix']);
        $bday = mysqli_real_escape_string($conn, $data['bday']);
        $age = mysqli_real_escape_string($conn, $data['age']);
        $houseNo = mysqli_real_escape_string($conn, $data['houseNo']);
        $purok = mysqli_real_escape_string($conn, $data['purok']);
        $brgy = mysqli_real_escape_string($conn, $data['brgy']);
        $municipality = mysqli_real_escape_string($conn, $data['municipality']);
        $province = mysqli_real_escape_string($conn, $data['province']);
        $civil_status = mysqli_real_escape_string($conn, $data['civil_status']);
        $year_stayed = mysqli_real_escape_string($conn, $data['year_stayed']);
        $education = mysqli_real_escape_string($conn, $data['education']);
        $gender = mysqli_real_escape_string($conn, $data['gender']);
        $birthplace = mysqli_real_escape_string($conn, $data['birthplace']);
        $head_fam = mysqli_real_escape_string($conn, $data['head_fam']);
        $occupation = mysqli_real_escape_string($conn, $data['occupation']);
        $voter = mysqli_real_escape_string($conn, $data['voter']);

        // Handle optional image upload
        $newFileName = null; // Initialize variable for new file name
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['image']['tmp_name'];
            $fileName = $_FILES['image']['name'];
            $fileSize = $_FILES['image']['size'];
            $fileType = $_FILES['image']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Specify the allowed file types
            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];

            if (in_array($fileExtension, $allowedfileExtensions)) {
                // Create a unique name for the file
                $newFileName = uniqid('', true) . '.' . $fileExtension;
                $uploadFileDir = '../../../assets/images/Identification_card/';
                $dest_path = $uploadFileDir . $newFileName;

                // Move the file to the desired directory
                if (!move_uploaded_file($fileTmpPath, $dest_path)) {
                    $response['message'] = "Error moving the uploaded file.";
                    echo json_encode($response);
                    exit;
                }
            } else {
                $response['message'] = "Upload failed. Allowed file types: " . implode(', ', $allowedfileExtensions);
                echo json_encode($response);
                exit;
            }
        }

        // Prepare the update query
        $query = "UPDATE tblresident SET 
                    fname = '$fname', 
                    mname = '$mname', 
                    lname = '$lname', 
                    suffix = '$suffix', 
                    bday = '$bday', 
                    age = '$age', 
                    houseNo = '$houseNo', 
                    purok = '$purok', 
                    brgy = '$brgy', 
                    municipality = '$municipality', 
                    province = '$province', 
                    civil_status = '$civil_status', 
                    year_stayed = '$year_stayed', 
                    education = '$education', 
                    gender = '$gender', 
                    birthplace = '$birthplace', 
                    head_fam = '$head_fam', 
                    occupation = '$occupation', 
                    voter = '$voter'";

        // Include image filename in query if uploaded
        if ($newFileName) {
            $query .= ", image = '$newFileName'";
        }

        $query .= " WHERE resident_id = '$id'";

        // Execute the query
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
