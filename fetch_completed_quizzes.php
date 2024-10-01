<?php
// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection configuration
include 'config.php'; // Ensure this is the correct path to config.php

// Fetch the logged-in student's ID from the session
$student_id = $_SESSION['student_id'] ?? null;

if ($student_id) {
    // Prepare a SQL query to fetch the completed quizzes data for this student
    $sql = "SELECT quiz_title, score, attended_questions, correct_answers, wrong_answers 
            FROM quiz_results 
            WHERE student_id = :student_id";
    
    // Use PDO to execute the query
    $stmt = $pdo->prepare($sql); // Use $pdo instead of $conn
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch all the results
    $completed_quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the number of completed quizzes
    echo "<p>Total Completed Quizzes: " . count($completed_quizzes) . "</p>";

    // Debugging: Print raw data to check what is fetched
    // echo "<pre>";
    // print_r($completed_quizzes); 
    // echo "</pre>";

    // Check if any quizzes are available
    if ($completed_quizzes) {
        foreach ($completed_quizzes as $quiz) {
            // Debugging: Check if values are fetched properly
            $total_questions = $quiz['attended_questions']; // Assuming attended questions is total questions
            $score = $quiz['score'];
            $correct = $quiz['correct_answers'];
            $wrong = $quiz['wrong_answers'];
            
            echo "<tr>";
            echo "<td>" . htmlspecialchars($quiz['quiz_title']) . "</td>";
            echo "<td>" . htmlspecialchars($score) . "</td>";
            echo "<td>" . htmlspecialchars($total_questions) . "</td>";
            echo "<td>" . htmlspecialchars($correct) . "</td>";
            echo "<td>" . htmlspecialchars($wrong) . "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No completed quizzes found.</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>Student ID not found.</td></tr>";
}
