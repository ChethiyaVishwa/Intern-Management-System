<?php
// Create directories if they don't exist
if (!file_exists('uploads')) {
    mkdir('uploads', 0777, true);
}
if (!file_exists('uploads/police_reports')) {
    mkdir('uploads/police_reports', 0777, true);
}

// Allowed file types
$allowed_types = ['pdf', 'doc', 'docx', 'PDF', 'DOC', 'DOCX', 'jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

if (isset($_GET['file'])) {
    $file = basename($_GET['file']); // Sanitize filename
    
    // Determine the correct directory
    if (strpos($file, 'police_report_') === 0) {
        $filepath = "uploads/police_reports/" . $file;
    } else {
        $filepath = "uploads/" . $file;
    }
    
    if (file_exists($filepath)) {
        $ext = strtolower(pathinfo($filepath, PATHINFO_EXTENSION));
        
        // Set content type
        $content_types = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png'
        ];
        
        header('Content-Type: ' . ($content_types[$ext] ?? 'application/octet-stream'));
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($filepath));
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Expires: 0');
        
        readfile($filepath);
        exit();
    }
}

echo "File not found or access denied.";
?> 