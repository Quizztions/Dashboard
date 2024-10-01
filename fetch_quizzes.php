<?php
// Database connection
$host = 'localhost';
$dbname = 'quiz_platform';
$username = 'root';  // Your database username
$password = '';      // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all quizzes from the 'quizzes' table
    $stmt = $pdo->query("SELECT * FROM quizzes");
    $quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($quizzes);

} catch (PDOException $e) {
    echo 'Database error: ' . $e->getMessage();
}
?>
