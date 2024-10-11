<?php
// Set the redirect location
$redirectLocation = 'pages/login.php';

// Output HTML with fade-in followed by bounce effect
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting...</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #4CAF50; /* Green background */
            font-family: Arial, sans-serif;
            color: white; /* Text color */
        }
        #message {
            opacity: 0; /* Start invisible */
            animation: fadeIn 2s forwards, bounce 0.5s 2s forwards; /* Fade first, then bounce */
            font-size: 24px;
            text-align: center;
        }
        #image {
            max-width: 200px; /* Adjust the size as needed */
            margin-bottom: 20px;
        }
        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1; /* Fully visible */
            }
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px); /* Move up */
            }
            60% {
                transform: translateY(-5px); /* Move down slightly */
            }
        }
    </style>
</head>
<body>
    <img id="image" src="assets/images/north.png" alt="Sample Image">
    <div id="message">Brgy. North Poblacion, Gabaldon, Nueva Ecija
    </div>
    <script>
        // Redirect after 4 seconds (2 seconds for fade + 2 seconds before redirect)
        setTimeout(() => {
            window.location.href = "<?php echo $redirectLocation; ?>";
        }, 4000);
    </script>
</body>
</html>
