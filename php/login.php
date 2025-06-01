<?php 
// Start session
session_start();
include 'db.php'; // Ensure 'db.php' initializes the $conn variable properly

// Check database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// User Login Logic
$Email = isset($_POST['email']) ? trim($_POST['email']) : '';
$Password = isset($_POST['pass']) ? md5(trim($_POST['pass'])) : '';

if (!empty($Email) && !empty($Password)) {
    $sql = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $sql->bind_param('ss', $Email, $Password);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) { 
        $row = $result->fetch_assoc();
        $_SESSION['unique_id'] = $row['unique_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['otp'] = $row['otp'];
        echo "success";
    } else {
        echo "Email or Password is Incorrect!";
    }

    $sql->close();
} else {
    header("Refresh: 3; url=/project/form.php");
}

// Admin Login Logic
$id = isset($_POST['id']) ? trim($_POST['id']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

if (!empty($id) && !empty($password)) {
    $sql = $conn->prepare("SELECT * FROM admin WHERE id = ?");
    $sql->bind_param('s', $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['id'] = $id;
            echo "Login successful. Welcome, Admin!";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Admin ID not found.";
    }

    $sql->close();
} else {
    header("Refresh: 3; url=/project/form.php");
}

// Generate Admin Credentials
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin'])) {
    // Define unique admin credentials
    $id = '123'; // Unique Admin ID
    $password = 'Pass@2025'; // Admin Password

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insert admin credentials into the database
    $sql = $conn->prepare("INSERT INTO admin (id, password_hash) VALUES (?, ?)");
    $sql->bind_param('ss', $id, $password_hash);

    if ($sql->execute()) {
        echo "Admin credentials created successfully!";
    } else {
        echo "Error: " . $conn->error;
    }

    $sql->close();
}

// Close the database connection
$conn->close();
?>
