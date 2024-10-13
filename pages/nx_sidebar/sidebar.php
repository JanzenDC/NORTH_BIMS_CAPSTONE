
<aside class="w-[300px] md:block hidden bg-white shadow-lg h-full overflow-y-auto">

<aside id="sidebar" class="w-60 md:block hidden bg-white shadow-lg h-full overflow-y-auto">

    <div class="flex justify-center items-center">
        <img src="../../assets/images/north.png" class="w-[100px] h-[100px]">
    </div>
    <nav class="mt-6">
        <ul>
            <li>
                <a href="../nx_pages/dashboard.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a>
            </li>
            <li>
                <a href="../nx_pages/user_profile.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
            </li>
            <li>
                <button onclick="toggleSettings('officials-menu', 'officials-icon')" class="flex justify-between w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-200">
                    Barangay Officials
                    <span id="officials-icon"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="officials-menu" class="hidden ml-4 mt-2">
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Barangay Official</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Sanguniang Kabataan</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Purok Leader</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Barangay Police</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">BHW</a>
                    </li>
                </ul>
            </li>
            <li>
                <button onclick="toggleSettings('settings-menu-1', 'settings-icon-1')" class="flex justify-between w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-200">
                    Residents
                    <span id="settings-icon-1"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-1" class="hidden ml-4 mt-2">
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Residents</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Head of the Family</a>
                    </li>
                </ul>
            </li>
            <li>
                <button onclick="toggleSettings('settings-menu-2', 'settings-icon-2')" class="flex justify-between w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-200">
                    Barangay Certificates
                    <span id="settings-icon-2"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-2" class="hidden ml-4 mt-2">
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Clearance </a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Indigency</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Residency</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Business Permit</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Livestock Sale</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Deed of Sale for Land</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Vehicle Deed of Sale </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

<script>
    function toggleProfileCard() {
        const profileCard = document.getElementById('profile-card');
        profileCard.classList.toggle('hidden');
    }

    // Optional: Close profile card if clicked outside
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