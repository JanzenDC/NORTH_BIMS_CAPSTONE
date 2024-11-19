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
   }
  </style>
 </head>
 <body class="bg-green-100">
  <header class="bg-green-700 p-4 flex justify-between items-center">
        <div class="flex items-center space-x-0">
            <img alt="Logo 1" class="h-12 w-12" src="../assets/images/north.png"/>
            <img alt="Logo 2" class="h-12 w-12" src="../assets/images/bims_north.png"/>
        </div>
   <nav class="desktop-menu space-x-4 text-white">
    <a class="hover:underline" href="landingpage.php">
     Home
    </a>
    <a class="hover:underline" href="about.php">
     About
    </a>
    <a class="hover:underline" href="login.php">
     Sign In
    </a>
    <a class="hover:underline" href="contact.php">
     Contact Us
    </a>
   </nav>
   <div class="mobile-menu">
    <button class="text-white" id="menu-button">
     <i class="fas fa-bars">
     </i>
    </button>
   </div>
  </header>
  <div class="mobile-menu hidden bg-green-700 text-white p-4" id="mobile-menu">
   <a class="block py-2 hover:underline" href="landingpage.php">
    Home
   </a>
   <a class="block py-2 hover:underline" href="about.php">
    About
   </a>
   <a class="block py-2 hover:underline" href="login.php">
    Sign In
   </a>
   <a class="block py-2 hover:underline" href="contact.php">
    Contact Us
   </a>
  </div>
  <main class="p-4 md:p-8">
   <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="bg-white p-6 rounded-lg shadow-lg">
     <h2 class="text-2xl font-bold text-green-700 mb-4">
      Contact Information
     </h2>
     <p class="mb-6">
      Get in touch with us for any inquiries or emergency assistance.
     </p>
     <h3 class="text-xl font-bold text-green-700 mb-4">
      Emergency Contacts
     </h3>
     <ul class="space-y-4">
      <li class="flex items-center bg-green-100 p-4 rounded-lg">
       <i class="fas fa-phone-alt text-green-700 mr-4">
       </i>
       <span>
        Emergency Hotline (911)
       </span>
      </li>
      <li class="flex items-center bg-green-100 p-4 rounded-lg">
       <i class="fas fa-headset text-green-700 mr-4">
       </i>
       <span>
        Barangay Health Emergency
       </span>
      </li>
      <li class="flex items-center bg-green-100 p-4 rounded-lg">
       <i class="fas fa-building text-green-700 mr-4">
       </i>
       <span>
        Gabaldon MDRRMO
       </span>
      </li>
      <li class="flex items-center bg-green-100 p-4 rounded-lg">
       <i class="fas fa-fire text-green-700 mr-4">
       </i>
       <span>
        Gabaldon Fire Station
       </span>
      </li>
      <li class="flex items-center bg-green-100 p-4 rounded-lg">
       <i class="fas fa-shield-alt text-green-700 mr-4">
       </i>
       <span>
        Gabaldon PNP
       </span>
      </li>
     </ul>
     <h3 class="text-xl font-bold text-green-700 mt-8 mb-4">
      Submit an Inquiry
     </h3>
     <form class="space-y-4">
      <div>
       <label class="block text-sm font-medium text-gray-700" for="full-name">
        Full Name
       </label>
       <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="full-name" type="text"/>
      </div>
      <div>
       <label class="block text-sm font-medium text-gray-700" for="email">
        Email
       </label>
       <input class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="email" type="email"/>
      </div>
      <div>
       <label class="block text-sm font-medium text-gray-700" for="message">
        Message
       </label>
       <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="message" rows="4"></textarea>
      </div>
      <button class="bg-green-700 text-white px-4 py-2 rounded-md" type="submit">
       Submit
      </button>
     </form>
    </div>
    <div class="bg-white p-6 rounded-lg shadow-lg">
     <h2 class="text-2xl font-bold text-green-700 mb-4">
      Connect With Us
     </h2>
     <a class="block bg-blue-600 text-white text-center py-2 rounded-md mb-6" href="https://www.facebook.com/barangaynorthpoblacion.gabaldon">
      <i class="fab fa-facebook-f mr-2">
      </i>
      Follow Us on Facebook
     </a>
     
     <div class="w-full h-64">
      <iframe allowfullscreen="" height="100%" loading="lazy" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3845.507769307113!2d121.3302655741667!3d15.457096055536185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339749f585e13ddf%3A0x452246bfd6837f2f!2sBarangay%20hall!5e0!3m2!1sen!2sph!4v1730462958314!5m2!1sen!2sph" width="100%"
          height="100%"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">>
      </iframe>
     </div>
    </div>
   </div>
  </main>
  <script>
   document.getElementById('menu-button').addEventListener('click', function() {
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