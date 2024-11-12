<?php
session_start();
require('../pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data and sanitize using mysqli_real_escape_string()
    $fname = !empty($_POST['fname']) ? mysqli_real_escape_string($conn, $_POST['fname']) : null;
    $mname = !empty($_POST['mname']) ? mysqli_real_escape_string($conn, $_POST['mname']) : null;
    $lname = !empty($_POST['lname']) ? mysqli_real_escape_string($conn, $_POST['lname']) : null;
    $suffix = !empty($_POST['suffix']) ? mysqli_real_escape_string($conn, $_POST['suffix']) : null;
    $bday = !empty($_POST['date_of_birth']) ? mysqli_real_escape_string($conn, $_POST['date_of_birth']) : null;
    $age = !empty($_POST['age']) ? mysqli_real_escape_string($conn, $_POST['age']) : null;
    $contact = !empty($_POST['contact']) ? mysqli_real_escape_string($conn, $_POST['contact']) : null;
    $house_no = !empty($_POST['house_no']) ? mysqli_real_escape_string($conn, $_POST['house_no']) : null;
    $street = !empty($_POST['street']) ? mysqli_real_escape_string($conn, $_POST['street']) : null;
    $brgy = !empty($_POST['barangay']) ? mysqli_real_escape_string($conn, $_POST['barangay']) : null;
    $municipality = !empty($_POST['municipality']) ? mysqli_real_escape_string($conn, $_POST['municipality']) : null;
    $province = !empty($_POST['province']) ? mysqli_real_escape_string($conn, $_POST['province']) : null;
    $email = !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
    $username = !empty($_POST['username']) ? mysqli_real_escape_string($conn, $_POST['username']) : null;
    $password = !empty($_POST['password_holder']) ? mysqli_real_escape_string($conn, $_POST['password_holder']) : null;
    $id_type = !empty($_POST['id_type']) ? mysqli_real_escape_string($conn, $_POST['id_type']) : null;
    $registration_status = !empty($_POST['registration_status']) ? mysqli_real_escape_string($conn, $_POST['registration_status']) : null;

    // Handle file upload if necessary
    $id_file_name = null;
    if (isset($_FILES['id_file']) && $_FILES['id_file']['error'] == 0) {
        $uploadedFile = $_FILES['id_file'];
        $uploadDir = '../assets/images/id/';
        $uniqueName = uniqid('id_', true) . '.' . pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
        $id_file_path = $uploadDir . $uniqueName;

        // Move uploaded file
        if (!move_uploaded_file($uploadedFile['tmp_name'], $id_file_path)) {
            $_SESSION['toastr_message'] = 'File upload failed.';
            $_SESSION['toastr_type'] = 'error';
            header("Location: login.php");
            exit;
        }

        // Store just the unique file name in the database, not the full path
        $id_file_name = $uniqueName;
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if username or email already exists
    $check_query = "SELECT * FROM tblregistered_account WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (!$check_result) {
        $_SESSION['toastr_message'] = 'Database query failed: ' . mysqli_error($conn);
        $_SESSION['toastr_type'] = 'error';
        header("Location: login.php");
        exit;
    }

    // If any result is found, it means the username or email already exists
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['toastr_message'] = 'Username or email already exists.';
        $_SESSION['toastr_type'] = 'error';
        header("Location: login.php");
        exit;
    }

    // Prepare the insert statement
    $insert_query = "INSERT INTO tblregistered_account 
                     (fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image) 
                     VALUES 
                     ('$fname', '$mname', '$lname', '$suffix', '$bday', '$age', '$contact', '$house_no', '$street', '$brgy', '$municipality', '$province', '$email', '$username', '$hashed_password', '$id_type', '$id_file_name', '$registration_status', 'default.png')";

    // Execute the insert statement
    if (mysqli_query($conn, $insert_query)) {
        $_SESSION['toastr_message'] = 'Registration successful!';
        $_SESSION['toastr_type'] = 'success';
        header("Location: login.php");
        exit;
    } else {
        $_SESSION['toastr_message'] = 'Registration failed: ' . mysqli_error($conn);
        $_SESSION['toastr_type'] = 'error';
        header("Location: login.php");
        exit;
    }

    // Close the connection
    mysqli_close($conn);
} else {
    echo "Invalid request method.";
}

?>
