<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>About BIMS</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <style>
        .font-roboto {
            font-family: 'Roboto', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 font-roboto">
<header class="bg-green-600 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-0">
            <img alt="Logo 1" class="h-12 w-12" src="../assets/images/north.png"/>
            <img alt="Logo 2" class="h-12 w-12" src="../assets/images/bims_north.png"/>
        </div>
    <div class="md:hidden">
        <button id="menu-btn" class="text-white focus:outline-none">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <nav id="menu" class="hidden md:flex space-x-4 text-white">
        <a class="hover:underline" href="landingpage.php">Home</a>
        <a class="hover:underline" href="about.php">About</a>
        <a class="hover:underline" href="login.php">Sign In</a>
        <a class="hover:underline" href="contact.php">Contact Us</a>
    </nav>
</header>
<nav id="mobile-menu" class="hidden md:hidden bg-green-700 text-white p-4">
    <a class="block py-2 hover:underline" href="landingpage.php">Home</a>
    <a class="block py-2 hover:underline" href="about.php">About</a>
    <a class="block py-2 hover:underline" href="login.php">Sign In</a>
    <a class="block py-2 hover:underline" href="contact.php">Contact Us</a>
</nav>
<main class="max-w-7xl mx-auto p-6">
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800">About BIMS</h1>
        <p class="text-gray-600 mt-2">Empowering local governance through digital transformation</p>
    </section>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <img alt="Data Management Icon" class="mx-auto mb-4" height="50" src="https://storage.googleapis.com/a1aa/image/OZKKeCzdZgSVAaRFSr7SfiaNrY5O7fkC00AdAQ1e2sLDejTeE.jpg" width="50"/>
            <h2 class="text-green-600 text-xl font-bold">Data Management</h2>
            <p class="text-gray-600 mt-2">Efficiently manage barangay records, resident information, and administrative data in a secure digital environment.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <img alt="Digital Services Icon" class="mx-auto mb-4" height="50" src="https://storage.googleapis.com/a1aa/image/2SYxMK4jeQT7VifRmg6o2hRW4IvwoZFelrRi6QuT5XxIfxJPB.jpg" width="50"/>
            <h2 class="text-green-600 text-xl font-bold">Digital Services</h2>
            <p class="text-gray-600 mt-2">Provide convenient online services for document requests, permits, and other barangay-related transactions.</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <img alt="Community Engagement Icon" class="mx-auto mb-4" height="50" src="https://storage.googleapis.com/a1aa/image/BAE6FKlxWToQNZbeeN0RTwTA36lqdCe1eSA94kJngG1LejTeE.jpg" width="50"/>
            <h2 class="text-green-600 text-xl font-bold">Community Engagement</h2>
            <p class="text-gray-600 mt-2">Foster better communication between barangay officials and residents through our integrated platform.</p>
        </div>
    </section>
    <section class="text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Our Mission & Vision</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-green-600 text-xl font-bold">Mission</h3>
                <p class="text-gray-600 mt-2">Maiangat ang kalidad ng pamumuhay ng mga mamamayan ipagpatuloy sa kapwa upang masugpo ang kahirapan at mapanatili ang tahimik at mapayapang mamamayan.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-green-600 text-xl font-bold">Vision</h3>
                <p class="text-gray-600 mt-2">Isang modelong Barangay na may maunlad, mapayapa o tahimik na pamayanan na may pananalig sa Diyos, mapagmahal sa kalikasan at tumalima sa batas na umiiral sa bansa at buong pagkakaisang nagtitiwala sa mamamayang hinirang.</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md text-center">
                <h3 class="text-green-600 text-xl font-bold">Goal</h3>
                <p class="text-gray-600 mt-2">"Magkaroon ng pantay-pantay na pagkakataong makamtam ang mga pangunahing pangangailangan sa pamamagitan ng isang mahusay na pamamahala." "Magkaroon ng mga programing pangkaunlaran na makakatulong sa bawat mamamayan."</p>
            </div>
        </div>
    </section>
</main>
<script>
    document.getElementById('menu-btn').addEventListener('click', function () {
        var menu = document.getElementById('mobile-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
        } else {
            menu.classList.add('hidden');
        }
    });
</script>
</body>
</html>