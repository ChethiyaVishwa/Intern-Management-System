<?php
session_start();
include_once 'php/db.php'; // Include your database connection file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/register.css"> <!-- Ensure correct path -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            background-size: cover; /* Adjust the size of the background image */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling */
            min-height: 100vh;
            padding: 0.1px;
        }

        .form {
            width: 400px;
            margin: 65px auto;
            padding: 15px 60px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .headline {
            text-align: center;
            margin-bottom: 20px;
        }

        .headline img {
            max-width: 200px;
            margin-bottom: 10px;
            margin: 1px auto;
        }

        .headline h2 {
            margin: 10px 0 5px;
            font-size: 24px;
            padding: 0.01px ;
            font-weight: bold;
            color: #0056a6; 

        }

        .headline p {
            font-size: 0.9rem;
            color: gray;
        }

        .input {
            margin-bottom: 15px;
        }

        .input label {
            display: block;
            margin-bottom: 5px;
            font-size: 0.9rem;
            color: #333;
        }

        .input input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 0.9rem;
        }

        .submit {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            background-color: #0056a6;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }

        .button:hover {
            background-color: #003d7a;
        }

        .link {
            margin-top: 10px;
            font-size: 17px;
            color: #555;
            text-align: center;
        }

        .link a {
            color: #0056a6;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }    

        .link a:hover {
            text-decoration: underline;
        }

        .error-text {
            display: none;
            color: red;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .skills-checkboxes {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 10px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .skills-checkboxes label {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.9rem;
            color: #333;
        }

        .skills-checkboxes input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <div class="form">
        <div class="headline">
            <img src="https://www.sltdigitallab.lk/wp-content/uploads/2021/01/cropped-slt-log-removebg-1-382x144.png" alt="Logo" class="logo">
            <h2>Signup Form</h2>
            <p>It's free and always will be.</p>
        </div>
        
        <form action="php/register.php" method="POST" onsubmit="return validateForm()">
            <div class="error-text" id="error-text">Passwords do not match.</div>
            
            <div class="grid-details">
                <div class="input">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" placeholder="First Name" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed.">
                </div>
                <div class="input">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" placeholder="Last Name" required pattern="[a-zA-Z\s]+" title="Only letters and spaces allowed.">
                </div>
            </div>
            
            <div class="input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter Your Email" required>
            </div>
            
            <div class="input">
                <label for="phone">Phone</label>
                <input type="tel" id="phone" name="phone" placeholder="Phone Number" required pattern="[0-9]{10}" title="Enter a 10-digit phone number.">
            </div>
            
            <div class="grid-details">
                <div class="input">
                    <label for="pass">Password</label>
                    <input type="password" id="pass" name="pass" placeholder="Password" required>
                </div>
                <div class="input">
                    <label for="cpass">Confirm Password</label>
                    <input type="password" id="cpass" name="cpass" placeholder="Confirm Password" required>
                </div>
            </div>
            
            <div class="submit">
                <input type="submit" value="Signup Now" class="button">
            </div>

            <!-- Google Sign-in button -->
            <?php
            require_once './php/db.php';
            if (isset($_SESSION['user_token'])) {
                header("Location: home.php");
            } else {
                $authUrl = $client->createAuthUrl();
                echo "
                <a href='$authUrl' style='
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 8px;
                    margin: 2rem;
                    background-color: #fff;
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 8px 16px;
                    text-decoration: none;
                    color: #000;
                    font-family: Arial, sans-serif;
                    font-size: 14px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                    transition: box-shadow 0.2s ease;
                ' onmouseover='this.style.boxShadow=\"0 4px 6px rgba(0, 0, 0, 0.2)\"' 
                onmouseout='this.style.boxShadow=\"0 2px 4px rgba(0, 0, 0, 0.1)\"'>
                    <img src='images/google-logo.png' alt='Google logo' style='width: 20px; height: 20px;'>
                    Sign in with Google
                </a>";
            }
            ?>
        </form>
        

        <div class="link">Already signed up? <a href="login.php">Login Now</a></div>

    </div>
    
    <script>
        function validateForm() {
            const pass = document.getElementById('pass').value;
            const cpass = document.getElementById('cpass').value;
            const errorText = document.getElementById('error-text');

            if (pass !== cpass) {
                errorText.style.display = 'block';
                return false;
            }
            errorText.style.display = 'none';
            return true;
        }

        document.querySelector('form').addEventListener('submit', function(e) {
            const workMode = document.getElementById('work_mode').value;
            if (!workMode) {
                e.preventDefault();
                alert('Please select a work mode');
                return false;
            }
        });
    </script>

</body>
</html>

