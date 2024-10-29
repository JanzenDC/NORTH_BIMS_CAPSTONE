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

switch ($action) {
    case 'create':
        $pickupDate = $_POST['pickupDate'] ?? null; // Assume this is sent from the client

        if ($pickupDate) {
            $ownerId = $_SESSION['user']['id']; // Using the session to get the owner ID

            // Fetch information from tblregistered_account
            $sqlFetch = "SELECT fname, mname, lname, age FROM tblregistered_account WHERE id = $ownerId";
            $result = mysqli_query($conn, $sqlFetch);

            if ($result && mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_assoc($result);

                // Prepare to insert into clearance_cert with current date for date_issued
                $sqlInsert = "INSERT INTO clearance_cert (ownerId, fname, mname, lname, age, date_issued, pickup_date, status) 
                              VALUES ($ownerId, '{$account['fname']}', '{$account['mname']}', '{$account['lname']}', '{$account['age']}', CURDATE(), '$pickupDate', 'New')";

                if (mysqli_query($conn, $sqlInsert)) {
                    $response['success'] = true;
                    $response['message'] = "Certificate created successfully.";
                } else {
                    $response['message'] = "Failed to create certificate: " . mysqli_error($conn);
                }
            } else {
                $response['message'] = "Owner not found.";
            }
        } else {
            $response['message'] = "Pickup date is required.";
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
