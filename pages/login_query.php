<?php
session_start();
require('../pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM tblregistered_account WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query Failed: ' . mysqli_error($conn));
    }

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashed_password = $user['password']; // Correctly fetched

        if (password_verify($password, $hashed_password)) { // Removed strtolower
            $_SESSION['user'] = [
                'id' => $user['id'],
                'fname' => $user['fname'],
                'mname' => $user['mname'],
                'lname' => $user['lname'],
                'suffix' => $user['suffix'],
                'bday' => $user['bday'],
                'age' => $user['age'],
                'contact' => $user['contact'],
                'houseNo' => $user['houseNo'],
                'street' => $user['street'],
                'brgy' => $user['brgy'],
                'municipality' => $user['municipality'],
                'province' => $user['province'],
                'email' => $user['email'],
                'username' => $user['username'],
                'id_type' => $user['id_type'],
                'id_file' => $user['id_file'],
                'account_type' => $user['account_type'],
                'image' => $user['image'],
                'gender' => $user['gender'],
            ];
            header("Location: nx_pages/dashboard.php");
            exit;
        } else {
            $_SESSION['toastr_message'] = 'Invalid username or password.';
            $_SESSION['toastr_type'] = 'error';
        }
    } else {
        $_SESSION['toastr_message'] = 'Invalid username or password.';
        $_SESSION['toastr_type'] = 'error';
    }

    header("Location: login.php");
    exit;
}

mysqli_close($conn);
?>
