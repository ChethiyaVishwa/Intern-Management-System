<?php
session_start();
include_once 'php/db.php';

// Get applicant ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch applicant details
$sql = "SELECT * FROM job_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$applicant = $result->fetch_assoc();

if (!$applicant) {
    die("Applicant not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applicant Details</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 2.5rem;
            padding: 0;
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #0056a6;
            margin-bottom: 30px;
        }
        .applicant-info {
            margin: 20px 0;
        }
        .info {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .info label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #0056a6;
        }
        .info span {
            color: #555;
            display: block;
            padding: 5px 0;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #0056a6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .back-btn:hover {
            background-color: #003d7a;
        }
        .actions {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Applicant Details</h1>
        <div class="applicant-info">
            <div class="info">
                <label>Full Name:</label>
                <span><?php echo htmlspecialchars($applicant['full_name']); ?></span>
            </div>
            <div class="info">
                <label>Email:</label>
                <span><?php echo htmlspecialchars($applicant['email']); ?></span>
            </div>
            <div class="info">
                <label>Education Institute:</label>
                <span><?php echo htmlspecialchars($applicant['institute']); ?></span>
            </div>
            <div class="info">
                <label>Degree/Course:</label>
                <span><?php echo htmlspecialchars($applicant['course']); ?></span>
            </div>
            <div class="info">
                <label>Current Academic year:</label>
                <span><?php echo htmlspecialchars($applicant['year']); ?></span>
            </div>
            <div class="info">
                <label>Working Mode:</label>
                <span><?php echo htmlspecialchars($applicant['work_mode']); ?></span>
            </div>
            <div class="info">
                <label>Role:</label>
                <span><?php echo htmlspecialchars($applicant['role']); ?></span>
            </div>
            <div class="info">
                <label>Selected Programming Languages:</label>
                <span><?php echo htmlspecialchars($applicant['skills']); ?></span>
            </div>
            <div class="info">
                <label>Resume:</label>
                <span>
                    <a href="download.php?file=<?php echo urlencode($applicant['resume_path']); ?>" 
                       class="btn btn-primary"
                       download>
                        Download Resume
                    </a>
                </span>
            </div>
            <div class="info">
                <label>Status:</label>
                <span><?php echo htmlspecialchars($applicant['status'] ?: 'Pending'); ?></span>
            </div>
        </div>
        <div class="actions">
            <a href="admin.php" class="back-btn">Back to Admin Panel</a>
        </div>
    </div>
</body>
</html>