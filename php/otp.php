<?php
session_start();
include 'db.php';

$unique_id = $_SESSION['unique_id'] ?? null;
$otp1 = $_POST['otp1'] ?? '';
$otp2 = $_POST['otp2'] ?? '';
$otp3 = $_POST['otp3'] ?? '';
$otp4 = $_POST['otp4'] ?? '';
$entered_otp = $otp1 . $otp2 . $otp3 . $otp4;

if (!$unique_id || empty($entered_otp)) {
    echo "Invalid OTP or session expired.";
    exit;
}

$qry = mysqli_query($conn, "SELECT otp FROM users WHERE unique_id = '{$unique_id}'");
if (mysqli_num_rows($qry) > 0) {
    $row = mysqli_fetch_assoc($qry);
    if ($row['otp'] === $entered_otp) {
        mysqli_query($conn, "UPDATE users SET verification_status = 'Verified' WHERE unique_id = '{$unique_id}'");
        echo "success";
    } else {
        echo "Invalid OTP. Please try again.";
    }
} else {
    echo "User not found.";
}
?>
