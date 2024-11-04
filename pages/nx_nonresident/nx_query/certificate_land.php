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

$action = $_GET['action'] ?? '';


// Function to log actions
function logAction($conn, $action, $user) {
    $logdate = date('Y-m-d H:i:s');
    $sql = "INSERT INTO tbllogs (user, logdate, action) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user, $logdate, $action);
    $stmt->execute();
}
$userid = $_SESSION['user']['id'];
switch ($action) {
    case 'create':
        // Get data from POST request

        $sellerName      = mysqli_real_escape_string($conn, $_POST['sellerName'] ?? '');
        $sellerAddress   = mysqli_real_escape_string($conn, $_POST['sellerAddress'] ?? '');
        $buyerName       = mysqli_real_escape_string($conn, $_POST['buyerName'] ?? '');
        $buyerAddress    = mysqli_real_escape_string($conn, $_POST['buyerAddress'] ?? '');
        $landArea        = mysqli_real_escape_string($conn, $_POST['landArea'] ?? '');
        $propertySold    = mysqli_real_escape_string($conn, $_POST['propertySold'] ?? '');
        $amount          = (int)($_POST['amount'] ?? 0);
        $amount_words    = mysqli_real_escape_string($conn, $_POST['amount_words'] ?? '');
        $legalAgree      = mysqli_real_escape_string($conn, $_POST['legalAgree'] ?? '');
        $paymentConfirm   = mysqli_real_escape_string($conn, $_POST['paymentConfirm'] ?? '');
        $confirmationPay = mysqli_real_escape_string($conn, $_POST['confirmationPay'] ?? '');
        $date            = mysqli_real_escape_string($conn, $_POST['date'] ?? '');
        $witness         = mysqli_real_escape_string($conn, $_POST['witness'] ?? '');
        $notarizeDate    = mysqli_real_escape_string($conn, $_POST['notarizeDate'] ?? '');
        $locationNota    = mysqli_real_escape_string($conn, $_POST['locationNota'] ?? '');
        $status          = mysqli_real_escape_string($conn, $_POST['status'] ?? 'New');
        $cert_amount     = mysqli_real_escape_string($conn, $_POST['cert_amount'] ?? '');
        $date_of_pickup  = mysqli_real_escape_string($conn, $_POST['date_of_pickup'] ?? '');
        $note            = mysqli_real_escape_string($conn, $_POST['note'] ?? '');

        // Construct the SQL query
        $query = "
            INSERT INTO land_cert (
                sellerName, sellerAddress, buyerName, buyerAddress, landArea, 
                propertySold, amount, amount_words, legalAgree, 
                paymentConfirm, confirmationPay, date, witness, 
                notarizeDate, locationNota, status, cert_amount, 
                date_of_pickup, note, created_by
            ) VALUES (
                '$sellerName', 
                '$sellerAddress', 
                '$buyerName', 
                '$buyerAddress', 
                '$landArea', 
                '$propertySold', 
                $amount, 
                '$amount_words', 
                '$legalAgree', 
                '$paymentConfirm', 
                '$confirmationPay', 
                '$date', 
                '$witness', 
                '$notarizeDate', 
                '$locationNota', 
                '$status', 
                '$cert_amount', 
                '$date_of_pickup', 
                '$note',
                '$userid'
            )";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Certificate created successfully.";
            $response['data'] = [
                'id' => mysqli_insert_id($conn), // Return the ID of the new record
            ];
            logAction($conn, "Created land certificate for seller: $sellerName", $_SESSION['user']['username']);
        } else {
            $response['success'] = false;
            $response['message'] = "Error: " . $e->getMessage();
            error_log("Error in certificate creation: " . $e->getMessage());
        }
        break;

    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM land_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Land Certificate data not found.";
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
