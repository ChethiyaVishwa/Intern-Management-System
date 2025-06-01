<?php
session_start();
include_once 'php/db.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    exit('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['id'];
    $student_id = trim($_POST['student_id']);
    $full_name = trim($_POST['full_name']);
    $group_name = trim($_POST['group_name']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $status = $_POST['status'];
    
    // Check if student ID already exists for other interns
    $stmt = $conn->prepare("SELECT id FROM interns WHERE student_id = ? AND id != ?");
    $stmt->bind_param("si", $student_id, $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "Student ID already exists";
        exit;
    }
    
    // Update intern details
    $stmt = $conn->prepare("UPDATE interns SET 
        student_id = ?,
        full_name = ?,
        group_name = ?,
        start_date = ?,
        end_date = ?,
        status = ?
        WHERE id = ?");
        
    $stmt->bind_param("ssssssi", 
        $student_id,
        $full_name,
        $group_name,
        $start_date,
        $end_date,
        $status,
        $id
    );
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Intern updated successfully";
        echo "success";
    } else {
        echo "Error updating intern: " . $conn->error;
    }
    exit;
}
?>