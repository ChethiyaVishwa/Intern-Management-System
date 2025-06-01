<?php
session_start();
include_once 'db.php'; // Include the database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'D:\xampp\htdocs\project\project\vendor\phpmailer\phpmailer\src\Exception.php';
require 'D:\xampp\htdocs\project\project\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'D:\xampp\htdocs\project\project\vendor\phpmailer\phpmailer\src\SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add this at the beginning of your POST handling
    var_dump($_POST);  // See all POST data
    echo "Work mode received: " . $_POST['work_mode'] . "<br>";  // See the specific work_mode value

    // Get form data
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $institute = $_POST['institute'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $work_mode = $_POST['work_mode'];
    $role = $_POST['role'];
    $skills = isset($_POST['skills']) ? implode(", ", $_POST['skills']) : '';
    
    // Map work mode values to database values
    $work_mode_mapping = [
        'Work from office' => 'On-Site',
        'Work from home' => 'Remote',
        'Hybrid (Office & Home)' => 'Hybrid'
    ];

    // Convert work mode to database value if needed
    if (isset($work_mode_mapping[$work_mode])) {
        $work_mode = $work_mode_mapping[$work_mode];
    }

    // Validate work mode
    $allowed_work_modes = ['Remote', 'On-Site', 'Hybrid'];
    if (!in_array($work_mode, $allowed_work_modes)) {
        die("Invalid work mode selected. Please go back and select a valid work mode.<br>
             Received: " . htmlspecialchars($work_mode) . "<br>
             Allowed values: " . implode(", ", $allowed_work_modes));
    }

    // Handle resume upload
    $target_dir = "../uploads/"; // Go up one directory from php folder
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Generate a unique filename to prevent overwriting
    $fileExtension = strtolower(pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION));
    $uniqueFilename = uniqid() . '.' . $fileExtension;
    $resumePath = $target_dir . $uniqueFilename;

    if (move_uploaded_file($_FILES['resume']['tmp_name'], $resumePath)) {
        // Store only the filename in database
        $dbResumePath = $uniqueFilename;
    } else {
        // Debug information
        echo "Error uploading file<br>";
        echo "Upload path: " . $resumePath . "<br>";
        echo "Temp file exists: " . (file_exists($_FILES['resume']['tmp_name']) ? 'Yes' : 'No') . "<br>";
        echo "Upload directory exists: " . (file_exists($target_dir) ? 'Yes' : 'No') . "<br>";
        echo "Upload directory is writable: " . (is_writable($target_dir) ? 'Yes' : 'No') . "<br>";
        echo "PHP Error: " . error_get_last()['message'] . "<br>";
        exit;
    }

    // Set police report path as NULL initially
    $policeReportPath = NULL;

    // Prepare and execute the database query
    $stmt = $conn->prepare("INSERT INTO job_applications (full_name, email, institute, course, year, work_mode, role, skills, resume_path, police_report_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $fullName, $email, $institute, $course, $year, $work_mode, $role, $skills, $dbResumePath, $policeReportPath);

    // Execute the statement
    if ($stmt->execute()) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
            $mail->Username   = 'sandunisathyangani3@gmail.com';      // Your Gmail address
            $mail->Password   = 'akcg givl dmmn uasd';                   // Your App Password (if 2FA is enabled)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
            $mail->Port       = 587;                                   // TCP port to connect to

            // Recipients
            $mail->setFrom('sandunisathyangani3@gmail.com', 'SLTMobitel');
            $mail->addAddress($email, $fullName);                     // Add a recipient

            // Content
            $mail->isHTML(true);                                      // Set email format to HTML
            $mail->Subject = 'Application Received';
            $mail->Body    = "Dear $fullName,<br><br>Thank you for applying to SLT Digital Platform. We have received your application.<br><br>Best regards,<br>The Team";
            $mail->AltBody = "Dear $fullName,\n\nThank you for applying to SLT Digital Platform. We have received your application.\n\nBest regards,\nThe Team";

            $mail->send();
            
            header("Location: /project/success.php");
            exit; // Ensure no further code is executed after the redirect
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>