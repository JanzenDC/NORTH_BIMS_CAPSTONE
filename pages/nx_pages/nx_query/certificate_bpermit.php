<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require 'vendor/autoload.php';
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
        $sql = "INSERT INTO business_cert (owner_fname, owner_mname, owner_lname, owner_suffix, businessName, typeOfBusiness, businessAddress, street, barangay, municipality, province, date_issued, amount, status, cert_amount, date_of_pickup, note) 
                VALUES ('$owner_fname', '$owner_mname', '$owner_lname', '$owner_suffix', '$businessName', '$typeOfBusiness', '$businessAddress', '$street', '$barangay', '$municipality', '$province', '$date_issued', '$amount', '$status', '$cert_amount', '$date_of_pickup', '$note')";

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

    case 'mark_done':
        // Mark certificate as done
        $id = $_POST['id'] ?? '';

        // Validate the ID
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            // Update the status of the certificate to 'Done'
            $sql = "UPDATE business_cert SET status = 'Done' WHERE id = '$id'";

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

    case 'setApproved':
        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as approved.";
            break;
        }

        // Retrieve the ownerid from business_cert
        $ownerQuery = "SELECT ownerid FROM business_cert WHERE id = $id";
        $ownerResult = mysqli_query($conn, $ownerQuery);

        if ($ownerResult && mysqli_num_rows($ownerResult) > 0) {
            $ownerData = mysqli_fetch_assoc($ownerResult);
            $ownerid = $ownerData['ownerid'];

            // Check if the ownerid is valid (not zero)
            if ($ownerid != 0) {
                // Fetch the resident_id and contact from tblregistered_account
                $contactQuery = "SELECT * FROM tblregistered_account WHERE id = $ownerid";
                $contactResult = mysqli_query($conn, $contactQuery);

                if ($contactResult && mysqli_num_rows($contactResult) > 0) {
                    $contactData = mysqli_fetch_assoc($contactResult);
                    $contactNumber = $contactData['contact'];

                    // Construct the SQL query to update the status to "Approved"
                    $query = "UPDATE business_cert SET status = 'Approved' WHERE id = $id";

                    // Execute the query
                    if (mysqli_query($conn, $query)) {
                        $response['success'] = true;
                        $response['message'] = "Record marked as Approved successfully.";
                        logAction($conn, "Approved certificate ID $id", $_SESSION['user']['username']);

                        $telerivetApiKey = 'H_RkO_uw1HficmdKffr9OWNG1s2Isd8sP5S2';
                        $projectId = 'PJ3d74c709991602b6';
                        $message = "Your certificate has been approved.";

                        try {
                            $api = new Telerivet_API($telerivetApiKey);
                            $project = $api->initProjectById($projectId);
                            $project->sendMessage([
                                'to_number' => $userPhone,
                                'content' => $message
                            ]);
                            $response['message'] = "SMS sent successfully.";
                        } catch (Exception $e) {
                            $response['message'] = "Error sending SMS: " . $e->getMessage();
                        }

                    } else {
                        $response['message'] = "Error updating record: " . mysqli_error($conn);
                    }
                } else {
                    $response['message'] = "No contact found for owner ID $ownerid.";
                }
            } else {
                $response['message'] = "Owner ID is zero, not sending Telerivet message.";
            }
        } else {
            $response['message'] = "No owner found for certificate ID $id.";
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
        $query = "UPDATE business_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
            logAction($conn, "Disapproved certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;

    case 'updateInfo':
        // Update certificate details
        $id = $_POST['id'] ?? '';
        $businessName = mysqli_real_escape_string($conn, $_POST['businessName'] ?? '');
        $address = mysqli_real_escape_string($conn, $_POST['address'] ?? '');
        $typeOfBusiness = mysqli_real_escape_string($conn, $_POST['typeOfBusiness'] ?? '');
        $certAmount = mysqli_real_escape_string($conn, $_POST['certAmount'] ?? '');

        // Prepare the SQL query to update the record
        $sql = "UPDATE business_cert SET businessName='$businessName', businessAddress='$address', typeOfBusiness='$typeOfBusiness', cert_amount='$certAmount' WHERE id='$id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                $response['success'] = true;
                $response['message'] = 'Certificate updated successfully!';
                logAction($conn, "Updated certificate ID $id", $_SESSION['user']['username']);
            } else {
                $response['message'] = 'No record found with that ID.';
            }
        } else {
            $response['message'] = 'Failed to update certificate: ' . mysqli_error($conn);
        }

        break;

    case 'updateNote':
        // Update note for the certificate
        $id = $_POST['id'] ?? '';
        $note = mysqli_real_escape_string($conn, $_POST['note'] ?? '');

        // Prepare the SQL query to update the note
        $sql = "UPDATE business_cert SET note='$note' WHERE id='$id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                $response['success'] = true;
                $response['message'] = 'Note updated successfully!';
                logAction($conn, "Updated note for certificate ID $id", $_SESSION['user']['username']);
            } else {
                $response['message'] = 'No record found with that ID.';
            }
        } else {
            $response['message'] = 'Failed to update note: ' . mysqli_error($conn);
        }

        break;

    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
