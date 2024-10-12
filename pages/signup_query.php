<?php
session_start();
require('../pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $fname = htmlspecialchars($_POST['fname']);
    $mname = htmlspecialchars($_POST['mname']);
    $lname = htmlspecialchars($_POST['lname']);
    $suffix = htmlspecialchars($_POST['suffix']);
    $bday = htmlspecialchars($_POST['date_of_birth']);
    $age = htmlspecialchars($_POST['age']);
    $contact = htmlspecialchars($_POST['contact']);
    $house_no = htmlspecialchars($_POST['house_no']);
    $street = htmlspecialchars($_POST['street']);
    $brgy = htmlspecialchars($_POST['barangay']);
    $municipality = htmlspecialchars($_POST['municipality']);
    $province = htmlspecialchars($_POST['province']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $id_type = htmlspecialchars($_POST['id_type']);

    // Handle file upload if necessary
    $id_file_path = '';
    if (isset($_FILES['id_file']) && $_FILES['id_file']['error'] == 0) {
        $uploadedFile = $_FILES['id_file'];
        $uploadDir = 'uploads/'; // Ensure this directory exists and is writable
        $id_file_path = $uploadDir . basename($uploadedFile['name']);
        
        // Move uploaded file
        if (!move_uploaded_file($uploadedFile['tmp_name'], $id_file_path)) {
            $_SESSION['toastr_message'] = 'File upload failed.';
            $_SESSION['toastr_type'] = 'error';
            header("Location: login.php");
            exit;
        }
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

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['toastr_message'] = 'Username or email already exists.';
        $_SESSION['toastr_type'] = 'error';
        header("Location: login.php");
        exit;
    }

    // Prepare the insert statement
    $insert_query = "INSERT INTO tblregistered_account (fname, mname, lname, suffix, bday, age, contact, houseNo, street, brgy, municipality, province, email, username, password, id_type, id_file, account_type, image) 
                     VALUES ('$fname', '$mname', '$lname', '$suffix', '$bday', '$age', '$contact', '$house_no', '$street', '$brgy', '$municipality', '$province', '$email', '$username', '$hashed_password', '$id_type', '$id_file_path', 1, NULL)";

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
