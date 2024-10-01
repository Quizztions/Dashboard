<?php
include 'config.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['name']) && isset($_GET['roll_number'])) {
    $name = $_GET['name'];
    $roll_number = $_GET['roll_number'];

    // Fetch all quiz IDs from a source, e.g., quizzes table
    $quiz_ids = []; // Populate this array with quiz IDs based on your quiz list or other logic

    $results = [];
    foreach ($quiz_ids as $quiz_id) {
        $table_name = "results_" . intval($quiz_id);

        // SQL to fetch results
        $sql = "SELECT score, date_of_participation FROM `$table_name` WHERE name = :name AND roll_number = :roll_number";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'name' => $name,
                'roll_number' => $roll_number
            ]);
            $results = array_merge($results, $stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            echo json_encode(["error" => "Error fetching results: " . $e->getMessage()]);
            exit;
        }
    }

    // Return the results as JSON
    header('Content-Type: application/json');
    echo json_encode($results);
} else {
    // Handle missing parameters
    header('Content-Type: application/json');
    echo json_encode(["error" => "Name and roll number parameters are required."]);
}
?>
