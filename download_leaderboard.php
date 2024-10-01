<?php
// Fetch the quiz ID from the request
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Database connection (using PDO)
$pdo = new PDO("mysql:host=localhost;dbname=quiz_platform", "root", "");

// Fetch leaderboard data
$query = $pdo->prepare("
    SELECT students.name, students.roll_number, (quiz_results.score / quizzes.num_questions) * 100 AS score
    FROM quiz_results
    JOIN students ON quiz_results.student_id = students.id
    JOIN quizzes ON quiz_results.quiz_title = quizzes.quiz_title
    WHERE quizzes.id = ?
    ORDER BY score DESC
");
$query->execute([$quiz_id]);
$leaderboard = $query->fetchAll(PDO::FETCH_ASSOC);

// Set headers to force download as CSV file
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="quiz_leaderboard_' . $quiz_id . '.csv"');

// Open the output stream
$output = fopen('php://output', 'w');

// Output the column headings for CSV
fputcsv($output, ['Rank', 'Student Name', 'Roll Number', 'Score (%)']);

// Populate the data into the CSV file
$rank = 1;
foreach ($leaderboard as $student) {
    fputcsv($output, [
        $rank,
        $student['name'],
        $student['roll_number'],
        number_format($student['score'], 2) . '%'
    ]);
    $rank++;
}

// Close the file pointer
fclose($output);

// End the script after the CSV output
exit;
?>
