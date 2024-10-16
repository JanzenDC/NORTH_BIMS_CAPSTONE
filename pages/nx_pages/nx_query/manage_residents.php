<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM tblresident WHERE resident_id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Purok Leader not found.";
        }
        break;

case 'create':
    // Create
    $data = json_decode(file_get_contents("php://input"), true); // Get the JSON payload

    // Validate required fields
    $requiredFields = ['fname', 'mname', 'lname', 'suffix', 'bday', 'age', 'houseNo', 'purok', 
                       'brgy', 'municipality', 'province', 'civil_status', 'year_stayed', 
                       'education', 'gender', 'birthplace', 'head_fam', 'occupation', 'voter'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response['message'] = "Field '$field' is required.";
            echo json_encode($response);
            exit;
        }
    }

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "../../../assets/images/pfp/"; // Make sure this directory exists and is writable
        $targetFile = $targetDir . $imageName;

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            // Sanitize input data
            $fname = mysqli_real_escape_string($conn, $data['fname']);
            $mname = mysqli_real_escape_string($conn, $data['mname']);
            $lname = mysqli_real_escape_string($conn, $data['lname']);
            $suffix = mysqli_real_escape_string($conn, $data['suffix']);
            $bday = mysqli_real_escape_string($conn, $data['bday']);
            $age = (int)$data['age'];
            $houseNo = (int)$data['houseNo'];
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

            // Prepare and execute the insert query
            $query = "INSERT INTO tblresident (fname, mname, lname, suffix, bday, age, houseNo, 
                                                purok, brgy, municipality, province, civil_status, 
                                                year_stayed, education, gender, birthplace, 
                                                head_fam, occupation, voter, image) 
                      VALUES ('$fname', '$mname', '$lname', '$suffix', '$bday', $age, $houseNo, 
                              '$purok', '$brgy', '$municipality', '$province', '$civil_status', 
                              '$year_stayed', '$education', '$gender', '$birthplace', 
                              '$head_fam', '$occupation', '$voter', '$imageName')"; // Store only the image name

            if (mysqli_query($conn, $query)) {
                $response['success'] = true;
                $response['message'] = "Resident created successfully.";
                $response['data'] = [
                    'id' => mysqli_insert_id($conn), // Optionally return the new resident ID
                    'fname' => $fname,
                    // Include other fields if necessary
                ];
            } else {
                $response['message'] = "Error creating Resident: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "Error uploading image.";
        }
    } else {
        $response['message'] = "Image file is required.";
    }
    break;


case 'update':
    // Update
    $data = json_decode(file_get_contents("php://input"), true); // Get the JSON payload

    // Validate required fields
    $requiredFields = ['resident_id', 'fname', 'mname', 'lname', 'suffix', 'bday', 'age', 'houseNo', 
                       'purok', 'brgy', 'municipality', 'province', 'civil_status', 
                       'year_stayed', 'education', 'gender', 'birthplace', 'head_fam', 
                       'occupation', 'voter'];

    foreach ($requiredFields as $field) {
        if (!isset($data[$field])) {
            $response['message'] = "Field '$field' is required.";
            echo json_encode($response);
            exit;
        }
    }

    // Sanitize input data
    $id = (int)$data['resident_id'];
    $fname = mysqli_real_escape_string($conn, $data['fname']);
    $mname = mysqli_real_escape_string($conn, $data['mname']);
    $lname = mysqli_real_escape_string($conn, $data['lname']);
    $suffix = mysqli_real_escape_string($conn, $data['suffix']);
    $bday = mysqli_real_escape_string($conn, $data['bday']);
    $age = (int)$data['age'];
    $houseNo = (int)$data['houseNo'];
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

    // Handle image upload (optional)
    $imageName = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageName = basename($_FILES['image']['name']);
        $targetDir = "../../../assets/images/pfp/"; // Update target directory as needed
        $targetFile = $targetDir . $imageName;

        // Move the uploaded file to the target directory
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $response['message'] = "Error uploading image.";
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
                age = $age,
                houseNo = $houseNo,
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
                voter = '$voter'" . 
                ($imageName ? ", image = '$imageName'" : "") . 
              " WHERE resident_id = $id";

    if (mysqli_query($conn, $query)) {
        $response['success'] = true;
        $response['message'] = "Resident updated successfully.";
    } else {
        $response['message'] = "Error updating Resident: " . mysqli_error($conn);
    }
    break;



    case 'delete':
        // Delete
        $id = (int)$_GET['id'];
        $query = "DELETE FROM tblresidents WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Resident deleted successfully.";
        } else {
            $response['message'] = "Error deleting Resident: " . mysqli_error($conn);
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
