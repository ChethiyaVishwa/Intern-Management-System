<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SLT Mobitel - Contact</title>
    <link rel="stylesheet" href="./css/contact.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo">SLT<span>MOBITEL</span></div>
          
    </nav>

    <!-- Full-Screen Contact Form Section -->
    <section class="contact-section">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <form action="process_contact.php" method="post">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="first_name" required>
                </div>
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="last_name" required>
                </div>
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Contact Number:</label>
                    <input type="text" name="contact" required>
                </div>
                <div class="form-group">
                    <label>Message:</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
            <p class="contact-info">
                Find Us: <br>
                📍 Sri Lanka Telecom PLC, Lotus Road, Colombo 01, Sri Lanka <br>
                📞 011-2432755 | 📧 digitallab@slt.com.lk
            </p>
        </div>
    </section>

</body>
</html>