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
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
  }
  
  .contact-container {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 2rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    width: 90%;
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
  .contact-info {
    padding: 2rem;
  }
  
  .map-container {
    width: 100%;
    height: 400px;
    border-radius: 10px;
    overflow: hidden;
    margin-top: 50px;
  }
  
  .emergency-contacts {
    margin-top: 2rem;
  }
  
  .contact-button {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    margin: 1rem 0;
    background: var(--accent);
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: var(--dark-green);
  }
  
  .contact-button:hover {
    background: var(--light-green);
    transform: translateY(-2px);
  }
  
  .contact-icon {
    width: 24px;
    height: 24px;
    fill: var(--primary-green);
  }
  
  h2 {
    color: var(--dark-green);
    margin-bottom: 1rem;
  }
  
  p {
    margin-bottom: 1rem;
    line-height: 1.6;
  }
  
  .contact-form {
    width: 100%;
    max-width: 600px;
    margin: 2rem auto;
    padding: 2rem;
    background: var(--accent);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  }
  
  .form-group {
    margin-bottom: 1.5rem;
  }
  
  .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--dark-green);
    font-weight: 500;
  }
  
  .form-group input,
  .form-group textarea,
  .form-group select {
    width: 100%;
    padding: 0.8rem;
    border: 1px solid var(--light-green);
    border-radius: 4px;
    font-size: 1rem;
    background: white;
  }
  
  .form-group textarea {
    resize: vertical;
    min-height: 150px;
  }
  
  .form-group select {
    cursor: pointer;
  }
  
  .submit-btn {
    width: 100%;
    background: var(--primary-green);
    color: white;
    padding: 1rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 500;
    transition: all 0.3s ease;
  }
  
  .submit-btn:hover {
    background: var(--dark-green);
    transform: translateY(-2px);
  }
  
  .social-media-container {
    margin-top: 2rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    height: 600px;
  }
  
  .facebook-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #4267B2;
    color: white;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
  }
  
  .facebook-link:hover {
    background: #365899;
    transform: translateY(-2px);
  }
  
  .facebook-icon {
    width: 24px;
    height: 24px;
    fill: white;
  }
  </style>
  
  <body>
    <nav class="navbar">
      <ul>
        <li class="logo">
          <img src="../assets/images/north.png" width="120" height="40">
        </li>
        <li><a href="landingpage.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="login.php">Sign In</a></li>
        <li><a href="contact.php" class="active">Contact Us</a></li>
      </ul>
    </nav>
  
    <div class="contact-container">
      <div class="contact-info">
        <h2>Contact Information</h2>
        <p>Get in touch with us for any inquiries or emergency assistance.</p>
        
        <div class="emergency-contacts">
          <h2>Emergency Contacts</h2>
          
          <a href="tel:911" class="contact-button">
            <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
            </svg>
            Emergency Hotline (911)
          </a>
  
          <a href="tel:+639213594482" class="contact-button">
            <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M21 12.22C21 6.73 16.74 3 12 3c-4.69 0-9 3.65-9 9.28-.6.34-1 .98-1 1.72v2c0 1.1.9 2 2 2h1v-6.1c0-3.87 3.13-7 7-7s7 3.13 7 7v6.1h1c1.1 0 2-.9 2-2v-2c0-.74-.4-1.38-1-1.72V12.22z"/>
            </svg>
            Barangay Health Emergency
          </a>
  
          <a href="tel:+639519947296" class="contact-button">
            <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.5 12H9v-1.5h1.5V15zm0-4.5H9V9h1.5v1.5zM12 15h-1.5v-1.5H12V15zm0-4.5h-1.5V9H12v1.5zm0-4.5h-1.5V4.5H12V6zm3.5 9H14v-1.5h1.5V15zm0-4.5H14V9h1.5v1.5z"/>
            </svg>
            Gabaldon MDRRMO
          </a>

          <a href="tel:+639427152383" class="contact-button">
            <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M8.597 3.2A1 1 0 0 0 7.04 4.289a3.49 3.49 0 0 1 .057 1.795 3.448 3.448 0 0 1-.84 1.575.999.999 0 0 0-.077.094c-.596.817-3.96 5.6-.941 10.762l.03.049a7.73 7.73 0 0 0 2.917 2.602 7.617 7.617 0 0 0 3.772.829 8.06 8.06 0 0 0 3.986-.975 8.185 8.185 0 0 0 3.04-2.864c1.301-2.2 1.184-4.556.588-6.441-.583-1.848-1.68-3.414-2.607-4.102a1 1 0 0 0-1.594.757c-.067 1.431-.363 2.551-.794 3.431-.222-2.407-1.127-4.196-2.224-5.524-1.147-1.39-2.564-2.3-3.323-2.788a8.487 8.487 0 0 1-.432-.287Z"/>
            </svg>
            Gabaldon Fire Station
          </a>

          <a href="tel:+639985985427" class="contact-button">
            <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M11 4a1 1 0 0 0-1 1v10h10.459l.522-3H16a1 1 0 1 1 0-2h5.33l.174-1H16a1 1 0 1 1 0-2h5.852l.117-.67v-.003A1.983 1.983 0 0 0 20.06 4H11ZM9 18c0-.35.06-.687.17-1h11.66c.11.313.17.65.17 1v1a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1v-1Zm-6.991-7a17.8 17.8 0 0 0 .953 6.1c.198.54 1.61.9 2.237.9h1.34c.17 0 .339-.032.495-.095a1.24 1.24 0 0 0 .41-.27c.114-.114.2-.25.254-.396a1.01 1.01 0 0 0 .055-.456l-.242-2.185a1.073 1.073 0 0 0-.395-.71 1.292 1.292 0 0 0-.819-.286H5.291c-.12-.863-.17-1.732-.145-2.602-.024-.87.024-1.74.145-2.602H6.54c.302 0 .594-.102.818-.286a1.07 1.07 0 0 0 .396-.71l.24-2.185a1.01 1.01 0 0 0-.054-.456 1.088 1.088 0 0 0-.254-.397 1.223 1.223 0 0 0-.41-.269A1.328 1.328 0 0 0 6.78 4H4.307c-.3-.001-.592.082-.838.238a1.335 1.335 0 0 0-.531.634A17.127 17.127 0 0 0 2.008 11Z"/>
            </svg>
            Gabaldon PNP
          </a>

        </div>
  
        <form class="contact-form" id="inquiryForm" onsubmit="return sendEmail(event)">
          <h2>Submit an Inquiry</h2>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        
          <div class="form-group">
              <label for="email">Email Address</label>
              <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="phone">Contact Number</label>
            <input type="tel" id="phone" name="phone" maxlength="13" required>
        </div>
        
          <div class="form-group">
              <label for="inquiryType">Type of Inquiry</label>
              <select id="inquiryType" name="inquiryType" required>
                  <option value="">Select inquiry type</option>
                  <option value="general">General Inquiry</option>
                  <option value="concern">Community Concern</option>
                  <option value="suggestion">Suggestion</option>
                  <option value="others">Others</option>
              </select>
          </div>
          <div class="form-group">
              <label for="message">Message</label>
              <textarea id="message" name="message" placeholder="Please provide details about your inquiry..." required></textarea>
          </div>
          <button type="submit" class="submit-btn">Submit Inquiry</button>
      </form>
      
  

      </div>
      <div class="social-media-container">
        <h2>Connect With Us</h2>
        <a href="https://www.facebook.com/barangaynorthpoblacion.gabaldon" class="facebook-link" target="_blank">
          <svg class="facebook-icon" viewBox="0 0 24 24">
            <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z"/>
          </svg>
          Follow Us on Facebook
        </a>
        <div class="map-container">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3845.507769307113!2d121.3302655741667!3d15.457096055536185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339749f585e13ddf%3A0x452246bfd6837f2f!2sBarangay%20hall!5e0!3m2!1sen!2sph!4v1730462958314!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
          width="100%"
          height="100%"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      </div>
      </div>

    </div>
  
    <script>
      function validateForm(event) {
        event.preventDefault();
        
        const form = document.getElementById('inquiryForm');
        const formData = new FormData(form);
        
        console.log('Form submitted with the following data:');
        for (let pair of formData.entries()) {
          console.log(pair[0] + ': ' + pair[1]);
        }
        
        alert('Thank you for your inquiry. We will get back to you soon!');
        form.reset();
        
        return false;
      }
        async function sendEmail(event) {
            event.preventDefault(); // Prevent default form submission

            const formData = new FormData(document.getElementById('inquiryForm'));
            const data = {
                name: formData.get('name'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                inquiryType: formData.get('inquiryType'),
                message: formData.get('message')
            };

            try {
                const response = await fetch('https://api.brevo.com/v3/smtp/email', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'api-key': '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' // Replace with your Brevo API Key
                    },
                    body: JSON.stringify({
                        sender: { email: 'northpoblaciongab@gmail.com' }, // Replace with your sender email
                        to: [{ email: data.email }], // Recipient email
                        subject: `Inquiry from ${data.name}`,
                        htmlContent: `
                            <h3>New Inquiry Submitted</h3>
                            <p><strong>Name:</strong> ${data.name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone}</p>
                            <p><strong>Type of Inquiry:</strong> ${data.inquiryType}</p>
                            <p><strong>Message:</strong><br>${data.message}</p>
                        `
                    })
                });

                if (response.ok) {
                    alert('Your inquiry has been submitted successfully!');
                    document.getElementById('inquiryForm').reset(); // Reset form fields
                } else {
                    alert('There was an error submitting your inquiry. Please try again.');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('There was an error submitting your inquiry. Please try again.');
            }
        }
            const phoneInput = document.getElementById("phone");
        
            phoneInput.addEventListener("input", function () {
                // Remove all non-digit characters
                let rawValue = this.value.replace(/\D/g, "");
        
                // Check if the input starts with "0" and convert it to "+63"
                if (rawValue.startsWith("0")) {
                    rawValue = "63" + rawValue.slice(1);
                }
        
                // Format the number as "+63XXXXXXXXXX" if it’s the correct length
                if (rawValue.startsWith("63") && rawValue.length > 2) {
                    this.value = "+" + rawValue;
                } else {
                    this.value = "+" + rawValue; // Display partial input
                }
            });
            const nameInput = document.getElementById("name");
        
            nameInput.addEventListener("input", function () {
                // Split the name into words, capitalize the first letter of each word, and join them back
                this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
            });
    </script>

  </body>
  </html>