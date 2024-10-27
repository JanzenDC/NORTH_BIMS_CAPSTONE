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

switch ($action) {
    case 'get':
        // Read
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM indigency_cert WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $official = mysqli_fetch_assoc($result);
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Health Worker not found.";
        }
        break;

    case 'create':
        // Create a certificate
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
                $pickup = $_POST['pickup'] ?? '';
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
                        logAction($conn, "Created certificate for resident ID $ownerId", $_SESSION['user']['username']);
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
        // Mark certificate as done
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
                    logAction($conn, "Marked certificate ID $id as done", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . mysqli_error($conn);
            }
        }
        break;

    case 'updateApprove':
        // Update certificate details
        $id = $_POST['id'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $date_issued = $_POST['date_issued'] ?? '';
        $purpose = $_POST['purposes'] ?? ''; // Using 'purposes' as per your JavaScript

        // Validate required fields
        if (empty($id) || empty($amount) || empty($date_issued) || empty($purpose)) {
            $response['message'] = "Certificate ID, Amount, Date Issued, and Purpose are required.";
        } else {
            // Escape user input for safety
            $amount = mysqli_real_escape_string($conn, $amount);
            $date_issued = mysqli_real_escape_string($conn, $date_issued);
            $purpose = mysqli_real_escape_string($conn, $purpose);

            // Construct SQL query to update indigency_cert
            $sql = "UPDATE indigency_cert SET 
                    amount='$amount', 
                    date_issued='$date_issued', 
                    purpose='$purpose' 
                    WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate updated successfully!";
                    logAction($conn, "Updated certificate ID $id", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . mysqli_error($conn);
            }
        }
        break;

    case 'updateNote':
        // Update the note for the certificate
        $id = $_POST['id'] ?? '';
        $note = $_POST['note'] ?? '';

        // Validate required fields
        if (empty($id) || empty($note)) {
            $response['message'] = "Certificate ID and Note are required.";
        } else {
            // Escape user input for safety
            $note = mysqli_real_escape_string($conn, $note);

            // Construct SQL query to update the note in indigency_cert
            $sql = "UPDATE indigency_cert SET note='$note' WHERE id='$id'";

            if (mysqli_query($conn, $sql)) {
                if (mysqli_affected_rows($conn) > 0) {
                    $response['success'] = true;
                    $response['message'] = "Note updated successfully!";
                    logAction($conn, "Updated note for certificate ID $id", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating note: " . mysqli_error($conn);
            }
        }
        break;

    case 'setAsApprove':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as approved.";
            break;
        }

        // Construct the SQL query to update the status to "Approved"
        $query = "UPDATE indigency_cert SET status = 'Approved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
            logAction($conn, "Approved certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'setDisapproved':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as disapproved.";
            break;
        }

        // Construct the SQL query to update the status to "Disapproved"
        $query = "UPDATE indigency_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
            logAction($conn, "Disapproved certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
