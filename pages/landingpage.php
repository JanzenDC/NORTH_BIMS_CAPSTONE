<html>
  <head>
    <base href="." />
  </head>
  <style>
    :root {
      --primary-green: #2e7d32;
      --light-green: #81c784;
      --dark-green: #1b5e20;
      --accent: #f1f8e9;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background-color: var(--accent);
    }

    .navbar {
      background-color: var(--primary-green);
      padding: 1rem 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }

    .navbar ul {
      list-style: none;
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .navbar li {
      margin-left: 2rem;
    }

    .navbar a {
      color: white;
      text-decoration: none;
      font-weight: 500;
      transition: color 0.3s ease;
      padding: 0.5rem 1rem;
      border-radius: 4px;
      position: relative;
    }

    /* Add new mobile menu styles */
    .menu-icon {
      display: none;
      cursor: pointer;
      margin-left: auto;
      padding: 0.5rem;
    }

    .menu-icon svg {
      width: 24px;
      height: 24px;
      fill: white;
    }

    .nav-links {
      display: flex;
      align-items: center;
    }

    @media (max-width: 768px) {
      .menu-icon {
        display: block;
      }

      .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        background-color: var(--primary-green);
        flex-direction: column;
        padding: 1rem 0;
      }

      .nav-links.active {
        display: flex;
      }

      .navbar li {
        margin: 0.5rem 0;
        width: 100%;
        text-align: center;
      }

      .navbar a {
        display: block;
        padding: 0.75rem 1rem;
      }

      .navbar a:hover {
        background-color: var(--dark-green);
      }

      .logo {
        display: block !important;
        margin-right: 300px !important;
      }
    }

    .logo {
      margin-right: auto;
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 40px;
      width: auto;
    }

    .hero {
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(
          rgba(46, 125, 50, 0.5), /* Reduced opacity from 0.9 to 0.5 */
          rgba(27, 94, 32, 0.5)  /* Reduced opacity from 0.9 to 0.5 */
        ),
        url('../assets/images/background_BIMS.jpg'); /* Background image URL */
      background-size: cover;
      background-position: center;
      color: white;
      text-align: center;
      padding: 0 1rem;
    }


    .hero-content {
      max-width: 800px;
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 1rem;
      animation: fadeInDown 1s ease;
    }

    .hero p {
      font-size: 1.2rem;
      margin-bottom: 2rem;
      animation: fadeInUp 1s ease;
    }

    .cta-button {
      background-color: white;
      color: var(--primary-green);
      padding: 1rem 2rem;
      border-radius: 30px;
      text-decoration: none;
      font-weight: bold;
      transition: transform 0.3s ease;
      display: inline-block;
    }

    .cta-button:hover {
      transform: translateY(-3px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .features {
      padding: 4rem 2rem;
      background-color: white;
    }

    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .feature-card {
      padding: 2rem;
      border-radius: 10px;
      background-color: var(--accent);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }

    .feature-icon {
      color: var(--primary-green);
      font-size: 2.5rem;
      margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
      .navbar ul {
        justify-content: center;
      }

      .logo {
        display: none;
      }

      .hero h1 {
        font-size: 2.5rem;
      }
    }

    .scroll-down {
      position: absolute;
      bottom: 30px;
      left: 50%;
      transform: translateX(-50%);
      cursor: pointer;
      animation: bounce 2s infinite;
    }

    .scroll-down svg {
      width: 40px;
      height: 40px;
      fill: white;
    }

    @keyframes bounce {
      0%,
      20%,
      50%,
      80%,
      100% {
        transform: translateY(0) translateX(-50%);
      }
      40% {
        transform: translateY(-20px) translateX(-50%);
      }
      60% {
        transform: translateY(-10px) translateX(-50%);
      }
    }
  </style>

  <body>
    <nav class="navbar">
      <ul>
        <li class="logo">
          <img src="../assets/images/north.png" width="120" height="40" />
        </li>
        <div class="menu-icon" onclick="toggleMenu()">
          <svg viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </div>
        <div class="nav-links">
          <li><a href="index.php" class="active">Home</a></li>
          <li><a href="about.php">About</a></li>
          <li><a href="login.php">Sign In</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </div>
      </ul>
    </nav>

    <section class="hero">
      <div class="hero-content">
        <h1>Barangay Information Management System</h1>
        <p>
          Streamline your barangay operations with our comprehensive digital
          solution. Manage residents, documents, and services efficiently in one
          platform.
        </p>
        <a href="login.php" class="cta-button">Get Started</a>
      </div>
      <div class="scroll-down" onclick="scrollToFeatures()">
        <svg viewBox="0 0 24 24">
          <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
        </svg>
      </div>
    </section>

    <section class="features">
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"
              />
            </svg>
          </div>
          <h3>Resident Management</h3>
          <p>
            Easily manage resident information and maintain accurate records
          </p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"
              />
            </svg>
          </div>
          <h3>Document Processing</h3>
          <p>Streamline document requests and certification processes</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">
            <svg width="50" height="50" viewBox="0 0 24 24" fill="currentColor">
              <path
                d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm-2 14l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"
              />
            </svg>
          </div>
          <h3>Service Tracking</h3>
          <p>Monitor and track various barangay services effectively</p>
        </div>
      </div>
    </section>

    <script>
      // Add active class to current page
      document.addEventListener("DOMContentLoaded", function () {
        const currentPage =
          window.location.pathname.split("/").pop() || "index.php";
        const navLinks = document.querySelectorAll(".navbar a");

        navLinks.forEach((link) => {
          if (link.getAttribute("href") === currentPage) {
            link.classList.add("active");
          }
        });
      });

      // Add smooth scrolling for navigation
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          e.preventDefault();
          document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth",
          });
        });
      });

      function scrollToFeatures() {
        document.querySelector(".features").scrollIntoView({
          behavior: "smooth",
        });
      }
            function toggleMenu() {
        const navLinks = document.querySelector('.nav-links');
        navLinks.classList.toggle('active');
      }

      // Close menu when clicking outside
      document.addEventListener('click', function(event) {
        const navLinks = document.querySelector('.nav-links');
        const menuIcon = document.querySelector('.menu-icon');
        
        if (!menuIcon.contains(event.target) && !navLinks.contains(event.target)) {
          navLinks.classList.remove('active');
        }
      });

      // Close menu when window is resized above mobile breakpoint
      window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
          const navLinks = document.querySelector('.nav-links');
          navLinks.classList.remove('active');
        }
      });
    </script>
  </body>
</html>
