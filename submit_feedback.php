<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from both pages
    $organization_rating = $_POST['organization_rating'];
    $expectations = $_POST['expectations'];
    $materials_rating = $_POST['materials_rating'];
    $positives = $_POST['positives'];
    $negatives = $_POST['negatives'];
    $suggestions = $_POST['suggestions'];

    // Email details
    $to = "hashidewmini0@gmail.com";
    $subject = "New Training Feedback Submission";
    $message = "
        Organization Rating: $organization_rating\n
        Expectations Met: $expectations\n
        Training Materials Rating: $materials_rating\n
        Positives: $positives\n
        Negatives: $negatives\n
        Suggestions: $suggestions
    ";
    $headers = "From: no-reply@example.com";

    // Send Email
    mail($to, $subject, $message, $headers);

    // Redirect to a thank you page
    header("Location: thankyou.html");
    exit();
}
?>