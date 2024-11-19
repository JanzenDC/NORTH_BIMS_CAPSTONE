<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Contact Information
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
   /* Custom styles for the mobile menu */
   .mobile-menu {
     display: none;
   }
   @media (max-width: 768px) {
     .mobile-menu {
       display: block;
     }
     .desktop-menu {
       display: none;
     }
           background-size: cover;
      background-position: left;
      color: white;
      text-align: center;
      padding: 0 1rem;
    }
   }
  </style>
 </head>
<body class="bg-green-700">
    <nav class="bg-green-600 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-0">
            <img alt="Logo 1" class="h-12 w-12" src="../assets/images/north.png"/>
            <img alt="Logo 2" class="h-12 w-12" src="../assets/images/bims_north.png"/>
        </div>
        <div class="desktop-menu text-white space-x-4 md:space-x-8">
            <a class="hover:underline" href="landingpage.php">Home</a>
            <a class="hover:underline" href="about.php">About</a>
            <a class="hover:underline" href="login.php">Sign In</a>
            <a class="hover:underline" href="contact.php">Contact Us</a>
        </div>
        <div class="mobile-menu">
            <button id="menu-button" class="text-white focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </nav>
    <div id="mobile-menu-items" class="hidden bg-green-700 text-white p-4 space-y-2">
        <a class="block hover:underline" href="landingpage.php">Home</a>
        <a class="block hover:underline" href="about.php">About</a>
        <a class="block hover:underline" href="login.php">Sign In</a>
        <a class="block hover:underline" href="contact.php">Contact Us</a>
    </div>
    <div class="relative">
        <img 
            alt="Barangay background" 
            class="w-full h-screen object-cover opacity-50 sm:object-center md:object-center lg:object-center object-left" 
            src="../assets/images/bims2.jpg"
        />
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
            <h1 class="text-3xl md:text-5xl font-bold">Barangay Information Management System</h1>
            <p class="mt-4 text-sm md:text-lg">Streamline your barangay operations with our comprehensive digital solution. Manage residents, documents, and services efficiently in one platform.</p>
            <button class="mt-8 bg-white text-green-700 font-semibold py-2 px-4 rounded-full hover:bg-gray-200">Get Started</button>
        </div>
    </div>
    <script>
        document.getElementById('menu-button').addEventListener('click', function() {
            var menuItems = document.getElementById('mobile-menu-items');
            if (menuItems.classList.contains('hidden')) {
                menuItems.classList.remove('hidden');
            } else {
                menuItems.classList.add('hidden');
            }
        });
    </script>
</body>
</html>