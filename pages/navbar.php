<?php
if ($_SESSION['user']['isApproved'] == 0) {
    $_SESSION['toastr_message'] = 'Your account need approval from admin.';
    $_SESSION['toastr_type'] = 'error';
    header("Location: ../login.php"); // Redirect if not approved
    exit();
}
?>
<nav class="text-white w-full bg-green-600 p-4 justify-between flex relative">
    <div class="hidden md:block">
        Barangay Information and Management System 
    </div>
    <div class="text-white font-bold md:hidden text-3xl cursor-pointer flex items-center" onclick="toggleSidebar()">
        <i class="fa-solid fa-bars"></i>
    </div>
    <div class="flex gap-3 items-center relative">
        <img class="w-10 rounded-full cursor-pointer" src="../../assets/images/pfp/<?= $user['image'] ?>" alt="Profile.png" onclick="toggleProfileCard()">
        <span class="cursor-pointer" onclick="toggleProfileCard()"><?= htmlspecialchars($user['username']) ?></span>
        
        <!-- Profile Card -->
        <div id="profile-card" class="hidden absolute right-0 mt-[250px] w-48 bg-white text-gray-800 rounded-lg shadow-lg z-10">
            <div class="p-4">
                <img class="w-16 h-16 rounded-full border-2 border-gray-300 -mt-10 mx-auto" src="../../assets/images/pfp/<?= $user['image'] ?>" alt="Profile Photo">
                <h3 class="text-center font-semibold"><?= htmlspecialchars($user['username']) ?></h3>
                <div class="mt-2 text-center">
                    <a href="profile.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                    <a href="../../pages/logout.php" class="block px-4 py-2 hover:bg-gray-200">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>