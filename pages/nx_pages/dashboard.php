<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <?php 
        include_once "../headers.php"
    ?>
  </head>
  <body class="bg-gray-100 overflow-hidden">
    <?php
        include_once("../navbar.php")
    ?>
    <div class="flex h-screen">
      <!-- Sidebar -->
      <?php
            include_once("../nx_sidebar/sidebar.php");
        ?>
      <!-- Main Content -->
      <main class="flex-1 p-6 overflow-y-auto">
        <h1 class="text-2xl card-label font-bold">
          Welcome,
          <?php echo htmlspecialchars($_SESSION['user']['fname']); ?>!
        </h1>
        <p class="mt-4 text-gray-600">
          Here you can manage your account settings, view statistics, and more.
        </p>

        <div class="bg-green-600 text-white py-3 rounded-xl shadow-md mt-5">
          <div class="flex justify-between items-center px-4">
            <h1 class="text-xl font-bold">
              Saturday, October 12, 2024 at 05:56:55 PM
            </h1>
            <div class="relative">
              <i class="fas fa-bell w-6 h-7"></i>
              <span
                class="absolute top-0 left-3 bottom-2 right-0 inline-flex items-center justify-center w-4 h-4 bg-red-600 rounded-full text-white text-xs"
                >3</span
              >
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
          <!-- Barangay Officials Card -->
          <div class="bg-white p-4 shadow rounded-lg shadow-md">
            <h2 class="font-bold text-2xl card-label">Barangay Officials</h2>
            <div class="border-t-2 line-border h-1 my-1"></div>

            <div
              class="grid grid-cols-3 gap-4 text-center mt-4 scroll-bar"
              style="max-height: 290px; overflow-y: auto"
            >
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTu0t3J9Uiy5HEOoXjI0eqxAf879WiE_oPanQ&s"
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
              <div>
                <div class="relative inline-block">
                  <img
                    class="rounded-full border-2 border-green-600"
                    height="80"
                    src=""
                    width="80"
                  />
                </div>
                <div class="mt-2">
                  <div class="font-bold text-sm mb-sm p-1">Juan Dela Cruz</div>
                  <div class="text-xs text-gray-600">Barangay Captain</div>
                </div>
              </div>
            </div>
          </div>

          <!--Upcomming Events-->
          <div class="bg-white p-4 shadow rounded-lg shadow-md">
            <h2 class="font-bold text-2xl card-label">Upcomming Events</h2>
            <div class="border-t-2 line-border h-1 my-1"></div>

            <div
              class="mt-4 scroll-bar"
              style="height: 100%; max-height: 290px; overflow-y: auto"
            >
            <!--Event list-->
              <div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div>
              <div class="w-full border shadow rounded-md shadow-sm flex p-2  mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div>
                <div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div><div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div><div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div><div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div><div class="w-full border shadow rounded-md shadow-sm flex p-2 mb-2">
                
                <div class="flex gap-10">
                  <div
                    class="bg-green-500 justify-center border py-[3px] px-[10px]"
                  >
                    <!--day-->
                    <h1 class="text-white text-2xl font-bold text-center">
                      23
                    </h1>
                    <!--month-->
                    <p class="text-white text-xs font-semibold text-center">
                      May
                    </p>
                  </div>
                  <div>
                    <!--Event title-->
                    <h4 class="font-semibold">Barangay Council Meeting</h4>
                    <!--Event time-->
                    <div
                      class="mt-1 rounded-lg bg-gray-100 text-sm text-center w-20"
                    >
                      1:00pm
                    </div>
                  </div>
                </div>
                
              </div>




            </div>
            

            
            
            
          </div>

          <!--Total Residents in Barangay Chart-->
          <div class="bg-white p-4 shadow rounded-lg shadow-md">
            <h2 class="font-bold text-2xl card-label">
              Total Residents in Barangay
            </h2>
            <div class="border-t-2 line-border h-1 my-1"></div>

            <div
              class="text-center mt-4 scroll-bar"
              style="max-height: 290px; overflow-y: auto"
            ></div>
          </div>
        </div>
      </main>
    </div>
  </body>
</html>

<style>

.card-label{
color:#30c758;
}
.line-border{
    border-color:#30c758;
}

/* Custom scroll styling for WebKit browsers */
.scroll-bar::-webkit-scrollbar {
    width: 8px; /* Width of the scrollbar */
}

.scroll-bar::-webkit-scrollbar-track {
    background-color: #f1f1f1; /* Background of the track */
    border-radius: 10px;
}

.scroll-bar::-webkit-scrollbar-thumb {
    background-color: #4CAF50; /* Thumb color */
    border-radius: 10px; /* Rounded edges */
}

.scroll-bar::-webkit-scrollbar-thumb:hover {
    background-color: #45a049; /* Thumb hover color */
}

/* Custom scroll styling for Firefox */
.scroll-bar {
    scrollbar-width: thin; /* Thin scrollbar */
    scrollbar-color: #4CAF50 #f1f1f1; /* Thumb color and track color */
}
</style>
