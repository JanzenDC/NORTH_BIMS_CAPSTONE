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
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

$action = $_GET['action'] ?? '';
$userid = $_SESSION['user']['id'];

switch ($action) {

    case 'create':
        // Get data from the POST request
        $sellerName = $_POST['sellerName'] ?? '';
        $sellerAddress = $_POST['sellerAddress'] ?? '';
        $buyerName = $_POST['buyerName'] ?? '';
        $buyerAddress = $_POST['buyerAddress'] ?? '';
        $itemSold = $_POST['itemSold'] ?? '';
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0;
        $age = $_POST['ageOfAnimal'] ?? '';
        $sex = $_POST['sexOfAnimal'] ?? '';
        $amount = isset($_POST['amount']) ? (float)$_POST['amount'] : 0.0;
        $amountInWords = $_POST['amountInWords'] ?? '';
        $transactionDate = $_POST['transactionDate'] ?? '';
        $cowlicks = $_POST['cowlicks'] ?? '';
        $brandOfMunicipality = $_POST['brandOfMunicipality'] ?? '';
        $brandOfOwner = $_POST['brandOfOwner'] ?? '';
        $certificateAmount = isset($_POST['certificateAmount']) ? (float)$_POST['certificateAmount'] : 0.0;
        $dateOfPickup = $_POST['dateOfPickup'] ?? '';
        $note = $_POST['note'] ?? '';

        // Default status to "Walk-In" if not provided
        $status = "New";

        // Construct the SQL query to insert the new record
        $query = "INSERT INTO livestock_cert 
            (sellerName, sellerAddress, buyerName, buyerAddress, itemSold, 
            quantity, age, sex, amount, amount_words, transacDate, cowlicks, 
            brandMun, brandOwn, cert_amount, date_of_pickup, status, note, created_by)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssiisssssssssdsssi", $sellerName, $sellerAddress, $buyerName, $buyerAddress, 
            $itemSold, $quantity, $age, $sex, $amount, $amountInWords, 
            $transactionDate, $cowlicks, $brandOfMunicipality, $brandOfOwner, 
            $certificateAmount, $dateOfPickup, $status, $note, $userid);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record created successfully.";
            $response['data'] = [
                'id' => mysqli_insert_id($conn),
                'sellerName' => $sellerName,
                'buyerName' => $buyerName
            ];
            logAction($conn, "Created livestock certificate for seller: $sellerName", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
