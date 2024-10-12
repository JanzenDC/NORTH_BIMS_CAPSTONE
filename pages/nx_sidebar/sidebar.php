<aside class="w-48 md:block hidden bg-white shadow-lg h-full overflow-y-auto">
    <div class="flex justify-center items-center">
        <img src="../../assets/images/north.png" class="w-[100px] h-[100px]">
    </div>
    <nav class="mt-6">
        <ul>
            <li>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Dashboard</a>
            </li>
            <li>
                <a href="#" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Profile</a>
            </li>
            <li>
                <button onclick="toggleSettings()" class="flex justify-between w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-200">
                    Settings
                    <span id="settings-icon">➕</span>
                </button>
                <ul id="settings-menu" class="hidden ml-4 mt-2">
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Account Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Privacy Settings</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-gray-600 hover:bg-gray-300">Notification Settings</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="logout.php" class="block px-4 py-2 text-gray-700 hover:bg-gray-200">Logout</a>
            </li>
        </ul>
    </nav>
</aside>

<script>
    function toggleSettings() {
        const settingsMenu = document.getElementById('settings-menu');
        const icon = document.getElementById('settings-icon');

        if (settingsMenu.classList.contains('hidden')) {
            settingsMenu.classList.remove('hidden');
            icon.textContent = '➖'; // Change to minus icon
        } else {
            settingsMenu.classList.add('hidden');
            icon.textContent = '➕'; // Change back to plus icon
        }
    }
</script>
