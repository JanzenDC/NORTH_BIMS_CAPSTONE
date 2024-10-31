<aside id="sidebar" class="w-[300px] md:block hidden bg-green-800 text-white shadow-lg h-full overflow-y-auto ">
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
                <button onclick="toggleSettings('officials-menu', 'officials-icon')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'barangay_officials' ? 'active:bg-gray-400' : ''; ?>">
                    <div>
                    <i class="fa-solid fa-users"></i> Barangay Officials
                    </div>
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
                    <div>
                        <i class="fa-solid fa-users"></i> Residents
                    </div>
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
                <button onclick="toggleSettings('settings-menu-2', 'settings-icon-2')" class="flex justify-between w-full px-4 py-2 text-left hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'certs' ? 'active:bg-gray-400' : ''; ?>">
                    <div>
                    <i class="fa-solid fa-certificate"></i> Barangay Certificates
                    </div>
                    <span id="settings-icon-2"><i class="fa-solid fa-caret-left"></i></span>
                </button>
                <ul id="settings-menu-2" class="hidden ">
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=clearance" class="block px-4 py-2 hover:bg-gray-300 ps-16 hover:text-black <?php echo $treeView == 'clearance' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-file-alt"></i> Clearance
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=indigency" class="<?php echo $treeView == 'indigency' ? 'active:bg-green-400 text-white' : ''; ?> last:block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Indigency
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=residency" class="block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black <?php echo $treeView == 'residency' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-file-alt"></i> Residency
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=business_permit" class="<?php echo $treeView == 'business_permit' ? 'active:bg-green-400 text-white' : ''; ?> block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Business Permit
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=livestock_sale" class="<?php echo $treeView == 'livestock_sale' ? 'active:bg-green-400 text-white' : ''; ?> block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black">
                            <i class="fa-solid fa-file-alt"></i> Livestock Sale
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=land" class="<?php echo $treeView == 'land' ? 'active:bg-green-400 text-white' : ''; ?> block px-4 py-2 hover:bg-gray-300 hover:text-black ps-16">
                            <i class="fa-solid fa-file-alt"></i> Deed of Sale for Land
                        </a>
                    </li>
                    <li>
                        <a href="../nx_pages/BarangayCertificates.php?page=vehicle" class="block px-4 py-2 ps-16 hover:bg-gray-300 hover:text-black <?php echo $treeView == 'vehicle' ? 'active:bg-green-400 text-white' : ''; ?>">
                            <i class="fa-solid fa-file-alt"></i> Vehicle Deed of Sale
                        </a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="../nx_pages/BlotterPage.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'blotter' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-building-shield"></i> Blotter
                </a>
            </li>

            <li>
                <a href="ReportPage.php?page=report_init" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'reports' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-regular fa-flag"></i> Reports
                </a>
            </li>

            <li>
                <a href="UserAccounts.php?page=useraccounts" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'users' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-user"></i> User Accounts
                </a>
            </li>
            
            <li>
                <a href="../nx_pages/Activity.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'activity' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-chart-line"></i> Activity
                </a>
            </li>

            <?php if ($_SESSION['user']['isAdmin'] == '2'): ?>
                <li>
                    <a href="../nx_pages/BackupPage.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'backup' ? 'active:bg-gray-400' : ''; ?>">
                        <i class="fa-solid fa-business-time"></i> Backup
                    </a>
                </li>
            <?php endif; ?>


            <li>
                <a href="../nx_pages/SystemLogs.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'logs' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-shuffle"></i> Logs
                </a>
            </li>

            <li>
                <a href="../nx_pages/user_profile.php" class="block px-4 py-2 hover:bg-gray-200 hover:text-black <?php echo $currentPage == 'user_profile' ? 'active:bg-gray-400' : ''; ?>">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
            </li>
        </ul>
    </nav>
</aside>