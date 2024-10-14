<?php
session_start();
require '../db_connect.php';
$currentPage = 'user_profile'; 
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php"); // Redirect to login if not logged in
    exit();
}

$user = $_SESSION['user'];


// Fetch user data from the database using the user ID from the session
$userId = $user['id']; // Assuming user ID is stored in the session
$sql = "SELECT * FROM tblregistered_account WHERE id = $userId";
$result = $conn->query($sql);

// Check if user data was retrieved
if ($result->num_rows > 0) {
    $userData = $result->fetch_assoc();
}
$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($user['username']) ?> | Profile</title>
    <?php 
        include_once "../headers.php";
    ?>
    <style>
        .tab-button {
            padding: 10px 15px;
            border: 2px solid transparent; /* Default border */
            border-radius: 0.375rem; /* Rounded corners */
            background-color: transparent; /* Background color */
            color: #4A5568; /* Text color */
            font-semibold; /* Font weight */
            cursor: pointer; /* Pointer cursor */
            transition: background-color 0.2s, border-color 0.2s; /* Transition effects */
        }

        .tab-button.active {
            border-color: #4A90E2; /* Active border color */
            background-color: #E2F0FF; /* Active background color */
            color: #1E3A8A; /* Active text color */
        }

    </style>
</head>
<body class="bg-gray-100 overflow-hidden">
    <?php
        include_once("../navbar.php");
    ?>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>

        <!-- Main Content -->
        <main class="flex-1 p-6 max-h-screen">
            <div class="md:flex md:gap-4 md:h-screen">
            <div class="w-full md:w-1/4 h-full bg-white drop-shadow-md rounded-md p-6 relative">
                <input type="file" id="profileImageInput" accept="image/*" class="hidden" onchange="handleImageUpload(event)">
                <img class="w-[130px] rounded-full border-2 border-gray-300 mx-auto cursor-pointer" 
                    src="../../assets/images/pfp/<?= htmlspecialchars($userData['image']) ?>" 
                    alt="Profile Photo" 
                    onclick="document.getElementById('profileImageInput').click();">
                <div class="text-center"><?= htmlspecialchars($userData['fname']) ?> <?= htmlspecialchars($userData['mname']) ?> <?= htmlspecialchars($userData['lname']) ?></div>
                <p class="text-center"><strong>Your Profile</strong></p>
                <div class="p-2 flex gap-2 items-center justify-center">
                    <div class="bg-green-600 text-white p-2 rounded-lg cursor-pointer" onclick="openModal()">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                    </div>

                </div>
            </div>


                <div class="w-full md:w-3/4 h-full">
                    <!-- Personal Information Card -->
                    <div class="w-full bg-white shadow-lg md:rounded-lg overflow-hidden  grid grid-cols-[auto,1fr]">

                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Personal Information</h2>
                            <p><strong>Birthday:</strong> <?= htmlspecialchars($userData['bday']) ?></p>
                            <p><strong>Gender:</strong> <?= $userData['gender'] == 1 ? 'Male' : 'Female' ?></p>
                            <p><strong>Age:</strong> <?= htmlspecialchars($userData['age']) ?></p>

                        </div>
                    </div>

                    <!-- Contact Details Card -->
                    <div class="bg-white shadow-lg md:rounded-lg overflow-hidden md:my-6 grid grid-cols-[auto,1fr]">

                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Contact Details</h2>
                            <p><strong>Email:</strong> <?= htmlspecialchars($userData['email']) ?></p>
                            <p><strong>Contact Number:</strong> <?= htmlspecialchars($userData['contact']) ?></p>
                        </div>
                    </div>

                    <!-- Address Card -->
                    <div class="bg-white shadow-lg md:rounded-lg overflow-hidden md:my-6 grid grid-cols-[auto,1fr]">

                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Address</h2>
                            <p><strong>House No:</strong> <?= htmlspecialchars($userData['houseNo']) ?></p>
                            <p><strong>Street:</strong> <?= htmlspecialchars($userData['street']) ?></p>
                            <p><strong>Barangay:</strong> <?= htmlspecialchars($userData['brgy']) ?></p>
                            <p><strong>Municipality:</strong> <?= htmlspecialchars($userData['municipality']) ?></p>
                            <p><strong>Province:</strong> <?= htmlspecialchars($userData['province']) ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

<!-- MODAL -->
<div id="editProfileModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 max-w-md">
        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>
        
        <!-- Tabs -->
        <div class="flex mb-4 gap-4">
            <button class="tab-button active" onclick="showTab('personal')">Personal Information</button>
            <button class="tab-button" onclick="showTab('contact')">Contact Details</button>
        </div>

        <!-- Tab Content -->
        <form id="editProfileForm" action="nx_query/profile_page/update_profilesettings.php" method="POST" enctype="multipart/form-data">
            <div id="personal" class="tab-content grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="fname" class="block text-sm font-medium text-gray-700">First Name</label>
                    <input type="text" id="fname" name="fname" value="<?= htmlspecialchars($userData['fname']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="mname" class="block text-sm font-medium text-gray-700">Middle Name</label>
                    <input type="text" id="mname" name="mname" value="<?= htmlspecialchars($userData['mname']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="lname" class="block text-sm font-medium text-gray-700">Last Name</label>
                    <input type="text" id="lname" name="lname" value="<?= htmlspecialchars($userData['lname']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="suffix" class="block text-sm font-medium text-gray-700">Suffix</label>
                    <input type="text" id="suffix" name="suffix" value="<?= htmlspecialchars($userData['suffix']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="bday" class="block text-sm font-medium text-gray-700">Birthday</label>
                    <input type="date" id="bday" name="bday" value="<?= htmlspecialchars($userData['bday']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                    <input type="number" id="age" name="age" value="<?= htmlspecialchars($userData['age']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="gender" class="block text-sm font-medium text-gray-700">Gender</label>
                    <select id="gender" name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="1" <?= $userData['gender'] == 1 ? 'selected' : '' ?>>Male</option>
                        <option value="0" <?= $userData['gender'] == 0 ? 'selected' : '' ?>>Female</option>
                    </select>
                </div>
            </div>

            <div id="contact" class="tab-content hidden grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="contact" class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" id="contact" name="contact" value="<?= htmlspecialchars($userData['contact']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="houseNo" class="block text-sm font-medium text-gray-700">House No</label>
                    <input type="text" id="houseNo" name="houseNo" value="<?= htmlspecialchars($userData['houseNo']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="street" class="block text-sm font-medium text-gray-700">Street</label>
                    <input type="text" id="street" name="street" value="<?= htmlspecialchars($userData['street']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="brgy" class="block text-sm font-medium text-gray-700">Barangay</label>
                    <input type="text" id="brgy" name="brgy" value="<?= htmlspecialchars($userData['brgy']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="municipality" class="block text-sm font-medium text-gray-700">Municipality</label>
                    <input type="text" id="municipality" name="municipality" value="<?= htmlspecialchars($userData['municipality']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="province" class="block text-sm font-medium text-gray-700">Province</label>
                    <input type="text" id="province" name="province" value="<?= htmlspecialchars($userData['province']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" id="username" name="username" value="<?= htmlspecialchars($userData['username']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" >
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="id_type" class="block text-sm font-medium text-gray-700">ID Type</label>
                    <input type="text" id="id_type" name="id_type" value="<?= htmlspecialchars($userData['id_type']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="mb-4">
                    <label for="id_file" class="block text-sm font-medium text-gray-700">ID File</label>
                    <input type="file" id="id_file" name="id_file" value="<?= htmlspecialchars($userData['id_file']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>
            </div>

            <div class="flex justify-end">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded" onclick="closeModal()">Cancel</button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded ml-2">Save Changes</button>
            </div>
        </form>
    </div>
</div>



<script>
    function openModal() {
        document.getElementById('editProfileModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editProfileModal').classList.add('hidden');
    }

// Handle the form submission
document.getElementById('editProfileForm').onsubmit = function(event) {
    event.preventDefault();
    
    const formData = new FormData(this);
    console.log("Form Data:", Object.fromEntries(formData));

    // Disable form submission and show loading indicator
    const submitButton = this.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.textContent;
    submitButton.disabled = true;
    submitButton.textContent = 'Updating...';

    // Send the updated data to the server
    fetch('nx_query/profile_page/update_profilesettings.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        console.log("Response Data:", data);
        if (data.status === "success") {
            swal({
                title: "Success!",
                text: "Profile updated successfully!",
                icon: "success",
                button: "OK",
            }).then(() => {
                location.reload();
            });
        } else {
            throw new Error(data.message || "Profile update failed. Please try again.");
        }
    })
    .catch(error => {
        console.error("Error:", error);
        swal({
            title: "Error",
            text: error.message || "An error occurred. Please try again.",
            icon: "error",
            button: "OK",
        });
    })
    .finally(() => {
        // Re-enable form submission and restore button text
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
    });
};

    function showTab(tabName) {
        // Hide all tab contents
        const tabs = document.querySelectorAll('.tab-content');
        tabs.forEach(tab => tab.classList.add('hidden'));
        
        // Show the selected tab
        document.getElementById(tabName).classList.remove('hidden');

        // Update active tab button styling
        const tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(button => button.classList.remove('active'));
        document.querySelector(`.tab-button[onclick="showTab('${tabName}')"]`).classList.add('active');
    }

    // Initial call to show the personal information tab by default
    showTab('personal');

    function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
        swal({
            title: "Confirm Upload",
            text: "Are you sure you want to upload this image?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willUpload) => {
            if (willUpload) {
                // Code to upload the image goes here
                // For example, you can use FormData to send it via AJAX
                const formData = new FormData();
                formData.append('image', file);

                // Example AJAX request (you'll need to implement the server-side logic)
                fetch('nx_query/profile_page/update_profilepic.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => {
                    if (response.ok) {
                        swal("Image uploaded successfully!", {
                            icon: "success",
                        });
                        location.reload(); // Reload the page after success
                    } else {
                        swal("Image upload failed. Please try again.", {
                            icon: "error",
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    swal("An error occurred. Please try again.", {
                        icon: "error",
                    });
                });
            } else {
                swal("Upload canceled.");
            }
        });
    }
}

</script>
</body>
</html>