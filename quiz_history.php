<?php
// quiz_history.php

include 'config.php'; // Include your database connection script

// Prepare the SQL query to fetch quiz history
$sql = "SELECT q.quiz_title AS quizName, q.created_at AS date, q.num_questions AS totalQuestions, COUNT(r.result_id) AS participations
        FROM quizzes q
        LEFT JOIN quiz_results r ON q.quiz_id = r.quiz_id
        GROUP BY q.quiz_id, q.quiz_title, q.created_at, q.num_questions";

// Execute the query
$stmt = $pdo->query($sql);
$quizHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($quizHistory);
?>
