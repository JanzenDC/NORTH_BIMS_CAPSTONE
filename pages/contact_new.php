<html><head><base href="." />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact Us</title>
<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

body {
    line-height: 1.6;
    background: #f4f4f4;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.header {
    background: #2c3e50;
    color: white;
    padding: 20px 0;
    position: sticky;
    top: 0;
    z-index: 1000;
}

.nav-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo {
    font-size: 24px;
    font-weight: bold;
}

.nav-links {
    display: flex;
    gap: 20px;
}

.nav-links a {
    color: white;
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 5px;
    transition: background 0.3s ease;
}

.nav-links a:hover {
    background: rgba(255, 255, 255, 0.1);
}

.nav-links a.active {
    background: rgba(255, 255, 255, 0.2);
}

@media (max-width: 768px) {
    .nav-container {
        flex-direction: column;
        gap: 15px;
    }
    
    .nav-links {
        width: 100%;
        justify-content: center;
    }
}

/* Rest of your existing styles */
.contact-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr;
    }
}

.contact-card {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    margin-top: 5px;
}

.contact-card:hover {
    transform: translateY(-5px);
}

.contact-card h3 {
    color: #2c3e50;
    margin-bottom: 15px;
}

.emergency {
    background: #68c53f;
    color: white;
}

.contact-button {
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 5px;
    color: white;
    text-decoration: none;
    transition: background 0.3s ease;
}

.contact-button:hover {
    background: rgba(255, 255, 255, 0.2);
}

.contact-icon {
    width: 24px;
    height: 24px;
    fill: white;
    margin-right: 10px;
}

.map-container {
    width: 100%;
    height: 300px;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.social-icon {
    width: 40px;
    height: 40px;
    fill: #2c3e50;
    transition: fill 0.3s ease;
}

.social-icon:hover {
    fill: #3498db;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    color: #2c3e50;
}

.form-group input,
.form-group textarea {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

button {
    background: #2c3e50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background 0.3s ease;
}

button:hover {
    background: #34495e;
}


.styled-select {
    width: 100%;
    padding: 10px;
    border: 2px solid #ddd;
    border-radius: 5px;
    background-color: #f9f9f9;
    color: #333;
    appearance: none; /* Removes default dropdown arrow styling */
    cursor: pointer;
    transition: border-color 0.3s, background-color 0.3s;
}

.styled-select:focus {
    border-color: #1877F2; /* Blue border on focus */
    background-color: #fff;
    outline: none;
}

.styled-select option {
    color: #333;
}
    .logo {
      margin-right: auto;
      display: flex;
      align-items: center;
    }

    .logo img {
      height: 50px;
      width: auto;
    }
</style>
</head>
<body>
    <header class="header">
        <div class="nav-container">
        <li class="logo">
          <img src="../assets/images/north.png" width="120" height="40" />
          <img src="../assets/images/bims_north.png" width="120" height="40" />
        </li>            <nav class="nav-links">
                <a href="landingpage.php">Home</a>
                <a href="about.php">About</a>
                <a href="login.php">Signin</a>
                <a href="contact_new.php" class="active">Contact</a>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="contact-grid">
            <div class="contact-card emergency">
                <h3>Emergency Contacts</h3>

                <a href="tel: 911" class="contact-button">
                    <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                    </svg>
                    Emergency Hotline
                </a>

                <a href="tel: +639213594482" class="contact-button">
                    <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M21 12.22C21 6.73 16.74 3 12 3c-4.69 0-9 3.65-9 9.28-.6.34-1 .98-1 1.72v2c0 1.1.9 2 2 2h1v-6.1c0-3.87 3.13-7 7-7s7 3.13 7 7v6.1h1c1.1 0 2-.9 2-2v-2c0-.74-.4-1.38-1-1.72V12.22z"/>
                    </svg>
                    Barangay Health Emergency
                </a>

                <a href="tel: +639171494757" class="contact-button">
                    <svg class="contact-icon" viewBox="0 0 24 24">
              <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-8.5 12H9v-1.5h1.5V15zm0-4.5H9V9h1.5v1.5zM12 15h-1.5v-1.5H12V15zm0-4.5h-1.5V9H12v1.5zm0-4.5h-1.5V4.5H12V6zm3.5 9H14v-1.5h1.5V15zm0-4.5H14V9h1.5v1.5z"/>
                    </svg>
                    MDRRMO Gabaldon
                </a>

                <a href="tel: +639985985427" class="contact-button">
                    <svg class="contact-icon" viewBox="0 0 24 24">
                        <path d="M11 4a1 1 0 0 0-1 1v10h10.459l.522-3H16a1 1 0 1 1 0-2h5.33l.174-1H16a1 1 0 1 1 0-2h5.852l.117-.67v-.003A1.983 1.983 0 0 0 20.06 4H11ZM9 18c0-.35.06-.687.17-1h11.66c.11.313.17.65.17 1v1a1 1 0 0 1-1 1H10a1 1 0 0 1-1-1v-1Zm-6.991-7a17.8 17.8 0 0 0 .953 6.1c.198.54 1.61.9 2.237.9h1.34c.17 0 .339-.032.495-.095a1.24 1.24 0 0 0 .41-.27c.114-.114.2-.25.254-.396a1.01 1.01 0 0 0 .055-.456l-.242-2.185a1.073 1.073 0 0 0-.395-.71 1.292 1.292 0 0 0-.819-.286H5.291c-.12-.863-.17-1.732-.145-2.602-.024-.87.024-1.74.145-2.602H6.54c.302 0 .594-.102.818-.286a1.07 1.07 0 0 0 .396-.71l.24-2.185a1.01 1.01 0 0 0-.054-.456 1.088 1.088 0 0 0-.254-.397 1.223 1.223 0 0 0-.41-.269A1.328 1.328 0 0 0 6.78 4H4.307c-.3-.001-.592.082-.838.238a1.335 1.335 0 0 0-.531.634A17.127 17.127 0 0 0 2.008 11Z"/>
                    </svg>
                    PNP Gabaldon
                </a>                

                <a href="tel: +639427152383" class="contact-button">
                    <svg class="contact-icon" viewBox="0 0 24 24">
                        <path d="M8.597 3.2A1 1 0 0 0 7.04 4.289a3.49 3.49 0 0 1 .057 1.795 3.448 3.448 0 0 1-.84 1.575.999.999 0 0 0-.077.094c-.596.817-3.96 5.6-.941 10.762l.03.049a7.73 7.73 0 0 0 2.917 2.602 7.617 7.617 0 0 0 3.772.829 8.06 8.06 0 0 0 3.986-.975 8.185 8.185 0 0 0 3.04-2.864c1.301-2.2 1.184-4.556.588-6.441-.583-1.848-1.68-3.414-2.607-4.102a1 1 0 0 0-1.594.757c-.067 1.431-.363 2.551-.794 3.431-.222-2.407-1.127-4.196-2.224-5.524-1.147-1.39-2.564-2.3-3.323-2.788a8.487 8.487 0 0 1-.432-.287Z"/>
                    </svg>
                    BFP Gabaldon
                </a>
                
            </div>

<div class="contact-card">
    <h3>Find Us</h3>
    <div class="map-container">
        <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3845.507769307113!2d121.3302655741667!3d15.457096055536185!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339749f585e13ddf%3A0x452246bfd6837f2f!2sBarangay%20hall!5e0!3m2!1sen!2sph!4v1730462958314!5m2!1sen!2sph"
            width="100%" 
            height="100%" 
            frameborder="0" 
            style="border:0;" 
            allowfullscreen="">
        </iframe>
    </div>
    
    <!-- Facebook Link Section -->
    <p>Follow us on Facebook:</p>
    <p>
        <a href="https://facebook.com/yourfbpage" target="_blank" style="color: #1877F2; font-weight: bold; display: flex; align-items: center;">
            <!-- Facebook Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" style="margin-right: 8px;">
                <path d="M18.77 7.46H14.5v-1.9c0-.9.6-1.1 1-1.1h3V.5h-4.33C10.24.5 9.5 3.44 9.5 5.32v2.15h-3v4h3v12h5v-12h3.85l.42-4z"/>
            </svg>
            Visit Our Facebook Page
        </a>
    </p>
</div>


<div class="contact-card">
    <h3>Send Us a Message</h3>
    <form id="inquiryForm" onsubmit="sendEmail(event)">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
        </div>

        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="text" id="contact" name="contact" placeholder="Enter your contact number" required>
        </div>

        <div class="form-group">
            <label for="inquiryType">Type of Inquiry</label>
            <select id="inquiryType" name="inquiryType" required>
                <option value="" disabled selected>Select inquiry type</option>
                <option value="general">General Inquiry</option>
                <option value="concern">Community Concern</option>
                <option value="suggestion">Suggestion</option>
                <option value="others">Others</option>
            </select>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Please provide details about your inquiry..." required></textarea>
        </div>
        
        <button type="submit" class="submit-btn">Submit Inquiry</button>
    </form>
</div>

<script>
    async function sendEmail(event) {
        event.preventDefault(); // Prevent default form submission

        const form = document.getElementById("inquiryForm");
        const formData = new FormData(form);

        const data = {
            name: formData.get("name"),
            email: formData.get("email"),
            contact: formData.get("contact"),
            inquiryType: formData.get("inquiryType"),
            message: formData.get("message")
        };

        try {
            const response = await fetch("https://api.brevo.com/v3/smtp/email", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "api-key": "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" // Replace with your Brevo API Key
                },
                body: JSON.stringify({
                    sender: { email: "northpoblaciongab@gmail.com" },
                    to: [{ email: data.email }],
                    subject: `Inquiry from ${data.name}`,
                    htmlContent: `
                        <div style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; padding: 20px; border: 1px solid #ddd; border-radius: 8px; max-width: 600px; margin: auto; background-color: #f9f9f9;">
                            <h3 style="text-align: center; color: #1877F2; margin-bottom: 20px;">New Inquiry Submitted</h3>
                            <p><strong>Name:</strong> ${data.name}</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.contact}</p>
                            <p><strong>Type of Inquiry:</strong> ${data.inquiryType}</p>
                            <p><strong>Message:</strong><br>${data.message}</p>
                            <footer style="text-align: center; margin-top: 20px; font-size: 0.9em; color: #777;">
                                Thank you for reaching out! Our team will get back to you shortly.
                            </footer>
                        </div>
                    `
                })
            });

            if (response.ok) {
                alert("Your inquiry has been submitted successfully!");
                form.reset();
            } else {
                alert("There was an error submitting your inquiry. Please try again.");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("There was an error submitting your inquiry. Please try again.");
        }
    }

    document.getElementById("contact").addEventListener("input", function () {
        let rawValue = this.value.replace(/\D/g, "");
        if (rawValue.startsWith("0")) rawValue = "63" + rawValue.slice(1);
        this.value = rawValue.length > 2 ? "+" + rawValue : "+" + rawValue;
    });

    document.getElementById("name").addEventListener("input", function () {
        this.value = this.value.replace(/\b\w/g, char => char.toUpperCase());
    });
</script>


</body>
</html>