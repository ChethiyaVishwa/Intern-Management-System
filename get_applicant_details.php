<?php
$servername = "localhost"; // Change if necessary
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "userform"; // Ensure this matches your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the applicant ID from the URL
$applicantId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Prepare and execute the SQL statement
$sql = "SELECT full_name, institute, course, year, work_mode, role, skills, resume_path FROM job_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $applicantId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the applicant exists
if ($result->num_rows > 0) {
    $applicant = $result->fetch_assoc();
    // Return the applicant data as JSON
    echo json_encode($applicant);
} else {
    echo json_encode(null);
}

$stmt->close();
$conn->close();
?>