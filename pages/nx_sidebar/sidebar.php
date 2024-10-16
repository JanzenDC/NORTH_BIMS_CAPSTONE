<?php // DO NOT REMOVE THIS LINE BECAUSE THIS IS THE MAIN DYNAMIC SIDEBAR SO IT WILL REDIRECT TO LOGIN IF THE USER IS NOT APPROVE
if ($_SESSION['user']['isApproved'] == 0) {
    $_SESSION['toastr_message'] = 'Your account need approval from admin.';
    $_SESSION['toastr_type'] = 'error';
    header("Location: ../login.php"); // Redirect if not approved
    exit();
}
?>
<aside id="sidebar" class="w-[300px] md:block hidden bg-green-950 text-white shadow-lg h-full overflow-y-auto ">
    <div class="flex justify-center items-center">
        <img src="../../assets/images/north.png" class="w-[100px] h-[100px]">
    </div>
    <nav class="mt-6 mb-24">
        <ul>
            <li>
                <a href="../nx_pages/dashboard.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'dashboard' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="../nx_pages/user_profile.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'user_profile' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
            </li>
            <li>
                <button onclick="toggleSettings('officials-menu', 'officials-icon')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'barangay_officials' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-users"></i> Barangay Officials
                    <span id="officials-icon"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="officials-menu" class="hidden">
                    <li>
                        <a href="../nx_pages/BarangayOfiicialPage.php?page=barangay_official" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'barangay_official' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-user-tie"></i> Barangay Official
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayOfiicialPage.php?page=sk" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'sk' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-child"></i> Sanguniang Kabataan
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayOfiicialPage.php?page=purok_leader" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'purok_leader' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-user-ninja"></i> Purok Leader
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayOfiicialPage.php?page=barangay_police" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'barangay_police' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-shield-alt"></i> Barangay Police
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayOfiicialPage.php?page=BHW" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'BHW' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-heart"></i> BHW
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <button onclick="toggleSettings('settings-menu-1', 'settings-icon-1')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'residents' ? 'active:bg-gray-400' : ''; ?>"">
                    <i class="fa-solid fa-users"></i> Residents
                    <span id="settings-icon-1"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-1" class="hidden">
                    <li>
                        <a href="../nx_pages/ResidentPage.php?page=residents" class="block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black <?php echo $treeView == 'residents' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-user-friends"></i> Residents
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/ResidentPage.php?page=headofthefamily" class="block ps-16 px-4 py-2 hover:bg-gray-300 hover:text-black <?php echo $treeView == 'headofthefamily' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-user-circle"></i> Head of the Family
                        </a>
                    </li>
                </ul>
            </li>
            <li>
                <button onclick="toggleSettings('settings-menu-2', 'settings-icon-2')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black">
                    <i class="fa-solid fa-certificate"></i> Barangay Certificates
                    <span id="settings-icon-2"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-2" class="hidden ml-4 mt-2">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Clearance
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Indigency
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Residency
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Business Permit
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Livestock Sale
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Deed of Sale for Land
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Vehicle Deed of Sale
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="UserAccounts.php?page=useraccounts" class="block px-4 py-2 hover:bg-gray-300 hover:text-black" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'user_profile' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-user"></i> User Accounts
                </a>
            </li>
        </ul>
    </nav>
</aside>


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
