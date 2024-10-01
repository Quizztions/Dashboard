<?php
// Database configuration
$host = 'localhost'; // Your database host
$db = 'quiz_platform'; // Your database name
$user = 'root'; // Your MySQL username
$pass = ''; // Your MySQL password

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=utf8";

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Catch any connection errors
    die("Connection failed: " . $e->getMessage());
}
?>
