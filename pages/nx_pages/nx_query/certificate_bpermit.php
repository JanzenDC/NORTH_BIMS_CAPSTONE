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

        // Validate required fields
        if (empty($owner_fname) || empty($owner_lname) || empty($businessName) || empty($businessAddress) || empty($date_issued)) {
            $response['message'] = 'Please fill in all required fields.';
            echo json_encode($response);
            exit;
        }

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
            $response['message'] = "ID is required to set the record as done.";
            break;
        }

        // Construct the SQL query to update the status to "Done"
        $query = "UPDATE business_cert SET status = 'Approved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
        } else {
            $response['message'] = "Error: " . mysqli_error($conn);
        }
        break;
    case 'setDisapproved':
                        // Get ID from the POST request
        $id = $_POST['id'] ?? '';

        // Check if ID is provided
        if (empty($id)) {
            $response['message'] = "ID is required to set the record as done.";
            break;
        }

        // Construct the SQL query to update the status to "Done"
        $query = "UPDATE business_cert SET status = 'Disapproved' WHERE id = $id";

        // Execute the query
        if (mysqli_query($conn, $query)) {
            $response['success'] = true;
            $response['message'] = "Record marked as Approved successfully.";
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

        // Validate required fields
        if (empty($id) || empty($businessName) || empty($address) || empty($typeOfBusiness) || empty($certAmount)) {
            $response['message'] = 'Please fill in all required fields.';
            echo json_encode($response);
            exit;
        }

        // Prepare the SQL query to update the record
        $sql = "UPDATE business_cert SET businessName='$businessName', businessAddress='$address', typeOfBusiness='$typeOfBusiness', cert_amount='$certAmount' WHERE id='$id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            if (mysqli_affected_rows($conn) > 0) {
                $response['success'] = true;
                $response['message'] = 'Certificate updated successfully!';
            } else {
                $response['message'] = 'No record found with that ID.';
            }
        } else {
            $response['message'] = 'Failed to update certificate: ' . mysqli_error($conn);
        }

        break;
    default:
        $response['message'] = "Invalid action.";
}

// Return JSON response
echo json_encode($response);
mysqli_close($conn);
?>
