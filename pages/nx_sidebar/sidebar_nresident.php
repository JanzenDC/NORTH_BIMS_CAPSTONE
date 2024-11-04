<aside id="sidebar" class="w-[300px] md:block hidden bg-green-800 text-white shadow-lg h-full overflow-y-auto ">
    <div class="flex justify-center items-center">
        <img src="../../assets/images/north.png" class="w-[100px] h-[100px]">
    </div>
    <nav class="mt-6 mb-24">
        <ul>
            <li>
                <a href="../nx_nonresident/res_Dashboard.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'dashboard' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="../nx_pages/user_profile.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'user_profile' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
            </li>

            <li>
                <button onclick="toggleSettings('settings-menu-2', 'settings-icon-2')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'certs' ? 'active:bg-gray-400' : ''; ?>">
                    <div>
                    <i class="fa-solid fa-certificate"></i> Barangay Certificates
                    </div>
                    <span id="settings-icon-2"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-2" class="hidden ">
                    <li>
                        <a href="../nx_nonresident/res_BarangayCertificate.php?page=business_permit" class="<?php echo $treeView == 'business_permit' ? 'active:bg-green-400 text-white' : ''; ?> block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Business Permit
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>