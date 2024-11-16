<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">

    <!-- SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4379F2, #117554);
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 90%;
            max-width: 400px;
        }

        h1 {
            color: #117554;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
        }

        .email-input {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .email-input:focus {
            border-color: #4379F2;
            outline: none;
        }

        .otp-container {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
            margin: 1.5rem 0;
        }

        .otp-input {
            width: 40px;
            height: 40px;
            text-align: center;
            font-size: 1.2rem;
            border: 2px solid #ddd;
            border-radius: 5px;
        }

        .otp-input:focus {
            border-color: #4379F2;
            outline: none;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:active {
            transform: scale(0.98);
        }

        .submit-btn {
            background-color: #4379F2;
            color: white;
            margin-bottom: 1rem;
        }

        .submit-btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .resend-btn {
            background-color: #6EC207;
            color: white;
        }

        .timer {
            text-align: center;
            color: #666;
            margin-top: 1rem;
        }

        .back-btn {
            background-color: transparent;
            color: #4379F2;
            text-decoration: underline;
            margin-top: 0.5rem;
        }

        .error-message {
            color: #ff0000;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .section {
            display: none;
        }

        .section.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Forgot Password</h1>

        <div id="emailSection" class="section active">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" class="email-input" placeholder="Enter your email">
                <div id="emailError" class="error-message"></div>
            </div>
            <button class="submit-btn" id="sendOtpBtn">Send OTP</button>
            <button class="back-btn" onclick="window.location.href='login.php'">Back to Login</button>
        </div>

        <div id="otpSection" class="section">
            <div class="form-group">
                <label>Enter OTP</label>
                <div class="otp-container">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                    <input type="text" class="otp-input" maxlength="1" pattern="[0-9]">
                </div>
                <div id="otpError" class="error-message"></div>
            </div>
            <button class="submit-btn" id="verifyOtpBtn">Verify OTP</button>
            <button class="resend-btn" id="resendOtpBtn" disabled>Resend OTP</button>
            <div class="timer">Resend in <span id="countdown">30</span>s</div>
            <button class="back-btn" id="otpBackBtn">Back to Email</button>
        </div>

        <div id="passwordSection" class="section">
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" id="newPassword" class="email-input" placeholder="Enter new password">
                <div id="passwordError" class="error-message"></div>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" id="confirmPassword" class="email-input" placeholder="Confirm new password">
                <div id="confirmError" class="error-message"></div>
            </div>
            <button class="submit-btn" id="resetPasswordBtn">Reset Password</button>
            <button class="back-btn" onclick="showSection('otpSection')">Back</button>
        </div>
    </div>

<script>
    let currentEmail = '';
    let timerInterval;

    // Utility functions
    function showSection(sectionId) {
        document.querySelectorAll('.section').forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById(sectionId).classList.add('active');
    }

    function showError(message) {
        swal("Error", message, "error");
    }

    function showSuccess(message) {
        swal("Success", message, "success");
    }

    // Email validation and OTP sending
    document.getElementById('sendOtpBtn').addEventListener('click', async () => {
        const email = document.getElementById('email').value;

        if (!email) {
            showError('Please enter your email address');
            return;
        }

        try {
            const response = await fetch('forgot_pass_bcknd.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email })
            });

            const data = await response.json();
            console.log(data)
            if (data.status === 'success') {
                currentEmail = email;
                showSection('otpSection');
                startTimer();
                showSuccess('OTP sent successfully');
            } else {
                showError(data.message);
            }
        } catch (error) {
            console.log(error)
            showError('An error occurred. Please try again.');
        }
    });

    // OTP input handling
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1) {
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    // OTP verification
    document.getElementById('verifyOtpBtn').addEventListener('click', async () => {
        const otp = Array.from(otpInputs).map(input => input.value).join('');

        if (otp.length !== 6) {
            showError('Please enter the complete OTP');
            return;
        }

        try {
            const response = await fetch('forgot_pass_bcknd.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ otp })
            });

            const data = await response.json();

            if (data.status === 'success') {
                clearInterval(timerInterval);
                showSection('passwordSection');
                showSuccess('OTP verified successfully');
            } else {
                showError(data.message);
            }
        } catch (error) {
            showError('An error occurred. Please try again.');
        }
    });

    // Timer functionality
    function startTimer() {
        let timeLeft = 30;
        const resendBtn = document.getElementById('resendOtpBtn');
        const countdownElement = document.getElementById('countdown');
        
        resendBtn.disabled = true;
        
        clearInterval(timerInterval);
        timerInterval = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;
            
            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                resendBtn.disabled = false;
            }
        }, 1000);
    }

    // Resend OTP
    document.getElementById('resendOtpBtn').addEventListener('click', async () => {
        try {
            const response = await fetch('forgot_pass_bcknd.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: currentEmail })
            });

            const data = await response.json();

            if (data.status === 'success') {
 startTimer();
                Array.from(otpInputs).forEach(input => input.value = '');
                otpInputs[0].focus();
                showSuccess('OTP resent successfully');
            } else {
                showError(data.message);
            }
        } catch (error) {
            showError('An error occurred while resending OTP.');
        }
    });

    // Password reset
    document.getElementById('resetPasswordBtn').addEventListener('click', async () => {
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Validate password
        if (newPassword.length < 8) {
            showError('Password must be at least 8 characters long');
            return;
        }

        if (newPassword !== confirmPassword) {
            showError('Passwords do not match');
            return;
        }

        try {
            const response = await fetch('forgot_pass_bcknd.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    email: currentEmail,
                    newPassword: newPassword
                })
            });

            const data = await response.json();

            if (data.status === 'success') {
                showSuccess('Password reset successful! Redirecting to login page...');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000); // Redirect after 2 seconds
            } else {
                showError(data.message);
            }
        } catch (error) {
            showError('An error occurred while resetting password.');
        }
    });

    // Navigation buttons
    document.getElementById('otpBackBtn').addEventListener('click', () => {
        clearInterval(timerInterval);
        Array.from(otpInputs).forEach(input => input.value = '');
        showSection('emailSection');
    });
</script>
</body>
</html>