<?php
session_start();
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "north"; // Replace with your actual database name

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

// Handle the POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Password reset process
    if (isset($data['email']) && isset($data['newPassword'])) {
        $email = $data['email'];
        $newPassword = $data['newPassword'];

        // Check if the email exists in the database
        $sql = "SELECT id FROM tblregistered_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email exists, check if OTP is verified
            if (isset($_SESSION['otp_email']) && $_SESSION['otp_email'] === $email && $_SESSION['otp_verified'] === true) {
                // OTP verified, update password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateSql = "UPDATE tblregistered_account SET password = ? WHERE email = ?";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bind_param("ss", $hashedPassword, $email);

                if ($updateStmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Password successfully updated.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update password.']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'OTP not verified or expired.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not registered.']);
        }

        $conn->close();
    }

    // Send OTP process
    elseif (isset($data['email'])) {
        $email = $data['email'];

        // Check if the email exists in the database
        $sql = "SELECT id FROM tblregistered_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email exists, fetch user_id
            $row = $result->fetch_assoc();
            $user_id = $row['id'];

            // Generate OTP
            $otp = rand(100000, 999999);
            sendOtpEmail($email, $otp);
            // Check if there's already an OTP record for this user_id
            $checkOtpSql = "SELECT id FROM tbl_otp WHERE user_id = ? AND email = ?";
            $checkOtpStmt = $conn->prepare($checkOtpSql);
            $checkOtpStmt->bind_param("is", $user_id, $email);
            $checkOtpStmt->execute();
            $checkOtpResult = $checkOtpStmt->get_result();

            if ($checkOtpResult->num_rows > 0) {
                // Record exists, update OTP
                $updateOtpSql = "UPDATE tbl_otp SET otp = ?, is_verified = 0 WHERE user_id = ? AND email = ?";
                $updateOtpStmt = $conn->prepare($updateOtpSql);
                $updateOtpStmt->bind_param("iis", $otp, $user_id, $email);

                if ($updateOtpStmt->execute()) {
                    // OTP successfully updated
                    $_SESSION['otp_email'] = $email;
                    $_SESSION['otp'] = $otp;
                    $_SESSION['otp_verified'] = false; // OTP not verified yet

                    // Send OTP email
                    sendOtpEmail($email, $otp); // Function to send OTP via email

                    echo json_encode(['status' => 'success', 'message' => 'OTP updated and sent successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update OTP']);
                }
            } else {
                // No record exists, insert new OTP
                $insertOtpSql = "INSERT INTO tbl_otp (user_id, email, otp) VALUES (?, ?, ?)";
                $insertStmt = $conn->prepare($insertOtpSql);
                $insertStmt->bind_param("isi", $user_id, $email, $otp);
                sendOtpEmail($email, $otp);
                if ($insertStmt->execute()) {
                    // OTP successfully inserted
                    $_SESSION['otp_email'] = $email;
                    $_SESSION['otp'] = $otp;
                    $_SESSION['otp_verified'] = false; // OTP not verified yet

                    // Send OTP email
                    sendOtpEmail($email, $otp); // Function to send OTP via email

                    echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to store OTP']);
                }
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not registered.']);
        }

        $conn->close();
    }

    // OTP verification process
    elseif (isset($data['otp'])) {
        $otp = $data['otp'];
        $email = $_SESSION['otp_email'];

        // Verify OTP
        $sql = "SELECT * FROM tbl_otp WHERE email = ? AND otp = ? AND is_verified = 0";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // OTP is correct, update the is_verified flag
            $updateOtpSql = "UPDATE tbl_otp SET is_verified = 1 WHERE email = ? AND otp = ?";
            $updateOtpStmt = $conn->prepare($updateOtpSql);
            $updateOtpStmt->bind_param("si", $email, $otp);
            if ($updateOtpStmt->execute()) {
                // Mark OTP as verified in session
                $_SESSION['otp_verified'] = true;
                echo json_encode(['status' => 'success', 'message' => 'OTP verified successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to verify OTP']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
        }
    }
}

function sendOtpEmail($email, $otp) {
    $apiKey = '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';  // Replace with your actual API key

    $url = 'https://api.brevo.com/v3/smtp/email';
    $headers = [
        'Content-Type: application/json',
        'api-key: ' . $apiKey,
    ];

    $data = [
        'sender' => ['email' => 'northpoblaciongab@gmail.com'],
        'to' => [['email' => $email]],
        'subject' => 'Your OTP Code',
        'htmlContent' => '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; color: #333; background-color: #f9f9f9; padding: 20px; text-align: center; }
                    .email-container { background-color: #ffffff; border-radius: 10px; padding: 30px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); width: 100%; max-width: 500px; margin: 0 auto; text-align: center; }
                    h3 { color: #4CAF50; font-size: 24px; margin-bottom: 20px; }
                    .otp { font-size: 36px; font-weight: bold; color: #333; letter-spacing: 2px; padding: 10px; background-color: #f1f1f1; border: 2px solid #ddd; border-radius: 5px; display: inline-block; margin-bottom: 20px; }
                    p { font-size: 16px; color: #666; }
                    .footer { font-size: 12px; color: #888; margin-top: 20px; }
                    .footer a { color: #4CAF50; text-decoration: none; }
                </style>
            </head>
            <body>
                <div class="email-container">
                    <h3>Here is your OTP Code</h3>
                    <div class="otp">' . $otp . '</div>
                    <p>This is a one-time code that will expire in 10 minutes. Please enter it on the website to proceed with your request.</p>
                    <p>If you did not request this code, please ignore this email.</p>
                    <div class="footer">
                        <p>Best regards, <br> NORTH-BIMS Development Team</p>
                        <p><a href="https://example.com">Visit our website</a></p>
                    </div>
                </div>
            </body>
            </html>
        ',
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    curl_close($ch);
}
?>
