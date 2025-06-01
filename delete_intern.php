<?php
session_start();
include_once 'php/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    exit('Unauthorized');
}

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    
    $stmt = $conn->prepare("DELETE FROM interns WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Error deleting intern";
    }
}
?> 