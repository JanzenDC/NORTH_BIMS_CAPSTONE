<?php
session_start();
require('../pages/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['username']; // Username or email
    $password = $_POST['password'];

    // Check if the input is an email
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $query = "SELECT * FROM tblregistered_account WHERE email = '$login'";
    } else {
        $query = "SELECT * FROM tblregistered_account WHERE username = '$login'";
    }

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query Failed: ' . mysqli_error($conn));
    }

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        $hashed_password = $user['password'];

        if (password_verify($password, $hashed_password)) {
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
                'isAdmin' => $user['isAdmin'],
                'isApproved' => $user['isApproved'],
            ];

            // Check if user is approved to access the dashboard
            if ($_SESSION['user']['isApproved'] == '1') {
                // Redirect based on admin level and account type
                if ($_SESSION['user']['isAdmin'] == '2') {
                    // Superadmin dashboard
                    header("Location: nx_pages/dashboard.php");
                } elseif ($_SESSION['user']['isAdmin'] == '1') {
                    // Admin dashboard
                    header("Location: nx_pages/dashboard.php");
                } elseif ($_SESSION['user']['account_type'] == '1') {
                    // Resident dashboard
                    header("Location: nx_residentpage/res_Dashboard.php");
                } else {
                    // Non-resident dashboard
                    header("Location: nx_nonresident/res_Dashboard.php");
                }
                exit;
            } else {
                $_SESSION['toastr_message'] = 'Account is not approved. Please contact support.';
                $_SESSION['toastr_type'] = 'warning';
            }
        } else {
            $_SESSION['toastr_message'] = 'Invalid username or password.';
            $_SESSION['toastr_type'] = 'error';
        }
    } else {
        $_SESSION['toastr_message'] = 'Invalid username or password.';
        $_SESSION['toastr_type'] = 'error';
    }

    // Redirect back to login page if login fails
    header("Location: login.php");
    exit;
}

mysqli_close($conn);
?>
