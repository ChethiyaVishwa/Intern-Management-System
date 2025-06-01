<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organization_rating = $_POST['organization_rating'] ?? 'Not Rated';
    $expectations = $_POST['expectations'] ?? 'No Answer';
    $materials_rating = $_POST['materials_rating'] ?? 'Not Rated';

    // Store feedback in a text file (optional)
    $file = fopen("feedback_data.txt", "a");
    fwrite($file, "Organization Rating: $organization_rating\nExpectations Met: $expectations\nTraining Materials Rating: $materials_rating\n----------------------\n");
    fclose($file);

    // Email notification (optional)
    $to = "hashidewmini0@gmail.com";
    $subject = "New Training Feedback";
    $message = "Organization Rating: $organization_rating\nExpectations Met: $expectations\nTraining Materials Rating: $materials_rating";
    $headers = "From: no-reply@example.com";

    mail($to, $subject, $message, $headers);

    // Redirect after submission
    echo "<script>alert('Thank you for your feedback!'); window.location.href='index.html';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corporate Training Feedback</title>
    <link rel="stylesheet" href="./css/feedback.css">
</head>
<body>
     
    <div class="feedback-container">
        <h3>CORPORATE TRAINING FEEDBACK</h3>
        <h1>General Information</h1>
        <div class="progress-bar"></div>

        <form action="next_feedback.php" method="POST">
            <!-- Organization Rating -->
            <label>How would you rate the overall organization of the training event?</label>
            <div class="rating">
                <input type="radio" name="organization_rating" value="1" id="star1"><label for="star1">★</label>
                <input type="radio" name="organization_rating" value="2" id="star2"><label for="star2">★</label>
                <input type="radio" name="organization_rating" value="3" id="star3"><label for="star3">★</label>
                <input type="radio" name="organization_rating" value="4" id="star4"><label for="star4">★</label>
                <input type="radio" name="organization_rating" value="5" id="star5"><label for="star5">★</label>
            </div>

            <!-- Training Expectations -->
            <label>Did the training meet your expectations?</label>
            <div class="options">
                <input type="radio" name="expectations" value="Yes" id="yes">
                <label for="yes">Yes</label>

                <input type="radio" name="expectations" value="To some extent" id="some">
                <label for="some">To some extent</label>

                <input type="radio" name="expectations" value="Not at all" id="no">
                <label for="no">Not at all</label>
            </div>

            <!-- Training Materials Rating -->
            <label>How would you rate the training materials provided?</label>
            <div class="rating">
                <input type="radio" name="materials_rating" value="1" id="mat1"><label for="mat1">★</label>
                <input type="radio" name="materials_rating" value="2" id="mat2"><label for="mat2">★</label>
                <input type="radio" name="materials_rating" value="3" id="mat3"><label for="mat3">★</label>
                <input type="radio" name="materials_rating" value="4" id="mat4"><label for="mat4">★</label>
                <input type="radio" name="materials_rating" value="5" id="mat5"><label for="mat5">★</label>
            </div>

            <!-- Submit Button -->
            <button type="submit">Next →</button>
        </form>
    </div>
</body>
</html>