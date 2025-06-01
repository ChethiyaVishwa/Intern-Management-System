<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Suggestions & Improvements</title>
    <link rel="stylesheet" href=".css">
    <style>
                /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150vh;
            margin: 0;
        }

        /* Feedback Form Container */
        .feedback-container {
            background-color: #0a199e;
            padding: 30px;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0px 0px 15px rgba(255, 0, 100, 0.3);
            text-align: center;
        }

        h1 {
            font-size: 22px;
        }

        h3 {
            font-size: 16px;
            color: #aaa;
            margin-bottom: 10px;
        }

        .progress-bar {
            width: 100%;
            height: 5px;
            background: #1daa5c;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Labels & Inputs */
        label {
            display: block;
            font-size: 14px;
            margin: 10px 0 5px;
            text-align: left;
        }

        textarea {
            width: 100%;
            height: 80px;
            padding: 10px;
            border-radius: 5px;
            border: none;
            outline: none;
            resize: none;
            background-color:rgb(241, 243, 245);
            color:rgb(17, 16, 16);

        }

        /* Submit Button */
        button {
            width: 100%;
            padding: 12px;
            background: #1daa5c;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }

        button:hover {
            background: #00d146;
        }

        /* Responsive Design */
        @media (max-width: 500px) {
            .feedback-container {
                width: 90%;
            }
        }

    </style>
</head>
<body>
    <div class="feedback-container">
        <h3>CORPORATE TRAINING FEEDBACK</h3>
        <h1>Suggestions & Improvements</h1>
        <div class="progress-bar"></div>

        <form action="submit_feedback.php" method="POST">
            <!-- Hidden fields to carry data from the first form -->
            <input type="hidden" name="organization_rating" value="<?php echo $_POST['organization_rating']; ?>">
            <input type="hidden" name="expectations" value="<?php echo $_POST['expectations']; ?>">
            <input type="hidden" name="materials_rating" value="<?php echo $_POST['materials_rating']; ?>">

            <!-- Positives -->
            <label>What did you like about the training?</label>
            <textarea name="positives" placeholder="Describe the best aspects..." required></textarea>

            <!-- Negatives -->
            <label>What did you dislike or feel could be improved?</label>
            <textarea name="negatives" placeholder="Describe any issues or areas of improvement..." required></textarea>

            <!-- Additional Suggestions -->
            <label>Any additional suggestions?</label>
            <textarea name="suggestions" placeholder="Provide any further recommendations..."></textarea>

            <!-- Submit Button -->
            <button type="submit">Submit Feedback</button>
        </form>
    </div>

</body>
</html>