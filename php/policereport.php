<?php
session_start();
include_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id'])) {
    $intern_id = (int)$_GET['id'];
    
    if (isset($_FILES['police_report'])) {
        $file = $_FILES['police_report'];
        // Add image types to allowed files
        $allowed_types = ['pdf', 'PDF', 'doc', 'DOC', 'docx', 'DOCX', 'jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG'];
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        // Create uploads directory if it doesn't exist
        $upload_dir = "../uploads/police_reports/";
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        if (in_array($file_ext, $allowed_types)) {
            $new_filename = 'police_report_' . $intern_id . '_' . time() . '.' . $file_ext;
            $upload_path = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file['tmp_name'], $upload_path)) {
                // Update database with police report path
                $sql = "UPDATE job_applications SET police_report_path = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $relative_path = "uploads/police_reports/" . $new_filename;
                $stmt->bind_param("si", $relative_path, $intern_id);
                
                if ($stmt->execute()) {
                    echo "<script>alert('Police report uploaded successfully!'); window.close();</script>";
                    header("Refresh: 3; url=/project/php/policereportsuccess.php");
                } else {
                    echo "Error updating database: " . $conn->error;
                }
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Allowed types: PDF, DOC, DOCX, JPG, JPEG, PNG";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Police Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            padding: 20px;
            min-height: 100vh;
        }
        .upload-container {
            max-width: 500px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .btn-primary {
            background-color: #0056a6;
            border-color: #0056a6;
        }
        .btn-primary:hover {
            background-color: #004385;
            border-color: #004385;
        }
        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="upload-container">
        <h2 class="mb-4 text-center">Upload Police Report</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="police_report" class="form-label">
                    Select Police Report (PDF, DOC, DOCX, JPG, JPEG, PNG)
                </label>
                <input type="file" class="form-control" id="police_report" name="police_report" required 
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                <div class="form-text">
                    Maximum file size: 10MB
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Upload Report</button>
            </div>
        </form>
    </div>

    <script>
    // Add file size validation
    document.querySelector('form').onsubmit = function(e) {
        const fileInput = document.querySelector('#police_report');
        const maxSize = 10 * 1024 * 1024; // 10MB in bytes
        
        if (fileInput.files[0].size > maxSize) {
            alert('File is too large. Maximum size is 10MB.');
            e.preventDefault();
            return false;
        }
        return true;
    };
    </script>
</body>
</html>