<?php
// Example data (Replace with actual email details)
$recipient_email = isset($_GET['email']) ? $_GET['email'] : "hashidewmini0@gmail.com";
$sent_time = date("Y-m-d H:i:s");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent Successfully</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #eaf7ea;
    text-align: center;
    margin: 0;
    padding: 0;
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.success-box {
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
}

h2 {
    color: #28a745;
}

p {
    font-size: 16px;
    color: #333;
}

.buttons {
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 15px;
    margin: 5px;
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
    transition: 0.3s;
}

.btn:hover {
    opacity: 0.8;
}

.btn:first-child {
    background: #007bff;
}

.btn.resend {
    background: #ffc107;
}

        </style>
</head>
<body>
    <div class="container">
        <div class="success-box">
            <h2>✅ Email Sent Successfully!</h2>
            <p><strong>Recipient:</strong> <?php echo htmlspecialchars($recipient_email); ?></p>
            <p><strong>Sent Time:</strong> <?php echo $sent_time; ?></p>
            <div class="buttons">
                <a href="home.php" class="btn">🏠 Go to Home</a>
        
            </div>
        </div>
    </div>
 
</body>
</html>