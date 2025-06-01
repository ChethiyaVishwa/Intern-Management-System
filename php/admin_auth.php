<?php
session_start();
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];
    
    // Get admin from database
    $stmt = $conn->prepare("SELECT * FROM admins WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $admin['password'])) {
            // Login successful
            $_SESSION['admin'] = true;
            $_SESSION['admin_username'] = $username;
            $_SESSION['admin_id'] = $admin['id'];
            
            header('Location: ../admin.php');
            exit();
        }
    }
    
    // Login failed
    $_SESSION['error'] = "Invalid username or password";
    header('Location: ../login.php');
    exit();
}

// If not POST request, redirect to login
header('Location: ../login.php');
exit();
?> 