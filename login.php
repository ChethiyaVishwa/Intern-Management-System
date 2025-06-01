<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>

<div class="form">
    <div class="headline">
        <img src="https://www.sltdigitallab.lk/wp-content/uploads/2021/01/cropped-slt-log-removebg-1-382x144.png" alt="Logo" class="logo">
        <h2>Login Form</h2>
    </div>

    <!-- Toggle buttons for admin and user -->
    <div class="toggle-buttons">
        <button id="user-login-btn" class="active">User  Login</button>
        <button id="admin-login-btn">Admin Login</button>
    </div>

    <!-- User Login Panel -->
    <div id="user-panel" class="form-panel active">
        <form action="form.php" method="POST" autocomplete="off">
            <div class="error-text">Error</div>
            <div class="input">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter Your Email" required>
            </div>
            <div class="input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <div class="submit">
                <input type="submit" value="Login as User" class="button">
            </div>
            <div class="link">Don't have an account? <a href="register.php">Sign Up Now</a></div>
        </form>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-text" style="display: block;">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Admin Login Panel -->
    <div id="admin-panel" class="form-panel">
        <form action="php/admin_auth.php" method="POST" autocomplete="off">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-text" style="display: block;">
                    <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>
            <div class="input">
                <label>Admin Username</label>
                <input type="text" name="admin_username" placeholder="Enter Admin Username" required>
            </div>
            <div class="input">
                <label>Password</label>
                <input type="password" name="admin_password" placeholder="Password" required>
            </div>
            <div class="submit">
                <input type="submit" value="Login as Admin" class="button">
            </div>
        </form>
    </div>
</div>

<script>
    const userLoginBtn = document.getElementById('user-login-btn');
    const adminLoginBtn = document.getElementById('admin-login-btn');
    const userPanel = document.getElementById('user-panel');
    const adminPanel = document.getElementById('admin-panel');

    userLoginBtn.addEventListener('click', () => {
        userPanel.classList.add('active');
        adminPanel.classList.remove('active');
        userLoginBtn.classList.add('active');
        adminLoginBtn.classList.remove('active');
    });

    adminLoginBtn.addEventListener('click', () => {
        adminPanel.classList.add('active');
        userPanel.classList.remove('active');
        adminLoginBtn.classList.add('active');
        userLoginBtn.classList.remove('active');
    });
</script>
</body>
</html>