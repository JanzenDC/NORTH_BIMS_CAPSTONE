<?php
session_start();
?>
<html><head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Include Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" integrity="sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy" crossorigin="anonymous">   
<base href="." />
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
  
  .container {
    position: relative;
    width: 800px;
    height: 500px;
    margin: auto;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
  }
  
  .form-container {
    display: flex;
    justify-content: center;
    align-items: flex-start; /* Changed from center */
    padding: 10px;
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    transition: all 0.6s ease-in-out;
  }
  
  .sign-in-container {
    left: 0;
    width: 50%;
    z-index: 2;
  }
  
    .sign-up-container {
      transform: translateX(100%);
      left: 0;
      width: 50%;
      opacity: 0;
      z-index: 1;
    }
  
  
  .container.right-panel-active .sign-in-container {
    transform: translateX(100%);
    opacity: 0; /* Add this to hide it completely */
    visibility: hidden; /* Add this to remove from document flow */
  }
  
  .container.right-panel-active .sign-up-container {
    transform: translateX(100%);
    opacity: 1;
    z-index: 5;
    animation: show 0.6s;
  }
  
  .overlay-container {
    position: absolute;
    top: 0;
    left: 50%;
    width: 50%;
    height: 100%;
    overflow: hidden;
    transition: transform 0.6s ease-in-out;
    z-index: 100;
  }
  
  .container.right-panel-active .overlay-container {
    transform: translateX(-100%);
  }
  
  .overlay {
    background: var(--primary-green);
    background: linear-gradient(to right, var(--dark-green), var(--primary-green));
    color: white;
    position: relative;
    left: -100%;
    height: 100%;
    width: 200%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }
  
  .container.right-panel-active .overlay {
    transform: translateX(50%);
  }
  
  .overlay-panel {
    position: absolute;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    padding: 0 40px;
    text-align: center;
    top: 0;
    height: 100%;
    width: 50%;
    transform: translateX(0);
    transition: transform 0.6s ease-in-out;
  }
  
  .overlay-left {
    transform: translateX(-20%);
  }
  
  .container.right-panel-active .overlay-left {
    transform: translateX(0);
  }
  
  .overlay-right {
    right: 0;
    transform: translateX(0);
  }
  
  .container.right-panel-active .overlay-right {
    transform: translateX(20%);
  }
  
  form {
    width: 100%;
    max-width: 320px;
    margin: 0;
    padding: 20px;
  }
  
  input {
    margin: 6px 0; /* Reduced margin */
    background-color: #f8f8f8;
    border: 1px solid #e0e0e0;
    padding: 12px 15px;
    width: 100%;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
  }
  
  input:focus {
    outline: none;
    border-color: var(--primary-green);
    background-color: white;
  }
    select {
    margin: 6px 0; /* Reduced margin */
    background-color: #f8f8f8;
    border: 1px solid #e0e0e0;
    padding: 12px 15px;
    width: 100%;
    border-radius: 5px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
  }
  
  select:focus {
    outline: none;
    border-color: var(--primary-green);
    background-color: white;
  }
  
  button {
    min-width: 120px;
    border-radius: 20px;
    border: 1px solid var(--primary-green);
    background-color: var(--primary-green);
    color: white;
    font-size: 12px;
    font-weight: bold;
    padding: 12px 45px;
    letter-spacing: 1px;
    text-transform: uppercase;
    transition: transform 80ms ease-in;
    cursor: pointer;
    margin-top: 15px;
  }
  
  button:active {
    transform: scale(0.95);
  }
  
  button.ghost {
    background-color: transparent;
    border-color: white;
  }
  
  h1 {
    margin-bottom: 15px; /* Reduced margin */
    font-size: 1.8rem; /* Slightly smaller font */
    color: var(--dark-green);
  }
  
  .steps-count {
    width: 100%;
    max-width: 280px;
    display: flex;
    justify-content: space-between;
    margin: 10px auto; /* Reduced margin */
  }
  
  .step-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #eee;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #666;
    font-weight: bold;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }
  
  .step-number.active {
    background: var(--primary-green);
    color: white;
    border-color: var(--light-green);
  }
  
  .step-number.completed {
    background: var(--light-green);
    color: white;
  }
  
  .progress-bar {
    width: 100%;
    max-width: 280px;
    height: 4px;
    background: #eee;
    margin: 10px auto 20px; /* Reduced margin */
    border-radius: 2px;
    position: relative;
  }
  
  .progress {
    position: absolute;
    height: 100%;
    background: var(--primary-green);
    border-radius: 2px;
    transition: width 0.3s ease;
  }
  
  .step {
    position: absolute;
    width: 100%;
    max-width: 280px;
    transition: all 0.3s ease;
    opacity: 0;
    transform: translateX(100%);
    visibility: hidden;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    gap: 10px; /* Reduced gap */
    padding: 0 20px;
  }
  
  .step.active {
    opacity: 1;
    transform: translateX(0);
    visibility: visible;
  }
  
  .step.previous {
    transform: translateX(-100%);
  }
  
  .step h3 {
    color: var(--dark-green);
    margin-bottom: 10px; /* Reduced margin */
    font-size: 1.1rem; /* Slightly smaller font */
  }
  
  .step input {
    margin: 12px 0;
  }
  
  .btn-group {
    display: flex;
    gap: 15px;
    margin-top: 287px; /* Changed margin */
    position: relative; /* Changed from absolute */
    bottom: auto;
    left: auto;
    right: 0;
    z-index: 9999;
  }
  
  @keyframes show {
    0%, 49.99% {
      opacity: 0;
      z-index: 1;
    }
    50%, 100% {
      opacity: 1;
      z-index: 5;
    }
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
        <li><a href="login.php" class="active">Sign In</a></li>
        <li><a href="contact.php">Contact Us</a></li>
      </ul>
    </nav>
  
    <div class="container" id="container">
      <div class="form-container sign-up-container">
        <form action="signup_query.php" id="signupForm" method="POST" enctype="multipart/form-data">
            <h1>Create Account</h1>
            <div class="steps-count">
                <div class="step-number active">1</div>
                <div class="step-number">2</div>
                <div class="step-number">3</div>
                <div class="step-number">4</div>
                <div class="step-number">5</div>
            </div>
            <div class="progress-bar">
                <div class="progress" style="width: 25%"></div>
            </div>
            
            <div class="step active" style="overflow: auto; max-height: 300px; padding: 10px;">
                <h3>Step 1: Personal Information</h3>
                <select name="registration_status" required>
                    <option value="" disabled selected>Account Type</option>
                    <option value="0">Non-Resident</option>
                    <option value="1">Resident</option>
                </select>
                <input type="text" name="fname" placeholder="First Name" onchange="capitalizeFirstLetter(this)" />
                <input type="text" name="mname" placeholder="Middle Name" onchange="capitalizeFirstLetter(this)" />
                <input type="text" name="lname" placeholder="Last Name" onchange="capitalizeFirstLetter(this)" />
                <input type="text" name="suffix" placeholder="Suffix" onchange="capitalizeFirstLetter(this)" />
                <input type="date" name="date_of_birth" id="date_of_birth" placeholder="Birth Date"  />
                <input type="number" name="age" id="age" placeholder="Age"  readonly />
            </div>


            <div class="step"  style="overflow: auto; max-height: 300px; padding: 10px;">

                <h3>Step 2: Contact Details</h3>
                <input type="text" name="contact" placeholder="Phone Number"  />
            </div>

            <div class="step" style="overflow: auto; max-height: 300px; padding: 10px;">
                <h3>Step 3: Address</h3>
                <input type="text" name="house_no" placeholder="House Number"  />
                <input type="text" name="street" placeholder="Street"  />
                <input type="text" name="barangay" placeholder="Barangay" value='North Poblacion' />
                <input type="text" name="municipality" placeholder="Municipality" value='Gabaldon' />
                <input type="text" name="province" placeholder="Province" value='Nueva Ecija' />
                <input type="email" name="email" placeholder="Email"  />
            </div>

            <div class="step" style="overflow: auto; max-height: 300px; padding: 10px;">
                <h3>Step 4: Additional Information</h3>
                <input type="text" name="occupation" placeholder="Occupation"  />
                <select name="civil_status" required>
                    <option value="" disabled selected>Select Civil Status</option>
                    <option value="single">Single</option>
                    <option value="married">Married</option>
                    <option value="divorced">Divorced</option>
                    <option value="widowed">Widowed</option>
                    <option value="separated">Separated</option>
                </select>
                <input type="file" name="id_file" accept="image/*" />
            </div>

            <div class="step" style="overflow: auto; max-height: 300px; padding: 10px;">
                <h3>Step 5: Verification</h3>
                <select name="id_type" required>
                    <option value="" disabled selected>Select Valid ID Type</option>
                    <option value="passport">Passport</option>
                    <option value="drivers license">Driver's License</option>
                    <option value="national id">National ID</option>
                    <option value="voter id">Voter ID</option>
                    <option value="company id">Company ID</option>
                    <option value="school id">School ID</option>
                </select>
                <input type="text" name="id_number" placeholder="ID Number" />
                <input type="text" name="emergency_contact" placeholder="Emergency Contact" />
            </div>


            <div class="btn-group">
                <button type="button" id="prevBtn" style="display: none;">Previous</button>
                <button type="button" id="nextBtn">Next</button>
            </div>
        </form>


      </div>
      <div class="form-container sign-in-container">
        <form action="login_query.php" method='POST'>
          <h1>Sign in</h1>
          <input type="text" name='username' placeholder="Email/Username" />
          <input type="password" name='password' placeholder="Password" />
          <!-- <a href="#"><p>Forgot Password?</a></p> -->
          <button type='submit'>Sign In</button>
        </form>
      </div>
      <div class="overlay-container">
        <div class="overlay">
          <div class="overlay-panel overlay-left">
            <h1 style="color: white">Welcome Back!</h1>
            <p>Please login with your personal info</p>
            <button class="ghost" id="signIn">Sign In</button>
          </div>
          <div class="overlay-panel overlay-right">
            <h1 style="color: white">Hello!</h1>
            <p>Enter your personal details and start journey with us</p>
            <button class="ghost" id="signUp">Sign Up</button>
          </div>
        </div>
      </div>
    </div>
  
    <script>
      function capitalizeFirstLetter(input) {
          const value = input.value.toLowerCase();
          input.value = value.charAt(0).toUpperCase() + value.slice(1);
      }
      document.querySelector('input[name="contact"]').onchange = function() {
          let value = this.value;

          // Check if the value starts with "09"
          if (value.startsWith('09')) {
              // Replace "09" with "+63"
              this.value = '+63' + value.slice(2);
          }
      };
      document.querySelector('select[name="registration_status"]').addEventListener('change', function() {
          const addressFields = {
              barangay: document.querySelector('input[name="barangay"]'),
              municipality: document.querySelector('input[name="municipality"]'),
              province: document.querySelector('input[name="province"]')
          };

          if (this.value === "0") {
              Object.values(addressFields).forEach(field => {
                  field.removeAttribute('readonly');
                  field.value = '';
              });
          } else if (this.value === "1") {
              addressFields.barangay.value = 'North Poblacion';
              addressFields.municipality.value = 'Gabaldon';
              addressFields.province.value = 'Nueva Ecija';
              
              Object.values(addressFields).forEach(field => {
                  field.setAttribute('readonly', true);
              });
          }
      });

      const signUpButton = document.getElementById('signUp');
      const signInButton = document.getElementById('signIn');
      const container = document.getElementById('container'); 
      // Trigger sign up view immediately on page load
      window.addEventListener('load', () => {
        container.classList.add('right-panel-active');
      });
      const steps = document.querySelectorAll('.step');
      const nextBtn = document.getElementById('nextBtn');
      const prevBtn = document.getElementById('prevBtn');
      const progress = document.querySelector('.progress');
      const stepNumbers = document.querySelectorAll('.step-number');
      let currentStep = 0;
  
      signUpButton.addEventListener('click', () => {
        container.classList.add('right-panel-active');
      });
  
      signInButton.addEventListener('click', () => {
        container.classList.remove('right-panel-active');
      });
  
    function updateStep(step) {
        steps.forEach((s, index) => {
            s.classList.remove('active', 'previous');
            if (index === step) {
                s.classList.add('active');
            } else if (index < step) {
                s.classList.add('previous');
            }
        });

        stepNumbers.forEach((num, index) => {
            num.classList.remove('active', 'completed');
            if (index === step) {
                num.classList.add('active');
            } else if (index < step) {
                num.classList.add('completed');
            }
        });

        progress.style.width = `${((step + 1) / steps.length) * 100}%`;

        prevBtn.style.display = step === 0 ? 'none' : 'block';
        nextBtn.textContent = step === steps.length - 1 ? 'Submit' : 'Next';
        
        // Update button type
        nextBtn.type = step === steps.length - 1 ? 'submit' : 'button';
    }

    nextBtn.addEventListener('click', () => {
        if (currentStep < steps.length - 1) {
            currentStep++;
            updateStep(currentStep);
        } else {
            // No need for manual submit since button type is now submit
            // document.getElementById('signupForm').submit();
        }
    });
  
      prevBtn.addEventListener('click', () => {
        if (currentStep > 0) {
          currentStep--;
          updateStep(currentStep);
        }
      });
      $(document).ready(function() {
            <?php if (isset($_SESSION['toastr_message'])): ?>
                var message = "<?php echo $_SESSION['toastr_message']; ?>";
                var type = "<?php echo $_SESSION['toastr_type']; ?>";
                toastr[type](message);
                <?php unset($_SESSION['toastr_message']); ?>
                <?php unset($_SESSION['toastr_type']); ?>
            <?php endif; ?>
        });
        const dateOfBirthInput = document.getElementById('date_of_birth');
        const ageInput = document.getElementById('age');

        dateOfBirthInput.addEventListener('change', function() {
            const birthDate = new Date(dateOfBirthInput.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();

            // Adjust age if birth date hasn't occurred yet this year
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }

            ageInput.value = age >= 0 ? age : ''; // Set age or clear if negative
        });

    </script>
  </body>
  </html>