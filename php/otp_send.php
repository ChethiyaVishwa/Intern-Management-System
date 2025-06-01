<?php
session_start();
include 'db.php';
require 'PHPMailer/PHPMailer.php'; // Ensure PHPMailer is installed

// Ensure user is logged in
if (!isset($_SESSION['unique_id']) || empty($_SESSION['unique_id'])) {
    header("Location: index.php");
    exit;
}

// Generate a 4-digit OTP
$otp = rand(1000, 9999);

// Save OTP in the database
$unique_id = $_SESSION['unique_id'];
mysqli_query($conn, "UPDATE users SET otp = '$otp' WHERE unique_id = '$unique_id'");

// Send OTP email
$query = mysqli_query($conn, "SELECT email FROM users WHERE unique_id = '$unique_id'");
$row = mysqli_fetch_assoc($query);
if ($row) {
    $to = $row['email'];
    $subject = "Your OTP Code";
    $message = "Your OTP code is: $otp";
    $headers = "From: no-reply@example.com"; // Replace with your domain email

    if (mail($to, $subject, $message, $headers)) {
        echo "OTP sent to $to.";
    } else {
        echo "Failed to send OTP. Please check your email configuration.";
    }
} else {
    echo "User not found.";
}
?>
