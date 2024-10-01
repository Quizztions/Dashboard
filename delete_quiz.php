<?php
include 'config.php';

$data = json_decode(file_get_contents("php://input"));

$query = "DELETE FROM quizzes WHERE id = :id";
$stmt = $conn->prepare($query);
$stmt->execute([':id' => $data->id]);

echo json_encode(['message' => 'Quiz deleted successfully!']);
?>
