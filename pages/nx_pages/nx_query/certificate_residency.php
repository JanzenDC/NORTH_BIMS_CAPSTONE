<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');
require 'vendor/autoload.php';
require "../../db_connect.php"; // Ensure this file establishes a MySQLi connection

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

switch ($action) {
    case 'get':
        $id = (int)$_GET['id'];
        $stmt = $conn->prepare("SELECT * FROM residency_cert WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $official = $result->fetch_assoc();
        
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Health Worker not found.";
        }
        break;

    case 'create':
        $ownerId = $_POST['resident_id'] ?? '';

        if (empty($ownerId)) {
            $response['message'] = "Owner ID is required.";
        } else {
            $stmt = $conn->prepare("SELECT * FROM tblresident WHERE resident_id = ?");
            $stmt->bind_param("s", $ownerId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $resident = $result->fetch_assoc();
                
                // Extract resident details
                $fname = $resident['fname'];
                $mname = $resident['mname'];
                $lname = $resident['lname'];
                $age = $resident['age'];
                $bday = $resident['bday'];
                $purok = $resident['purok'];
                $year_stayed = $resident['year_stayed'];
                $status = "Walk-in"; // Static value
                $amount = $_POST['amount'] ?? '';
                $date_issued = $_POST['date_issued'] ?? '';
                $purpose = $_POST['purpose'] ?? '';
                $pickup = $_POST['pickup'] ?? '';
                $note = $_POST['note'] ?? '';

                if (empty($amount) || empty($date_issued) || empty($purpose) || empty($pickup)) {
                    $response['message'] = "All certificate fields are required.";
                } else {
                    // Prepare and execute the insert statement
                    $stmt = $conn->prepare("INSERT INTO residency_cert (ownerId, fname, mname, lname, age, bday, purok, year_stayed, date_issued, amount, status, purpose, pickup_date, note) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssssssisss", $ownerId, $fname, $mname, $lname, $age, $bday, $purok, $year_stayed, $date_issued, $amount, $status, $purpose, $pickup, $note);

                    if ($stmt->execute()) {
                        $response['success'] = true;
                        $response['message'] = "Certificate added successfully!";
                        $response['data'] = [
                            'id' => $stmt->insert_id,
                            'ownerId' => $ownerId,
                            'first_name' => $fname,
                            'last_name' => $lname,
                        ];
                        logAction($conn, "Created residency certificate for owner ID $ownerId", $_SESSION['user']['username']);
                    } else {
                        $response['message'] = "Error adding certificate: " . $stmt->error;
                    }
                }
            } else {
                $response['message'] = "Resident not found.";
            }
        }
        break;

    case 'mark_done':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            $stmt = $conn->prepare("UPDATE residency_cert SET status = 'Done' WHERE id = ?");
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate marked as done successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . $stmt->error;
            }
        }
        break;

    case 'updateApprove':
        $id = $_POST['id'] ?? '';
        $amount = $_POST['amount'] ?? '';
        $date_issued = $_POST['date_issued'] ?? '';
        $purpose = $_POST['purposes'] ?? '';

        if (empty($id) || empty($amount) || empty($date_issued) || empty($purpose)) {
            $response['message'] = "Certificate ID, Amount, Date Issued, and Purpose are required.";
        } else {
            $stmt = $conn->prepare("UPDATE residency_cert SET amount = ?, date_issued = ?, purpose = ? WHERE id = ?");
            $stmt->bind_param("sssi", $amount, $date_issued, $purpose, $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate updated successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . $stmt->error;
            }
        }
        break;

    case 'updateNote':
        $id = $_POST['id'] ?? '';
        $note = $_POST['note'] ?? '';

        if (empty($id) || empty($note)) {
            $response['message'] = "Certificate ID and Note are required.";
        } else {
            $stmt = $conn->prepare("UPDATE residency_cert SET note = ? WHERE id = ?");
            $stmt->bind_param("si", $note, $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Note updated successfully!";
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating note: " . $stmt->error;
            }
        }
        break;

case 'setAsApprove':
    // Get ID from POST request and validate
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    if ($id <= 0) {
        $response['message'] = "Valid ID is required to set the record as approved.";
        break;
    }

    // Query to get the owner ID from residency_cert
    $ownerQuery = "SELECT ownerId FROM residency_cert WHERE id = $id";
    $ownerResult = mysqli_query($conn, $ownerQuery);

    if ($ownerResult && mysqli_num_rows($ownerResult) > 0) {
        $ownerData = mysqli_fetch_assoc($ownerResult);
        $ownerid = $ownerData['ownerId'];

        // Query to fetch contact details from tblregistered_account
        $contactQuery = "SELECT contact FROM tblregistered_account WHERE id = $ownerid";
        $contactResult = mysqli_query($conn, $contactQuery);

        if ($contactResult && mysqli_num_rows($contactResult) > 0) {
            $contactData = mysqli_fetch_assoc($contactResult);
            $contactNumber = $contactData['contact'];

            // Update the status of the record to 'Approved'
            $updateQuery = "UPDATE residency_cert SET status = 'Approved' WHERE id = $id";
            if (mysqli_query($conn, $updateQuery)) {
                $response['success'] = true;
                $response['message'] = "Record marked as Approved successfully.";


                // Send SMS via Telerivet
                $telerivetApiKey = 'H_RkO_06nvYxPfDda3r949iavvgJtEc0ZnBW';
                $projectId = 'PJ3d74c709991602b6';
                $message = "Your account has been approved.";

                try {
                    $api = new Telerivet_API($telerivetApiKey);
                    $project = $api->initProjectById($projectId);
                    $apiResponse = $project->sendMessage([
                        'to_number' => $contactNumber,
                        'content' => $message
                    ]);

                    if ($apiResponse->success) {
                        $response['message'] .= " Notification sent successfully.";
                    } else {
                        $response['message'] .= " Notification failed to send.";
                    }
                } catch (Exception $e) {
                    $response['message'] .= " Telerivet error: " . $e->getMessage();
                }
            } else {
                $response['message'] = "Error updating record: " . mysqli_error($conn);
            }
        } else {
            $response['message'] = "No contact found for owner ID $ownerid.";
        }
    } else {
        $response['message'] = "No owner found for certificate ID $id.";
    }
    break;



    case 'setDisapproved':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as disapproved.";
            break;
        }
        $stmt = $conn->prepare("UPDATE residency_cert SET status = 'Disapproved' WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        break;

    default:
        $response['message'] = "Invalid action.";
}

echo json_encode($response);
mysqli_close($conn);
?>
