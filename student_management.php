<?php
// student_management.php

include 'config.php'; // Include your database connection script

$students = [];
$stmt = $pdo->query("SELECT * FROM students");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($students);
?>
