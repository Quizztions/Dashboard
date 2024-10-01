<?php
// create_results_table.php

include 'config.php'; // Ensure this path is correct

function createResultsTable($quiz_id) {
    global $pdo;

    // Sanitize quiz_id to prevent SQL injection
    $quiz_id = intval($quiz_id);

    // Table name
    $table_name = "results_" . $quiz_id;

    // SQL to create the table
    $sql = "
    CREATE TABLE IF NOT EXISTS `$table_name` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        roll_number VARCHAR(50) NOT NULL,
        score INT NOT NULL,
        date_of_participation TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    // Execute the query
    try {
        $pdo->exec($sql);
        echo "Table $table_name created successfully.";
    } catch (PDOException $e) {
        echo "Error creating table: " . $e->getMessage();
    }
}

// Example usage
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['quiz_id'])) {
    $quiz_id = $_POST['quiz_id']; // Get quiz_id from POST request
    createResultsTable($quiz_id);
}
?>
