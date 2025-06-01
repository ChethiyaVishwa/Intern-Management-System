<?php
session_start();
include_once 'php/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Form</title>
    <link rel="stylesheet" href="css/form.css">
    <style>
        /* General reset for consistent styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Body styling */
        body {
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            background-size: cover; /* Adjust the size of the background image */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling */
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        /* Container styling */
        .container {
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            border-radius: 10px;
            box-shadow: 0 4px 8px rgb(255, 255, 255);
            max-width: 600px;
            width: 100%;
            padding: 20px;
        }

        /* Header styling */
        .container h2 {
            text-align: center;
            color: #ffffff;
            margin-bottom: 20px;
            font-size: 25px;
        }

        /* Form styling */
        form {
            display: flex;
            flex-direction: column;
            background-color: rgba(0, 0, 0, 0.59);
            padding: 10px 30px;
        }

        /* Label styling */
        form label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #fff;
        }

        /* Input and select styling */
        form input[type="text"],
        form input[type="email"],
        form select,
        form input[type="file"] {
            border: 1px solid #333;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 14px;
            width: 100%;
        }

        form select {
            background: rgb(255, 255, 255);
            appearance: none;
            cursor: pointer;
        }

        form input[type="file"] {
            padding: 5px;
        }

        /* Checkbox group styling */
        .checkbox-group {
            margin-bottom: 15px;
            color: #fff;
        }

        .checkbox-group input {
            margin-right: 10px;
            cursor: pointer;
        }

        .checkbox-group label {
            margin-right: 20px;
            font-size: 14px;
            color: #fff;
        }

        /* Button styling */
        form button[type="submit"] {
            background-color: #0056a6;
            color: #fff;
            border: none;
            padding: 12px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button[type="submit"]:hover {
            background-color: #003d7a;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .container h2 {
                font-size: 20px;
            }

            form input[type="text"],
            form input[type="email"],
            form select,
            form input[type="file"] {
                font-size: 12px;
            }

            form button[type="submit"] {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Apply for your internship with SLT Digital Platform</h2>
        <form action="php/success.php" method="POST" enctype="multipart/form-data">
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" placeholder="Enter your answer" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="institute">Educational Institute:</label>
            <input type="text" id="institute" name="institute" placeholder="Enter your answer" required>

            <label for="course">Degree/Course:</label>
            <input type="text" id="course" name="course" placeholder="Enter your answer" required>

            <label for="year">Current Academic year:</label>
            <select id="year" name="year" required>
                <option value="" disabled selected>Select your answer</option>
                <option value="1st year">1st year</option>
                <option value="2nd year">2nd year</option>
                <option value="3rd year">3rd year</option>
                <option value="4th year">4th year</option>
            </select>

            <label for="work">Working Mode:</label>
            <select id="work" name="work_mode" required>
                <option value="" disabled selected>Select your answer</option>
                <option value="Work from office">Work from office</option>
                <option value="Work from home">Work from home</option>
                <option value="Hybrid(office&Home)">Hybrid(office&Home)</option>
            </select>

            <label for="role">Select the role you would like to work:</label>
            <select id="role" name="role" required>
                <option value="Account Manager">Account Manager</option>
                <option value="AI/ML Engineer">AI/ML Engineer</option>
                <option value="UI/UX Designer">UI/UX Designer</option>
                <option value="QA Engineer">QA Engineer</option>
                <option value="Marketing Specialist">Marketing Specialist</option>
                <option value="Software Engineer">Software Engineer</option>
                <option value="Product Manager">Product Manager</option>
                <option value="AI Technical Lead">AI Technical Lead</option>
                <option value="AI Robotics Engineer">AI Robotics Engineer</option>
                <option value="Business Analyst">Business Analyst</option>
                <option value="Cloud Engineer">Cloud Engineer</option>
                <option value="Data Entry Operator">Data Entry Operator</option>
                <option value="Data Analyst">Data Analyst</option>
                <option value="Data Engineer">Data Engineer</option>
                <option value="Data Scientist">Data Scientist</option>
                <option value="DevOps Engineer">DevOps Engineer</option>
                <option value="Help Desk Manager">Help Desk Manager</option>
                <option value="Innovation Manager">Innovation Manager</option>
                <option value="IOT Firmware Engineer">IOT Firmware Engineer</option>
                <option value="IOT AI/ML Engineer">IOT AI/ML Engineer</option>
                <option value="IOT Hardware Engineer">IOT Hardware Engineer</option>
                <option value="IOT Implementation Engineer">IOT Implementation Engineer</option>
                <option value="IOT Mechanical Engineer">IOT Mechanical Engineer</option>
                <option value="IOT R&D Engineer">IOT R&D Engineer</option>
                <option value="IOT Support Engineer">IOT Support Engineer</option>
                <option value="Software Developer (Frontend)">Software Developer (Frontend)</option>
                <option value="Software Developer (Backend)">Software Developer (Backend)</option>
                <option value="Software QA Engineer">Software QA Engineer</option>
                <option value="Software Technical Lead">Software Technical Lead</option>
                <option value="Technician">Technician</option>
            </select>

            <label for="skills">Skills (Select all that apply):</label>
            <div class="checkbox-group">
                <input type="checkbox" id="skill1" name="skills[]" value="JavaScript"> JavaScript<br>
                <input type="checkbox" id="skill2" name="skills[]" value="Python"> Python<br>
                <input type="checkbox" id="skill3" name="skills[]" value="Java"> Java<br>
                <input type="checkbox" id="skill4" name="skills[]" value="C++"> C++<br>
                <input type="checkbox" id="skill5" name="skills[]" value="SQL"> SQL<br>
                <input type="checkbox" id="skill6" name="skills[]" value="HTML/CSS"> HTML/CSS<br>
                <input type="checkbox" id="skill7" name="skills[]" value=".Net"> .Net<br>
                <input type="checkbox" id="skill8" name="skills[]" value="Rust"> Rust<br>
                <input type="checkbox" id="skill9" name="skills[]" value="PHP"> PHP<br>
                <input type="checkbox" id="skill10" name="skills[]" value="MERN"> MERN<br>
                <input type="checkbox" id="skill11" name="skills[]" value="React"> React<br>
                <input type="checkbox" id="skill12" name="skills[]" value="Flutter"> Flutter<br>
            </div>

            <label for="resume">Upload Resume:</label>
            <input type="file" id="resume" name="resume" required>

            <button type="submit">Submit Application</button>
        </form>
    </div>
</body>
</html>