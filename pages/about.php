<html><head><base href="." />
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
  }
  .navbar {
  background-color: var(--primary-green);
  padding: 1rem 2rem;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
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

.navbar a:hover {
  color: var(--light-green);
}

.navbar a.active {
  background-color: var(--dark-green);
  color: var(--light-green);
}

.navbar a.active::after {
  content: '';
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 100%;
  height: 3px;
  background-color: var(--light-green);
  border-radius: 2px;
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

  
  .about-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
  }
  
  .about-header {
    text-align: center;
    margin-bottom: 3rem;
  }
  
  .about-header h1 {
    color: var(--primary-green);
    font-size: 2.5rem;
    margin-bottom: 1rem;
  }
  
  .about-header p {
    color: #666;
    font-size: 1.2rem;
  }
  
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
  }
  
  .feature-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
  }
  
  .feature-card:hover {
    transform: translateY(-5px);
  }
  
  .feature-card h3 {
    color: var(--primary-green);
    margin-bottom: 1rem;
  }
  
  .feature-card p {
    color: #666;
    line-height: 1.6;
  }
  
  .feature-icon {
    font-size: 2.5rem;
    color: var(--primary-green);
    margin-bottom: 1rem;
  }
  
  .mission-vision {
    margin-top: 4rem;
    background: white;
    padding: 3rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  }
  
  .mission-vision h2 {
    color: var(--primary-green);
    margin-bottom: 2rem;
    text-align: center;
  }
  
  .mission-vision-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
  }
  
  .mission, .vision {
    padding: 2rem;
    background: var(--accent);
    border-radius: 8px;
  }
  
  .mission h3, .vision h3 {
    color: var(--dark-green);
    margin-bottom: 1rem;
  }
  
  .mission p, .vision p {
    color: #444;
    line-height: 1.6;
  }
  
  </style>
  
  <body>
    <nav class="navbar">
      <ul>
        <li class="logo">
          <img src="../assets/images/north.png" width="120" height="40">
        </li>
        <li><a href="landingpage.php">Home</a></li>
        <li><a href="about.php" class="active">About</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="contact.php">Contact Us</a></li>
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
          <h3>Data Management</h3>
          <p>Efficiently manage barangay records, resident information, and administrative data in a secure digital environment.</p>
        </div>
  
        <div class="feature-card">
          <div class="feature-icon">📱</div>
          <h3>Digital Services</h3>
          <p>Provide convenient online services for document requests, permits, and other barangay-related transactions.</p>
        </div>
  
        <div class="feature-card">
          <div class="feature-icon">🤝</div>
          <h3>Community Engagement</h3>
          <p>Foster better communication between barangay officials and residents through our integrated platform.</p>
        </div>
      </div>
  
      <div class="mission-vision">
        <h2>Our Mission & Vision</h2>
        <div class="mission-vision-grid">
          <div class="mission">
            <h3>Mission</h3>
            <p>Maiangat ang kalidad ng pamumuhay ng mga mamamayan ipagpatuloy sa kapwa upang masugpo ang kahirapan at mapanatili ang tahimik at mapayapang mamamayan.</p>
          </div>
          <div class="vision">
            <h3>Vision</h3>
            <p>Isang modelong Barangay na may maunlad, mapayapa o tahimik na pamayanan na may pananalig sa Diyos, mapagmahal sa kalikasan at tumalima sa batas na umiiral sa bansa at buong pagkakaisang nagtitiwala sa mamamayang hinirang.</p>
          </div>
          <div class="vision">
            <h3>Goal</h3>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
            <br>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>        
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>