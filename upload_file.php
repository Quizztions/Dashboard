<?php
// upload_file.php

include 'config.php'; // Include your database connection script

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['quiz-file'])) {
    $file = $_FILES['quiz-file']['tmp_name'];
    $fileType = $_FILES['quiz-file']['type'];

    $successCount = 0;
    $errorCount = 0;
    $errorMessages = [];

    // Validate file type
    if ($fileType == 'text/csv' || $fileType == 'application/vnd.ms-excel') {
        if (($handle = fopen($file, 'r')) !== FALSE) {
            $header = fgetcsv($handle); // Read the header row

            // Process each row
            while (($data = fgetcsv($handle)) !== FALSE) {
                $quiz_title = trim($data[0]); // Using quiz_title instead of quiz_id
                $question_text = trim($data[1]);
                $option_1 = trim($data[2]);
                $option_2 = trim($data[3]);
                $option_3 = trim($data[4]);
                $option_4 = trim($data[5]);
                $correct_option = trim($data[6]);

                // Check if any field is empty
                if (empty($quiz_title) || empty($question_text) || empty($option_1) || empty($option_2) || empty($option_3) || empty($option_4) || empty($correct_option)) {
                    $errorMessages[] = "Missing data for question: $question_text.";
                    $errorCount++;
                    continue;
                }

                

                // Fetch quiz_id using quiz_title
                $stmt = $pdo->prepare("SELECT id FROM quizzes WHERE quiz_title = ?");
                $stmt->execute([$quiz_title]);
                $quiz = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$quiz) {
                    $errorMessages[] = "Quiz with title '$quiz_title' not found.";
                    $errorCount++;
                    continue;
                }

                $quiz_id = $quiz['id']; // Get the quiz_id from the database

                // Insert the question into the database
                $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text, option_1, option_2, option_3, option_4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$quiz_id, $question_text, $option_1, $option_2, $option_3, $option_4, $correct_option]);

                $successCount++;
            }

            fclose($handle);

            // Provide final feedback message
            if ($errorCount > 0) {
                echo implode("\n", $errorMessages); // Output all error messages
                echo "\nFile upload completed with $successCount successful additions and $errorCount errors.";
            } else {
                echo "File uploaded and all $successCount questions added successfully!";
            }
        } else {
            echo "Failed to open the file.";
        }
    } else {
        echo "Invalid file type. Please upload a CSV file.";
    }
}
