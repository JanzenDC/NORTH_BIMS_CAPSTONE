<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

require "../../db_connect.php";
session_start();
$response = [
    'success' => false,
    'message' => '',
    'data' => null,
];

function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}

$action = $_GET['action'] ?? '';
switch ($action) {
case 'create':
    try {
        $userid = $_POST['created_by'] ?? '';
        $sellerName = $_POST['sellerName'] ?? '';
        $sellerAddress = $_POST['sellerAddress'] ?? '';
        $buyerName = $_POST['buyerName'] ?? '';
        $buyerAddress = $_POST['buyerAddress'] ?? '';
        $itemSold = $_POST['kindOfAnimal'] ?? ''; // Changed from itemSold to kindOfAnimal
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
        $status = "New";
        
        // Debug the values
        error_log("Values to be inserted: " . print_r($_POST, true));

        $query = "INSERT INTO livestock_cert 
            (sellerName, sellerAddress, buyerName, buyerAddress, itemSold, 
            quantity, age, sex, amount, amount_words, transacDate, cowlicks, 
            brandMun, brandOwn, cert_amount, date_of_pickup, status, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        // Note: We removed 'note' from the binding as it wasn't in the SQL query
        $stmt->bind_param("sssssissdsssssdssi",
            $sellerName,
            $sellerAddress, 
            $buyerName,
            $buyerAddress,
            $itemSold,
            $quantity,
            $age,
            $sex,
            $amount,
            $amountInWords,
            $transactionDate,
            $cowlicks,
            $brandOfMunicipality,
            $brandOfOwner,
            $certificateAmount,
            $dateOfPickup,
            $status,
            $userid
        );

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record created successfully.";
            $response['data'] = [
                'id' => $stmt->insert_id,
                'sellerName' => $sellerName,
                'buyerName' => $buyerName
            ];
            logAction($conn, "Created livestock certificate for seller: $sellerName", $_SESSION['user']['username']);
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        $response['success'] = false;
        $response['message'] = "Error: " . $e->getMessage();
        error_log("Error in certificate creation: " . $e->getMessage());
    }
    break;

    default:
        $response['message'] = "Invalid action.";
}

echo json_encode($response);
mysqli_close($conn);
?>
