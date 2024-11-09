<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection
session_start();
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
$user = $_SESSION['user']['username']; // Replace with actual user identification logic
$userid = $_SESSION['user']['id'];

switch ($action) {
    case 'get':
        $id = (int)$_GET['id'] ?? 0;
        $stmt = $conn->prepare("SELECT * FROM vehicle_cert WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $official = $result->fetch_assoc();
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Vehicle Certificate data not found.";
        }
        break;

    case 'create':
        $sellerName = $_POST['sellerName'] ?? '';
        $sellerAddress = $_POST['sellerAddress'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $amount_words = $_POST['amount_words'] ?? '';
        $buyerName = $_POST['buyerName'] ?? '';
        $buyerAddress = $_POST['buyerAddress'] ?? '';
        $make = $_POST['make'] ?? '';
        $plateNum = $_POST['plateNumber'] ?? '';  // Ensure consistent naming
        $engineNum = $_POST['engineNumber'] ?? ''; // Ensure consistent naming
        $chasisNum = $_POST['chasisNumber'] ?? ''; // Ensure consistent naming
        $denomination = $_POST['denomination'] ?? '';
        $fuel = $_POST['fuel'] ?? '';
        $bodyType = $_POST['bodyType'] ?? '';
        $crNo = $_POST['crNo'] ?? '';
        $date = $_POST['date'] ?? '';
        $witness = $_POST['witness'] ?? '';
        $locationTran = $_POST['locationTransaction'] ?? ''; // Ensure consistent naming
        $cert_amount = $_POST['certificateAmount'] ?? ''; // Ensure consistent naming
        $status = 'New';

        // Construct the SQL query
        $query = "INSERT INTO vehicle_cert ( sellerID,
                    sellerName, sellerAddress, amount, amount_words, 
                    buyerName, buyerAddress, make, plateNum, 
                    engineNum, chasisNum, denomination, fuel, 
                    bodyType, crNo, date, witness, 
                    locationTran, cert_amount, status, created_by
                ) VALUES (
                    '$userid',
                    '$sellerName', '$sellerAddress', '$amount', '$amount_words', 
                    '$buyerName', '$buyerAddress', '$make', '$plateNum', 
                    '$engineNum', '$chasisNum', '$denomination', '$fuel', 
                    '$bodyType', '$crNo', '$date', '$witness', 
                    '$locationTran', '$cert_amount', '$status', '$userid'
                )";

        // Execute the query
        if ($conn->query($query) === TRUE) {
            $response['success'] = true;
            $response['message'] = "Certificate created successfully.";
            $response['data'] = [
                'id' => $conn->insert_id, // Return the ID of the new record
            ];
            logAction($conn, "Created certificate with ID: " . $conn->insert_id, $user);
        } else {
            $response['message'] = "Failed to create certificate: " . $conn->error;
        }
        break;


    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
