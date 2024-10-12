<?php
require('db_connect.php');

$conn = db_connect();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check if the user exists
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Verify password (assuming you are using hashed passwords)
        if (password_verify($password, $user['password'])) {
            // Start session
            session_start();

            // Store user information in session array
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
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }
}

// Close the connection
mysqli_close($conn);
?>
