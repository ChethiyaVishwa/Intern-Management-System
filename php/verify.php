<?php
session_start();
include_once 'db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input
    $otp_input = implode('', array($_POST['otp1'], $_POST['otp2'], $_POST['otp3'], $_POST['otp4']));

    // Retrieve OTP from session
    $session_otp = $_SESSION['otp'];
    $email = $_SESSION['email'];

    // Validate OTP
    if ($otp_input == $session_otp) {
        // Update verification status in the database
        $sql = "UPDATE users SET verification_status = '1' WHERE email = '$email'";
        if (mysqli_query($conn, $sql)) {
            
            header("Refresh: 3; url=/project/form.php");
        } else {
            echo "Database error: " . mysqli_error($conn);
        }
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
