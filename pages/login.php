<?php
require_once "toaster_handler.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baranggay Management System</title>
    <?php include 'headers.php'; ?>
    <style>
        .flip-container {
            perspective: 1000px;
            width: 400px;
            height: 500px;
        }
        .flipper {
            transition: 0.6s;
            transform-style: preserve-3d;
            position: relative;
        }
        .flip-container.flipped .flipper {
            transform: rotateY(180deg);
        }
        .front, .back {
            backface-visibility: hidden;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .back {
            transform: rotateY(180deg);
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
    </style>
</head>
<body>
    <div class="md:flex h-screen">
        <div class="md:w-1/2 flex h-screen items-center justify-center">
            <div class="flip-container">
                <div class="flipper">
                    <div class="front">
                        <div class="w-[400px]">
                            <div class="flex justify-center">
                                <img src="../assets/images/north.png" class="w-28" alt="Logo"/>
                            </div>
                            <p class="text-4xl text-center">LOGIN</p>
                            <form class="w-full mb-4" method="POST" action="login_query.php">
                                <p>Username</p>
                                <input type="text" name="username" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Input Username..." required>
                                
                                <p>Password:</p>
                                <input type="password" name="password" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Input Password..." required>
                                
                                <button type="submit" class="bg-green-500 w-full text-center p-2 text-white font-bold">Submit</button>
                                
                                <p class="text-center mt-3">Don't have an account? <span class="font-bold cursor-pointer" id="showSignup">Sign Up</span></p>
                            </form>

                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d480.6884926350885!2d121.3329908!3d15.4570868!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x339749f585e13ddf%3A0x452246bfd6837f2f!2sBarangay%20hall!5e0!3m2!1sen!2sph!4v1728649501242!5m2!1sen!2sph" class="w-full" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="back -mt-[60px]">
                        <div class="w-[400px] ">
                            <div class="flex justify-center">
                                <img src="../assets/images/north.png" class="w-28" alt="Logo"/>
                            </div>
                            <p class="text-4xl text-center">SIGN UP</p>
                            <form id="multiStepForm" class="w-full mb-4 mt-3">
                            <div class="step active" id="step1">
                                <select name="id_type" id="id_type" onchange="toggleFileInput()" class="w-full p-2 border border-b-2 border-black rounded">
                                    <option value="" disabled selected>Select ID type</option>
                                    <option value="Driver's License">Driver's License</option>
                                    <option value="UMID">UMID</option>
                                    <option value="School ID">School ID</option>
                                    <option value="National ID">National ID</option>
                                    <option value="Philhealth">Philhealth ID</option>
                                </select>
                                <div class="input-field">
                                    <p>ID:</p>
                                    <div class="user-upload">
                                        <input type="file" id="id_file" name="id_file" accept="image/*" disabled onchange="handleFileChange()" class="border-b-2 border-black w-full border p-2 rounded"/>
                                        <input type="file" id="hidden_id_file" name="hidden_id_file" style="display: none;"/>
                                    </div>
                                </div>
                                <div class="checkbox-container">
                                    <input type="checkbox" id="privacyCheckbox" name="privacyCheckbox" required onchange="toggleNextButton()" />
                                    <label for="privacyCheckbox">
                                        Your privacy is important to us at Barangay Information Management System (BIMS). 
                                        We collect and use your personal information solely to provide and enhance our services, and 
                                        we safeguard it from unauthorized access. By using BIMS, you agree to our privacy policy.
                                    </label>
                                </div>
                                <div class="flex justify-between mb-3">
                                    <div></div>
                                    <button type="button" class="p-2 rounded bg-green-500 text-white" onclick="nextStep(1)">Next</button>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="step" id="step2">
                                <p>Username</p>
                                <input type="text" name="username" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Create Username..." >
                                <p>Email</p>
                                <input type="email" name="email" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Enter Email..." >
                                <p>Password:</p>
                                <input type="password" name="password" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Create Password..." >
                                <p>Confirm Password:</p>
                                <input type="password" name="confirm_password" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Confirm Password..." >
                                <div class="flex justify-between mb-3">
                                    <button type="button" class="p-2 rounded bg-red-500 text-white" onclick="prevStep(1)">Previous</button>
                                    <button type="button" class="p-2 rounded bg-green-500 text-white" onclick="nextStep(2)">Next</button>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="step" id="step3">
                                <p>Phone Number:</p>
                                <input type="tel" name="phone_number" class="w-full mb-4 p-2 border border-b-2 border-black rounded" placeholder="Enter Phone Number..." >
                                <p>Date of Birth:</p>
                                <input type="date" name="date_of_birth" class="w-full mb-4 p-2 border border-b-2 border-black rounded" >
                                <p>Age:</p>
                                <input type="number" name="age" class="w-full mb-4 p-2 border border-b-2 border-black rounded" disabled>
                                <div class="flex justify-between mb-3">
                                    <button type="button" class="p-2 rounded bg-red-500 text-white" onclick="prevStep(2)">Previous</button>
                                    <button type="button" class="p-2 rounded bg-green-500 text-white" onclick="nextStep(3)">Next</button>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="step" id="step4">
                                <div class="flex gap-2">
                                    <i class="fas fa-phone"></i>
                                    <input type="text" placeholder="Contact Number" name="contact" oninput="formatContactNumber(this)" maxlength="11" required class="w-full mb-4 p-2 border border-b-2 border-black rounded"/>
                                </div>
                                <div class="flex gap-2">
                                    <i class="fas fa-home"></i>
                                    <input type="text" placeholder="House Number" name="house_no" maxlength="4" class="w-full mb-4 p-2 border border-b-2 border-black rounded"/>
                                </div>
                                <div class="flex gap-2">
                                    <i class="fas fa-street-view"></i>
                                    <div class="custom-select">
                                        <select id="street" name="street" required class="w-full mb-4 p-2 border border-b-2 border-black rounded">
                                            <option value="" disabled selected>Select Street</option>
                                            <option value="Banaba">Banaba</option>
                                            <option value="Narra">Narra</option>
                                            <option value="Mulawin">Mulawin</option>
                                            <option value="Kamagong">Kamagong</option>
                                            <option value="Mabolo">Mabolo</option>
                                            <option value="Calumpit">Calumpit</option>
                                            <option value="Acasia">Acasia</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <i class="fas fa-home"></i>
                                    <input type="text" placeholder="Barangay" name="barangay" value="North Poblacion" readonly class="w-full mb-4 p-2 border border-b-2 border-black rounded"/>
                                </div>
                                <div class="flex gap-2">
                                    <i class="fas fa-home"></i>
                                    <input type="text" placeholder="Municipality" name="municipality" value="Gabaldon" readonly class="w-full mb-4 p-2 border border-b-2 border-black rounded"/>
                                </div>
                                <div class="flex gap-2">
                                    <i class="fas fa-home"></i>
                                    <input type="text" placeholder="Province" name="province" value="Nueva Ecija" readonly class="w-full mb-4 p-2 border border-b-2 border-black rounded" />
                                </div>

                                <div class="flex justify-between mb-3">
                                    <button type="button" class="p-2 rounded bg-red-500 text-white" onclick="prevStep(3)">Previous</button>
                                </div>
                                <button type="submit" class="bg-green-500 w-full text-center p-2 text-white font-bold">Register</button>
                            </div>

                            <p class="text-center mt-3">Already have an account? <span class="font-bold cursor-pointer" id="showLogin">Login</span></p>
                        </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="md:w-1/2 bg-cover bg-center relative hidden md:block" style="background-image: url('../assets/images/background_BIMS.jpg')">
            <div class="absolute inset-0 bg-gradient-to-t from-green-500 to-transparent"></div>
            <div class="relative z-10 text-white">Test</div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php
            if (!empty($toastrScript)) {
                echo $toastrScript;
            }
            ?>
        });
        document.getElementById('showSignup').addEventListener('click', function() {
            document.querySelector('.flip-container').classList.add('flipped');
        });

        document.getElementById('showLogin').addEventListener('click', function() {
            document.querySelector('.flip-container').classList.remove('flipped');
        });

        let currentStep = 0;

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((s, index) => {
                s.classList.toggle('active', index === step);
            });
        }

        function nextStep(step) {
            currentStep++;
            showStep(currentStep);
        }

        function prevStep(step) {
            currentStep--;
            showStep(currentStep);
        }

        // Initialize the form by showing the first step
        showStep(currentStep);
    </script>
</body>
</html>
