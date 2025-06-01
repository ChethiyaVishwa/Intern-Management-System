<?php
session_start();
include_once 'db.php'; // Ensure this file contains the correct database connection

// Include PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; // Adjust the path to autoload.php

// Sanitize and retrieve input values
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$password = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Use password_hash for better security
$cpassword = $_POST['cpass']; // No need to hash confirm password
$Role = 'user';
$verification_status = '0';

// Check if fields are not empty
if (!empty($fname) && !empty($lname) && !empty($email) && !empty($phone) && !empty($_POST['pass']) && !empty($cpassword)) {
    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if email already exists
        $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "Email already exists. Please use a different email.";
        } else {
            // Check if password and confirm password match
            if ($_POST['pass'] === $cpassword) {
                $random_id = rand(time(), 10000000); // Unique user ID
                $otp = mt_rand(1111, 9999); // Generate 4-digit OTP

                // Insert data into the database
                $sql2 = mysqli_query($conn, 
                    "INSERT INTO users (unique_id, fname, lname, email, phone, password, otp, verification_status, Role) 
                    VALUES ('{$random_id}', '{$fname}', '{$lname}', '{$email}', '{$phone}', '{$password}', '{$otp}', '{$verification_status}', '{$Role}')");

                if ($sql2) {
                    // Fetch user data
                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                    if (mysqli_num_rows($sql3) > 0) {
                        $row = mysqli_fetch_assoc($sql3); // Fetch user data
                        $_SESSION['unique_id'] = $row['unique_id'];
                        $_SESSION['email'] = $row['email'];
                        $_SESSION['otp'] = $row['otp'];

                        // Send verification email using PHPMailer
                        $mail = new PHPMailer(true);

                        try {
                            // SMTP configuration
                            $mail->isSMTP();
                            $mail->Host = 'smtp.gmail.com'; // Gmail SMTP server
                            $mail->SMTPAuth = true;
                            $mail->Username = 'sandunisathyangani3@gmail.com'; // Your Gmail address
                            $mail->Password = 'akcg givl dmmn uasd'; // Your Gmail app password
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            // Email settings
                            $mail->setFrom('sandunisathyangani3@gmail.com', 'SLTMobitel');
                            $mail->addAddress($email); // Correctly setting the receiver
                            $mail->Subject = "Verification Code from SLTMobitel";
                            $mail->Body = "Hello $fname $lname,\n\nYour OTP is: $otp\n\nThank you for registering.";

                            $mail->send();
                            echo "Verification email sent successfully. Please check your inbox.";
                            header("Location: /project/verify.php"); // Redirect to verify.php
                            exit(); // Ensure no further code is executed
                        } catch (Exception $e) {
                            echo "Email Problem! Unable to send OTP. Error: {$mail->ErrorInfo}";
                        }
                    }
                } else {
                    echo "Something went wrong while inserting data: " . mysqli_error($conn);
                }
            } else {
                echo "Passwords do not match!";
            }
        }
    } else {
        echo "$email ~ This is not a valid email.";
    }
} else {
    echo "All input fields are required!";
}
?>