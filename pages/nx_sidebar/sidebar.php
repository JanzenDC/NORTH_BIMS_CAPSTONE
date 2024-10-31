<?php
// DO NOT REMOVE THIS LINE BECAUSE THIS IS THE MAIN DYNAMIC SIDEBAR
// Redirect to login if the user is not approved
require '../db_connect.php';

$account_type = $_SESSION['user']['account_type']; // 0 - non-resident, 1 - resident
$isAdmin = $_SESSION['user']['isAdmin']; // 0 - normal user, 1 - admin, 2 - superadmin

if ($isAdmin == '1' || $isAdmin == '2') {

    include 'sidebar_admin.php';
} else {
    // Normal user: show sidebar based on account type
    if ($account_type == '1') {
        // Resident user sidebar with certificate viewing as default
        include 'sidebar_resident.php';
    } else {
        // Non-resident user sidebar
        include 'sidebar_nresident.php';
    }
}
?>


<style>
    .active\:bg-gray-400 {
        background-color: #4B5563; /* Adjust this color as needed */
    }
    .active\:bg-green-400 {
        background-color: #38a169; /* Adjust this color for active items */
    }
</style>


    <script>
        function toggleProfileCard() {
            const profileCard = document.getElementById('profile-card');
            profileCard.classList.toggle('hidden');
        }

        window.onclick = function(event) {
            const profileCard = document.getElementById('profile-card');
            if (!event.target.matches('.cursor-pointer')) {
                if (!profileCard.classList.contains('hidden')) {
                    profileCard.classList.add('hidden');
                }
            }
        };

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        }

        function toggleSettings(menuId, iconId) {
            const settingsMenu = document.getElementById(menuId);
            const icon = document.getElementById(iconId);

            if (settingsMenu.classList.contains('hidden')) {
                settingsMenu.classList.remove('hidden');
                icon.innerHTML = '<i class="fa-solid fa-caret-down"></i>'; // Change to down icon
            } else {
                settingsMenu.classList.add('hidden');
                icon.innerHTML = '<i class="fa-solid fa-caret-left"></i>'; // Change back to left icon
            }
        }
    </script>
