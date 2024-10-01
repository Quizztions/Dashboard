<?php
$host = 'localhost';
$db = 'quiz_platform';
$user = 'root';
$pass = '';

$conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = "SELECT q.id, q.quiz_title, q.time_allotted, q.num_questions, COUNT(r.student_id) as participants 
          FROM quizzes q 
          LEFT JOIN quiz_results r ON q.quiz_title = r.quiz_title 
          GROUP BY q.id";
$stmt = $conn->prepare($query);
$stmt->execute();

$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($quizzes);
?>
