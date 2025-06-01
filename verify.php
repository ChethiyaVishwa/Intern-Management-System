




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/verify.css">
    <title>Verify</title>
</head> 
<body>
<form action="php/verify.php" method="POST">
    <div class="form" style="text-align: center;">
        <h2>Verify Your Account</h2>
        <p>We emailed you the four digit otp code to Enter the code below to confirm your email address.. </p>
        <form action="" autocomplete="off">
            <div class="error-text">Error</div>
                <div class="fields-input">
                    <input type="number" name="otp1" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp2" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false"> 
                    <input type="number" name="otp3" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp4" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">   
                </div>
                <div class="submit">
                    <input type="submit" value="Verify Now" class="button">
                </div>    
        </form>
    </div>
    <script src="js/verify.js"></script>   
</body>   
</html>