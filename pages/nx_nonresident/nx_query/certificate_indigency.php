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
$userID = $_SESSION['user']['id'];

switch ($action) {
    case 'create':
        // Get data from the POST request
        $yearResidence = $_POST['year_residence'] ?? null;
        $dateIssued = $_POST['date_issued'] ?? null;

        if ($yearResidence && $dateIssued) {
            // Fetch the user details to populate the certificate
            $sqlFetch = "SELECT fname, mname, lname, age, bday FROM tblregistered_account WHERE id = $userID";
            $result = mysqli_query($conn, $sqlFetch);

            if ($result && mysqli_num_rows($result) > 0) {
                $account = mysqli_fetch_assoc($result);

                // Prepare to insert into indigency_cert
                $sqlInsert = "INSERT INTO indigency_cert (ownerId, fname, mname, lname, age, bday, year_stayed, date_issued, amount, status, purpose, pickup, note) 
                              VALUES ($userID, '{$account['fname']}', '{$account['mname']}', '{$account['lname']}', '{$account['age']}', '{$account['bday']}', '$yearResidence', '$dateIssued', '0', 'New', '', '', '')";

                if (mysqli_query($conn, $sqlInsert)) {
                    $response['success'] = true;
                    $response['message'] = "Indigency certificate created successfully.";
                } else {
                    $response['message'] = "Failed to create certificate: " . mysqli_error($conn);
                }
            } else {
                $response['message'] = "Owner not found.";
            }
        } else {
            $response['message'] = "All fields are required.";
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
