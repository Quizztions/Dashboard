<?php
// add_quiz.php

include 'config.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_title = $_POST['quiz_title'];
    $num_questions = $_POST['num_questions'];
    $quiz_time = $_POST['quiz_time'];

    // Insert quiz into the database
    $stmt = $pdo->prepare("INSERT INTO quizzes (quiz_title, num_questions, time_allotted, created_at) VALUES (?, ?, ?, NOW())");
    
    if ($stmt->execute([$quiz_title, $num_questions, $quiz_time])) {
        echo "Quiz added successfully!";
    } else {
        echo "Error adding quiz.";
    }
}
?>
