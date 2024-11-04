<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

session_start(); // Start the session to access session variables

$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

$action = $_GET['action'] ?? '';

function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}
$userID = $_SESSION['user']['id'];
switch ($action) {
    case 'create':
        // Retrieve form data
        $owner_fname = mysqli_real_escape_string($conn, $_POST['fname'] ?? '');
        $owner_mname = mysqli_real_escape_string($conn, $_POST['mname'] ?? '');
        $owner_lname = mysqli_real_escape_string($conn, $_POST['lname'] ?? '');
        $owner_suffix = mysqli_real_escape_string($conn, $_POST['owner_suffix'] ?? '');
        $businessName = mysqli_real_escape_string($conn, $_POST['businessName'] ?? '');
        $typeOfBusiness = mysqli_real_escape_string($conn, $_POST['typeOfBusiness'] ?? '');
        $businessAddress = mysqli_real_escape_string($conn, $_POST['businessAddress'] ?? '');
        $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');
        $barangay = mysqli_real_escape_string($conn, $_POST['barangay'] ?? '');
        $municipality = mysqli_real_escape_string($conn, $_POST['municipality'] ?? '');
        $province = mysqli_real_escape_string($conn, $_POST['province'] ?? '');
        $date_issued = mysqli_real_escape_string($conn, $_POST['dateIssued'] ?? '');
        $amount = mysqli_real_escape_string($conn, $_POST['amount'] ?? '');
        $cert_amount = mysqli_real_escape_string($conn, $_POST['certAmount'] ?? '');
        $date_of_pickup = mysqli_real_escape_string($conn, $_POST['date_of_pickup'] ?? '');
        $note = mysqli_real_escape_string($conn, $_POST['note'] ?? '');
        $status = mysqli_real_escape_string($conn, $_POST['status'] ?? '');

        // Prepare the SQL query
        $sql = "INSERT INTO business_cert (ownerid, owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) 
                VALUES ('$userID', '$owner_fname', '$owner_mname', '$owner_lname', '$owner_suffix', '$businessName', '$typeOfBusiness', '$businessAddress', '$street', '$barangay', '$municipality', '$province', '$date_issued', '$amount', '$status', '$cert_amount', '$date_of_pickup', '$note')";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            $response['success'] = true;
            $response['message'] = 'Certificate added successfully!';
            $response['data'] = [
                'id' => mysqli_insert_id($conn), // Return the ID of the new record
            ];
            logAction($conn, "Created certificate for $businessName", $_SESSION['user']['username']);
        } else {
            $response['message'] = 'Failed to add certificate: ' . mysqli_error($conn);
        }
        
        break;
    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>