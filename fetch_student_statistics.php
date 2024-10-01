<?php
include 'config.php'; // Database connection

header('Content-Type: application/json');

try {
    // Fetch students who have participated in at least one quiz (based on quiz_results)
    $stmt = $pdo->query("
        SELECT s.id, s.name, s.roll_number
        FROM students s
        JOIN quiz_results qr ON s.id = qr.student_id
        GROUP BY s.id
        ORDER BY s.roll_number
    ");

    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($students) {
        echo json_encode(['success' => true, 'students' => $students]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No students found.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
