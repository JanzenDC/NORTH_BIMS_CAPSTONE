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
    case 'delete':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to delete the record.";
        } else {
            $query = "DELETE FROM livestock_cert WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Record deleted successfully.";
                    logAction($conn, "Deleted livestock certificate ID $id", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error deleting record: " . $stmt->error;
            }
        }
        break;

    case 'updateNote':
        $id = $_POST['id'] ?? '';
        $note = $_POST['note'] ?? '';
        if (empty($id) || empty($note)) {
            $response['message'] = "Certificate ID and Note are required.";
        } else {
            $note = mysqli_real_escape_string($conn, $note);
            $sql = "UPDATE livestock_cert SET note=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $note, $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Note updated successfully!";
                    logAction($conn, "Updated note for livestock certificate ID $id", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating note: " . $stmt->error;
            }
        }
        break;

    case 'get':
        $id = (int)$_GET['id'];
        $query = "SELECT * FROM livestock_cert WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $official = $result->fetch_assoc();
        if ($official) {
            $response['success'] = true;
            $response['data'] = $official;
        } else {
            $response['message'] = "Livestock not found.";
        }
        break;

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
        $status = "Walk-In";

        // Construct the SQL query to insert the new record
        $query = "INSERT INTO livestock_cert 
            (sellerName, sellerAddress, buyerName, buyerAddress, itemSold, 
            quantity, age, sex, amount, amount_words, transacDate, cowlicks, 
            brandMun, brandOwn, cert_amount, date_of_pickup, status, note)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssiisssssssssdsss", $sellerName, $sellerAddress, $buyerName, $buyerAddress, 
            $itemSold, $quantity, $age, $sex, $amount, $amountInWords, 
            $transactionDate, $cowlicks, $brandOfMunicipality, $brandOfOwner, 
            $certificateAmount, $dateOfPickup, $status, $note);

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

    case 'setAsApprove':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as approved.";
            break;
        }
        $query = "UPDATE livestock_cert SET status = 'Approved' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
            logAction($conn, "Approved livestock certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        break;

    case 'setDisapproved':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as disapproved.";
            break;
        }
        $query = "UPDATE livestock_cert SET status = 'Disapproved' WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Record marked as Disapproved successfully.";
            logAction($conn, "Disapproved livestock certificate ID $id", $_SESSION['user']['username']);
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }
        break;

    case 'mark_done':
        $id = $_POST['id'] ?? '';
        if (empty($id)) {
            $response['message'] = "Certificate ID is required.";
        } else {
            $sql = "UPDATE livestock_cert SET status = 'Done' WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = "Certificate marked as done successfully!";
                    logAction($conn, "Marked livestock certificate ID $id as done", $_SESSION['user']['username']);
                } else {
                    $response['message'] = "No record found with that ID.";
                }
            } else {
                $response['message'] = "Error updating certificate: " . $stmt->error;
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
