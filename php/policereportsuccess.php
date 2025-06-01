<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Successful</title>
    <link rel="stylesheet" href="css/success.css"> <!-- Link to your CSS file -->
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            background-image: url('https://cdn.pixabay.com/photo/2020/10/21/01/56/digital-5671888_1280.png');
            background-size: cover; /* Adjust the size of the background image */
            background-position: center; /* Center the image */
            background-repeat: no-repeat; /* Prevent tiling */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            background: #f9f9f9c1;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            text-align: center;
            width: 80%;
            max-width: 600px;
        }

        h1 {
            font-size: 36px;
            font-weight: 600;
            color: #00B4EB;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        button {
            background-color: #00B4EB;
            color: white;
            padding: 15px 30px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056A2;
        }

        button:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Thank You!</h1>
        <p>You have successfully submitted the police report.</p>
        <form action="/project/home.php" method="POST">
            <button type="submit">Go to Home</button>
        </form>
    </div>
</body>
</html>