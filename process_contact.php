<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail = new PHPMailer(true);
    
    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'hashidewmini0@gmail.com';
        $mail->Password   = 'rzty ebyk ixet cuou'; // Use App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipient
        $mail->setFrom($_POST["email"], $_POST["first_name"] . ' ' . $_POST["last_name"]);
        $mail->addAddress('hashidewmini0@gmail.com');

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from " . $_POST["first_name"] . " " . $_POST["last_name"];
        $mail->Body    = "
            <h2>Contact Form Submission</h2>
            <p><strong>Name:</strong> {$_POST["first_name"]} {$_POST["last_name"]}</p>
            <p><strong>Email:</strong> {$_POST["email"]}</p>
            <p><strong>Contact Number:</strong> {$_POST["contact"]}</p>
            <p><strong>Message:</strong><br>{$_POST["message"]}</p>
        ";

        $mail->send();
        echo "<script>alert('Message sent successfully!'); window.location.href='s_contact.php';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Error sending email: {$mail->ErrorInfo}'); window.location.href='s_contact.php';</script>";
    }
} else {
    header("Location: s_contact.php");
    exit();
}
?>