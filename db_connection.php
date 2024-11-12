<?php
// Database configuration
$host = 'localhost';
$dbname = 'learntogether';
$username = 'root';  // Default username for local server like WAMP/XAMPP
$password = '';      // Default password for local server like WAMP/XAMPP

try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Enable emulated prepared statements (helpful for older versions of MySQL)
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    

} catch (PDOException $e) {
    // If there's an error, display a message and stop further execution
    die("Database connection failed: " . $e->getMessage());
}
?>
