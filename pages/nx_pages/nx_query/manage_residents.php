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
function capitalizeFirstLetter($string) {
    return ucwords(strtolower($string)); // 
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

        // Sanitize and capitalize names
        $fname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['fname']));
        $mname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['mname']));
        $lname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['lname']));
        $suffix = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['suffix']));
        $purok = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['purok']));

        // Handle image upload
        $imageName = '../../../assets/images/pfp/default.jpg';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageName = basename($_FILES['image']['name']);
            $targetDir = "../../../assets/images/Identification_card/";
            $targetFile = $targetDir . $imageName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $response['message'] = "Error uploading image.";
                echo json_encode($response);
                exit;
            }
        }

        // Sanitize other input fields
        $bday = mysqli_real_escape_string($conn, $data['bday']);
        $age = (int)$data['age'];
        $houseNo = mysqli_real_escape_string($conn, $data['houseNo']);
        $brgy = mysqli_real_escape_string($conn, $data['brgy'] ?? 'North Poblacion');
        $municipality = mysqli_real_escape_string($conn, $data['municipality'] ?? 'Gabaldon');
        $province = mysqli_real_escape_string($conn, $data['province'] ?? 'Nueva Ecija');
        $civil_status = mysqli_real_escape_string($conn, $data['civil_status']);
        $year_stayed = mysqli_real_escape_string($conn, $data['year_stayed']);
        $education = mysqli_real_escape_string($conn, $data['education']);
        $gender = mysqli_real_escape_string($conn, $data['gender']);
        $birthplace = mysqli_real_escape_string($conn, $data['birthplace']);
        $head_fam = mysqli_real_escape_string($conn, $data['head_fam']);
        $occupation = mysqli_real_escape_string($conn, $data['occupation']);
        $voter = mysqli_real_escape_string($conn, $data['voter']);
        $relation = mysqli_real_escape_string($conn, $data['relation']);

        // Construct the query
        $query = "INSERT INTO tblresident (fname, mname, lname, suffix, bday, age, houseNo, 
                                            purok, brgy, municipality, province, civil_status, 
                                            year_stayed, education, gender, birthplace, 
                                            head_fam, occupation, voter, image, relation) 
                    VALUES ('$fname', '$mname', '$lname', '$suffix', '$bday', $age, '$houseNo', 
                            '$purok', '$brgy', '$municipality', '$province', '$civil_status', 
                            '$year_stayed', '$education', '$gender', '$birthplace', 
                            '$head_fam', '$occupation', '$voter', '$imageName', '$relation')";

        // Execute the query
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
        $data = $_POST;

        // // Validate required fields
        $requiredFields = [
            'resident_id', 'fname', 'lname', 'bday', 
            'age', 'houseNo', 'purok', 'brgy', 'municipality', 
            'province', 'civil_status', 'year_stayed', 'education', 
            'gender', 'birthplace', 'head_fam', 'occupation', 'voter',
            'relation', 'employment_status'
        ];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $response['message'] = "Field '$field' is required.";
                logAction($conn, "Failed to update resident: $response[message]", $user);
                echo json_encode($response);
                exit;
            }
        }

        // Sanitize and capitalize names
        $fname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['fname']));
        $mname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['mname']));
        $lname = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['lname']));
        $suffix = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['suffix']));
        $purok = capitalizeFirstLetter(mysqli_real_escape_string($conn, $data['purok']));

        // Sanitize other fields
        $resident_id = (int)mysqli_real_escape_string($conn, $data['resident_id']);
        $bday = mysqli_real_escape_string($conn, $data['bday']);
        $age = (int)mysqli_real_escape_string($conn, $data['age']);
        $houseNo = mysqli_real_escape_string($conn, $data['houseNo']);
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
        $relation = mysqli_real_escape_string($conn, $data['relation']);
        $employment_status = mysqli_real_escape_string($conn, $data['employment_status']);

        // Handle image upload
        $newFileName = 'default.png';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $newFileName = basename($_FILES['image']['name']);
            $targetDir = "../../../assets/images/Identification_card/";
            $targetFile = $targetDir . $newFileName;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $response['message'] = "Error uploading image.";
                echo json_encode($response);
                exit;
            }
        }

        // Construct the update query
        $query = "UPDATE tblresident SET 
                    fname = '$fname', mname = '$mname', lname = '$lname', suffix = '$suffix', bday = '$bday', 
                    age = $age, houseNo = '$houseNo', purok = '$purok', brgy = '$brgy', municipality = '$municipality', 
                    province = '$province', civil_status = '$civil_status', year_stayed = '$year_stayed', 
                    education = '$education', gender = '$gender', birthplace = '$birthplace', head_fam = '$head_fam', 
                    occupation = '$occupation', voter = '$voter', image = '$newFileName', relation = '$relation', 
                    employment_status = '$employment_status' 
                WHERE resident_id = $resident_id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident updated successfully.";
            logAction($conn, "Updated resident ID $resident_id", $user);
        } else {
            $response['message'] = "Error updating Resident: " . mysqli_error($conn);
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
    case 'deletes':
        // Delete a resident by ID
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tblregistered_account WHERE id = $id";
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
case 'setapprove':
    // Get the raw POST data
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (isset($inputData['isApproved'])) {
        $isApproved = $inputData['isApproved']; // This is now the desired state
        $id = (int)$_GET['resident_id'];

        // Validate resident ID
        if ($id <= 0) {
            $response = [
                'success' => false,
                'message' => "Invalid resident ID"
            ];
            echo json_encode($response);
            exit;
        }

        // Convert boolean to integer (1 or 0)
        $newApprovalState = $isApproved ? 1 : 0;

        // Update the 'IsApproved' field in the tblregistered_account
        $query = "UPDATE tblregistered_account SET isApproved = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $newApprovalState, $id);

        if ($stmt->execute()) {
            $response = [
                'success' => true,
                'message' => "User approval status updated successfully.",
                'data' => ['newApprovalState' => $newApprovalState]
            ];
            logAction($conn, "Toggled approval status for user ID $id to $newApprovalState", $user);

            // Fetch the user's contact number
// Ensure $id is an integer to prevent SQL injection
$id = (int) $id;

// Query to get the contact number
$contactQuery = "SELECT contact_number FROM tblregistered_account WHERE id = $id";
$contactResult = $conn->query($contactQuery);

if ($contactResult && $contactResult->num_rows > 0) {
    $contact = $contactResult->fetch_assoc();
    $contactNumber = $contact['contact_number'];

    // Send SMS via Telerivet
    $message = "Your certificate has been approved.";

    $api_key = 'H_RkO_uw1HficmdKffr9OWNG1s2Isd8sP5S2';
    $project_id = 'PJ3d74c709991602b6';
    
    $url = "https://api.telerivet.com/v1/projects/$project_id/messages/send";
    $data = [
        'to_number' => $contactNumber,  // The recipient's phone number
        'content' => $message,  // The message to send
    ];

    // Use cURL to send the request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "X-Telerivet-API-Key: $api_key",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute and check for errors in the Telerivet API request
    $telerivet_response = curl_exec($ch);
    if ($telerivet_response === false) {
        $error = curl_error($ch);
        logAction($conn, "Telerivet API failed to send message to user ID $id: $error", $user);
        $response['message'] = "Error sending SMS notification: " . $error;
    }
    curl_close($ch);
} else {
    $response['message'] = "User's contact number not found.";
    logAction($conn, "Failed to retrieve contact number for user ID $id", $user);
}

        } else {
            $response = [
                'success' => false,
                'message' => "Error updating approval status: " . mysqli_error($conn)
            ];
        }
    } else {
        $response = [
            'success' => false,
            'message' => "Missing 'isApproved' in request data"
        ];
    }

    break;

    default:
        $response['message'] = "Invalid action.";
        logAction($conn, "Invalid action attempted: $action", $user);
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
