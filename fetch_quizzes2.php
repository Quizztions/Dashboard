<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=quiz_platform", "root", "");

// Fetch quizzes
$query = $pdo->query("SELECT id, quiz_title FROM quizzes");
$quizzes = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($quizzes);
?>
