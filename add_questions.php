<?php
// add_questions.php

include 'config.php'; // Include your database connection script

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $quiz_id = $_POST['quiz_id'];

    if (empty($quiz_id)) {
        echo json_encode(["success" => false, "message" => "Quiz ID is missing."]);
        exit;
    }

    try {
        $questions = $_POST['questions'];
        $errors = [];

        foreach ($questions as $question) {
            // Validate question input
            if (!empty($question['text']) && !empty($question['correct_option']) && 
                !empty($question['option_1']) && !empty($question['option_2']) && 
                !empty($question['option_3']) && !empty($question['option_4'])) {

                $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text, option_1, option_2, option_3, option_4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if (!$stmt->execute([
                    $quiz_id, 
                    trim($question['text']), 
                    trim($question['option_1']), 
                    trim($question['option_2']), 
                    trim($question['option_3']), 
                    trim($question['option_4']), 
                    trim($question['correct_option'])
                ])) {
                    $errors[] = "Failed to insert question: " . htmlspecialchars($question['text']);
                }
            } else {
                $errors[] = "Invalid question data for: " . htmlspecialchars($question['text']);
            }
        }

        if (!empty($errors)) {
            echo json_encode(["success" => false, "message" => "Some questions were not added: " . implode(', ', $errors)]);
        } else {
            echo json_encode(["success" => true, "message" => "Questions added successfully!"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Database error: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
