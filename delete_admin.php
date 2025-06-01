<?php
session_start();
include_once 'php/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    exit('Unauthorized');
}

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    
    // Prevent deleting the last admin
    $count = $conn->query("SELECT COUNT(*) as count FROM admins")->fetch_assoc()['count'];
    if ($count <= 1) {
        echo "Cannot delete the last admin";
        exit;
    }
    
    $stmt = $conn->prepare("DELETE FROM admins WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error deleting admin";
    }
}
?> 