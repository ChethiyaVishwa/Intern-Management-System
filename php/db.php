<?php
$servername = "localhost";
$username = "root";  // Your MySQL username
$password = "";      // Your MySQL password
$dbname = "internship_portal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to handle special characters properly
$conn->set_charset("utf8mb4");

require_once __DIR__ . '/../vendor/autoload.php';



// session_start();

// init configuration
$clientID = '328613557058-2vlgubore5g2r1demrrua2o7isvl9n09.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'http://localhost/YouTube/php-google-login/welcome.php';

// create Client Request to access Google API
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

?>
