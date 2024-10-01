<?php
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$db_name = "quiz_platform";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}

// Fetch quiz details and questions from the database
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

if ($quiz_id <= 0) {
    echo json_encode(['error' => 'Invalid quiz ID']);
    exit();
}

$quizQuery = "SELECT * FROM quizzes WHERE id = :quiz_id";
$quizStmt = $conn->prepare($quizQuery);
$quizStmt->bindParam(":quiz_id", $quiz_id);
$quizStmt->execute();
$quiz = $quizStmt->fetch(PDO::FETCH_ASSOC);

if (!$quiz) {
    echo json_encode(['error' => 'Quiz not found']);
    exit();
}

$questionsQuery = "SELECT * FROM questions WHERE quiz_id = :quiz_id";
$questionsStmt = $conn->prepare($questionsQuery);
$questionsStmt->bindParam(":quiz_id", $quiz_id);
$questionsStmt->execute();

$questions = [];
while ($row = $questionsStmt->fetch(PDO::FETCH_ASSOC)) {
    $questions[] = [
        'question_text' => $row['question_text'],
        'options' => [
            $row['option_1'],
            $row['option_2'],
            $row['option_3'],
            $row['option_4']
        ],
        'correct_option' => intval($row['correct_option']) // Cast to int for comparison
    ];
}

// Return the quiz and questions as JSON
echo json_encode(['quiz' => $quiz, 'questions' => $questions]);
?>
