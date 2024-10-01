<?php
// Database connection
$pdo = new PDO("mysql:host=localhost;dbname=quiz_platform", "root", "");

// Fetch leaderboard data for a specific quiz
$quiz_id = $_GET['quiz_id'];
$query = $pdo->prepare("
    SELECT students.name, students.roll_number, (quiz_results.score / quizzes.num_questions) * 100 as score
    FROM quiz_results
    JOIN students ON quiz_results.student_id = students.id
    JOIN quizzes ON quiz_results.quiz_title = quizzes.quiz_title
    WHERE quizzes.id = ?
    ORDER BY score DESC
");
$query->execute([$quiz_id]);
$leaderboard = $query->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($leaderboard);
?>
