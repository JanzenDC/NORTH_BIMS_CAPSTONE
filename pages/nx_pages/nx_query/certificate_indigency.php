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
    case 'create':
        // Existing code for creating a certificate
        $ownerId = $_POST['resident_id'] ?? '';
        
        // Validate the required fields
        if (empty($ownerId)) {
            $response['message'] = "Owner ID is required.";
        } else {
            // Fetch resident details from tblresident
            $query = "SELECT * FROM tblresident WHERE resident_id = '$ownerId'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $resident = mysqli_fetch_assoc($result);

                // Extract resident details
                $fname = $resident['fname'];
                $mname = $resident['mname'];
                $lname = $resident['lname'];
                $age = $resident['age'];
                $bday = $resident['bday'];
                $purok = $resident['purok'];
                $year_stayed = $resident['year_stayed'];
                $status = "Walk-in"; // Example static value
                $amount = $_POST['amount'] ?? '';
                $date_issued = $_POST['date_issued'] ?? '';
                $purpose = $_POST['purpose'] ?? '';
                $pickup = $_POST['pickup'] ?? ''; // Assuming you still need this
                $note = $_POST['note'] ?? '';

                // Validate additional fields
                if (empty($amount) || empty($date_issued) || empty($purpose)) {
                    $response['message'] = "All certificate fields are required.";
                } else {
                    // Escape user input for safety
                    $amount = mysqli_real_escape_string($conn, $amount);
                    $date_issued = mysqli_real_escape_string($conn, $date_issued);
                    $purpose = mysqli_real_escape_string($conn, $purpose);
                    $pickup = mysqli_real_escape_string($conn, $pickup);
                    $note = mysqli_real_escape_string($conn, $note);

                    // Construct SQL query to insert into indigency_cert
                    $sql = "INSERT INTO indigency_cert (ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup, note) 
                            VALUES ('$ownerId', '$fname', '$mname', '$lname', '$age', '$bday', '$purok', '$year_stayed', '$date_issued', '$amount', '$status', '$purpose', '$pickup', '$note')";

                    // Execute query
                    if (mysqli_query($conn, $sql)) {
                        $response['success'] = true;
                        $response['message'] = "Certificate added successfully!";
                        $response['data'] = [
                            'id' => mysqli_insert_id($conn),
                            'ownerId' => $ownerId,
                            'first_name' => $fname,
                            'last_name' => $lname,
                        ];
                    } else {
                        $response['message'] = "Error adding certificate: " . mysqli_error($conn);
                    }
                }
            } else {
                $response['message'] = "Resident not found.";
            }
        }
        break;

    case 'mark_done':
        // Retrieve the certificate ID from POST request
        $id = $_POST['id'] ?? '';

        // Validate the ID
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            // Update the status of the certificate to 'Done'
            $sql = "UPDATE indigency_cert SET status = 'Done' WHERE id = '$id'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate marked as done successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . mysqli_error($conn);
            }
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
