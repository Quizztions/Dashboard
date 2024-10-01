<?php
// insert_results.php

include 'config.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quiz_id = intval($_POST['quiz_id']);
    $name = $_POST['name'];
    $roll_number = $_POST['roll_number'];
    $score = intval($_POST['score']);
    
    // Table name
    $table_name = "results_" . $quiz_id;

    // SQL to insert the result
    $sql = "INSERT INTO `$table_name` (name, roll_number, score) VALUES (:name, :roll_number, :score)";
    
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'name' => $name,
            'roll_number' => $roll_number,
            'score' => $score
        ]);
        echo "Result inserted successfully.";
    } catch (PDOException $e) {
        echo "Error inserting result: " . $e->getMessage();
    }
}
?>
