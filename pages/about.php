<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NORTH BIMS</title>
    <link rel="icon" type="image/png" href="../assets/images/north.png">
    
  <style>
  :root {
    --primary-green: #2E7D32;
    --light-green: #81C784;
    --dark-green: #1B5E20;
    --accent: #F1F8E9;
  }
  
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }
  
  body {
    background-color: var(--accent);
    padding-top: 60px;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
      .navbar {
      background-color: var(--primary-green);
      padding: 1rem 2rem;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
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

    @media screen and (max-width: 768px) {
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
        display: flex !important;
        margin-right: 300px !important;
      }
      .step {
        margin-left: -15px;
      }
      .container {
        width: 380px;
      }

      .form-container {
        padding: 1px;
      }

      input {
        padding: 2px;
      }
      select {
        padding: 2px;
      }

      .menu-toggle {
        display: flex;
      }

      .nav-links {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: var(--primary-green);
        flex-direction: column;
        align-items: center;
        padding: 1rem 0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      }

      .nav-links.active {
        display: flex;
      }

      .nav-links li {
        margin: 0.5rem 0;
        width: 100%;
        text-align: center;
      }

      .nav-links a {
        display: block;
        padding: 0.75rem 1rem;
        width: 100%;
      }

    }
    .logo {
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 50px;
      width: auto;
    }

  
/* Default styling for desktop and larger screens */
.about-container {
  padding: 40px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin: 20px auto;
  max-width: 1200px;
}

.about-header {
  text-align: center;
  margin-bottom: 30px;
}

.about-header h1 {
  font-size: 2.5rem;
  color: #333;
}

.about-header p {
  font-size: 1.2rem;
  color: #555;
  line-height: 1.5;
}

.features-grid {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 30px;
}

.feature-card {
  background-color: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  text-align: center;
  transition: transform 0.3s ease-in-out;
}

.feature-card:hover {
  transform: translateY(-5px); /* Hover effect to lift up */
}

.feature-icon {
  font-size: 2.5rem;
  margin-bottom: 15px;
}

h3 {
  font-size: 1.6rem;
  color: #007BFF;
}

p {
  font-size: 1rem;
  color: #555;
  line-height: 1.6;
}

/* Mobile responsiveness */
@media screen and (max-width: 768px) {
  .about-container {
    padding: 20px;
    margin: 10px;
  }

  .about-header h1 {
    font-size: 2rem; /* Smaller heading for mobile */
  }

  .about-header p {
    font-size: 1rem; /* Smaller text for mobile */
  }

  .features-grid {
    grid-template-columns: 1fr; /* Stack the items in one column */
    gap: 20px;
  }

  .feature-card {
    padding: 15px;
  }

  .feature-icon {
    font-size: 3rem; /* Increase icon size for mobile */
  }

  h3 {
    font-size: 1.4rem;
  }

  p {
    font-size: 0.9rem;
  }
}

  
/* Default styling for desktop and larger screens */
.mission-vision {
  padding: 40px;
  border-radius: 8px;
  margin: 20px auto;
  max-width: 1100px;
}

.mission-vision h2 {
  text-align: center;
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 20px;
}

.mission-vision-grid {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 20px;
}

.mission, .vision {
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #fff;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
}

.mission:hover, .vision:hover {
  transform: translateY(-5px); /* Hover effect to lift up */
}

h3 {
  margin-top: 0;
  font-size: 1.8rem;
  color: #007BFF; /* Blue color for headings */
}

p {
  font-size: 1rem;
  color: #555;
  line-height: 1.6;
}

/* Mobile responsiveness */
@media screen and (max-width: 768px) {
  .mission-vision {
    padding: 20px;
    margin: 10px;
  }

  .mission-vision-grid {
    grid-template-columns: 1fr; /* Stack the items in one column */
    gap: 10px;
  }

  .mission, .vision {
    padding: 15px;
    border-radius: 8px;
  }

  h2 {
    text-align: center;
    font-size: 1.8rem; /* Smaller heading for mobile */
    color: #333;
  }

  h3 {
    font-size: 1.5rem;
  }

  p {
    font-size: 0.9rem;
  }
}

  </style>
  
  <body>
    <nav class="navbar">
      <ul>
        <li class="logo">
          <img src="../assets/images/north.png" width="120" height="40" />
          <img src="../assets/images/bims_north.png" width="120" height="40" />
        </li>
        <div class="menu-icon" onclick="toggleMenu()">
          <svg viewBox="0 0 24 24">
            <path d="M3 18h18v-2H3v2zm0-5h18v-2H3v2zm0-7v2h18V6H3z"/>
          </svg>
        </div>
        <div class="nav-links">
          <li><a href="landingpage.php">Home</a></li>
          <li><a href="about.php"  class="active">About</a></li>
          <li><a href="login.php">Sign In</a></li>
          <li><a href="contact.php">Contact Us</a></li>
        </div>
      </ul>
    </nav>
  
    <div class="about-container">
      <div class="about-header">
        <h1>About BIMS</h1>
        <p>Empowering local governance through digital transformation</p>
      </div>
  
      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">📊</div>
          <h3 style="color: green;">Data Management</h3>
          <p>Efficiently manage barangay records, resident information, and administrative data in a secure digital environment.</p>
        </div>
  
        <div class="feature-card">
          <div class="feature-icon">📱</div>
          <h3 style="color: green;">Digital Services</h3>
          <p>Provide convenient online services for document requests, permits, and other barangay-related transactions.</p>
        </div>
  
        <div class="feature-card">
          <div class="feature-icon">🤝</div>
          <h3 style="color: green;">Community Engagement</h3>
          <p>Foster better communication between barangay officials and residents through our integrated platform.</p>
        </div>
      </div>
  
<div class="mission-vision">
  <h2>Our Mission & Vision</h2>
  <div class="mission-vision-grid">
    <div class="mission">
      <h3 style="color: green;">Mission</h3>
      <p>Maiangat ang kalidad ng pamumuhay ng mga mamamayan ipagpatuloy sa kapwa upang masugpo ang kahirapan at mapanatili ang tahimik at mapayapang mamamayan.</p>
    </div>
    <div class="vision">
      <h3 style="color: green;">Vision</h3>
      <p>Isang modelong Barangay na may maunlad, mapayapa o tahimik na pamayanan na may pananalig sa Diyos, mapagmahal sa kalikasan at tumalima sa batas na umiiral sa bansa at buong pagkakaisang nagtitiwala sa mamamayang hinirang.</p>
    </div>
    <div class="vision">
      <h3 style="color: green;">Goal</h3>
      <p>"Magkaroon ng pantay-pantay na pagkakataong makamtam ang mga pangunahing pangangailangan sa pamamagitan ng isang mahusay na pamamahala."</p>
      <br>
      <p>"Magkaroon ng mga programing pangkabuhayan."</p>        
    </div>
  </div>
</div>

    
    <script>
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