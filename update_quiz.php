<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$query = "UPDATE quizzes SET quiz_title = :title, time_allotted = :time, num_questions = :questions WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->execute([
    ':id' => $data->id,
    ':title' => $data->title,
    ':time' => $data->time,
    ':questions' => $data->questions,
]);

echo json_encode(['message' => 'Quiz updated successfully!']);
?>
