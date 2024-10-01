<?php
// Database connection
$host = "localhost";
$db_name = "quiz_platform";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);
    exit();
}

// Start session
session_start();

// Ensure student_id is set in session
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Student ID is not set in session']);
    exit();
}

// Fetch student info from session
$student_id = $_SESSION['student_id'];

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['score']) || !isset($data['attended_questions']) || !isset($data['correct_answers']) || !isset($data['wrong_answers']) || !isset($data['quiz_title'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quiz result data']);
    exit();
}

$score = intval($data['score']);
$attended_questions = intval($data['attended_questions']);
$correct_answers = intval($data['correct_answers']);
$wrong_answers = intval($data['wrong_answers']);
$quiz_title = htmlspecialchars($data['quiz_title'], ENT_QUOTES, 'UTF-8');

if ($score < 0 || $attended_questions < 0 || $correct_answers < 0 || $wrong_answers < 0 || empty($quiz_title)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid quiz result data']);
    exit();
}

try {
    // Insert quiz results into database
    $stmt = $conn->prepare("INSERT INTO quiz_results (student_id, quiz_title, score, attended_questions, correct_answers, wrong_answers) VALUES (:student_id, :quiz_title, :score, :attended_questions, :correct_answers, :wrong_answers)");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->bindParam(':quiz_title', $quiz_title);
    $stmt->bindParam(':score', $score);
    $stmt->bindParam(':attended_questions', $attended_questions);
    $stmt->bindParam(':correct_answers', $correct_answers);
    $stmt->bindParam(':wrong_answers', $wrong_answers);
    $stmt->execute();

    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
