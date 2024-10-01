<?php
include 'config.php'; // Database connection

$student_id = $_GET['student_id'] ?? null;

if ($student_id && is_numeric($student_id)) {
    // Fetch student performance data
    $stmt = $pdo->prepare("
        SELECT s.name, s.roll_number, qr.quiz_title, qr.score, qr.attended_questions, qr.correct_answers, qr.wrong_answers
        FROM quiz_results qr
        JOIN students s ON qr.student_id = s.id
        WHERE s.id = ?
    ");
    $stmt->execute([$student_id]);

    $performance = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Start output with CSS styling
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Student Performance</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }
            h1 {
                text-align: center;
                color: #333;
                margin-bottom: 20px;
            }
            table {
                width: 100%;
                max-width: 900px;
                margin: 0 auto;
                border-collapse: collapse;
                background-color: #fff;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th {
                background-color: #007BFF;
                color: white;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            td {
                color: #555;
            }
            tr:nth-child(even) {
                background-color: #f9f9f9;
            }
            tr:hover {
                background-color: #f1f1f1;
            }
            h2 {
                text-align: center;
                color: #d9534f;
                margin-top: 30px;
            }
            @media (max-width: 768px) {
                table {
                    width: 100%;
                }
                th, td {
                    display: block;
                    text-align: right;
                    padding: 10px;
                    border-bottom: none;
                }
                td:before {
                    content: attr(data-label);
                    float: left;
                    font-weight: bold;
                    text-transform: uppercase;
                }
                tr {
                    border-bottom: 1px solid #ddd;
                    margin-bottom: 10px;
                    display: block;
                }
            }
        </style>
    </head>
    <body>";

    if ($performance) {
        $student_name = htmlspecialchars($performance[0]['name']);
        $student_roll_number = htmlspecialchars($performance[0]['roll_number']);

        // Display student performance
        echo "<h1>Performance of {$student_name} (Roll No: {$student_roll_number})</h1>";
        echo "<table>
                <tr>
                    <th>Quiz Title</th>
                    <th>Score</th>
                    <th>Attended Questions</th>
                    <th>Correct Answers</th>
                    <th>Wrong Answers</th>
                </tr>";
        foreach ($performance as $row) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['quiz_title']) . "</td>
                    <td>" . htmlspecialchars($row['score']) . "</td>
                    <td>" . htmlspecialchars($row['attended_questions']) . "</td>
                    <td>" . htmlspecialchars($row['correct_answers']) . "</td>
                    <td>" . htmlspecialchars($row['wrong_answers']) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<h2>No performance data found for this student.</h2>";
    }

    echo "</body></html>";
} else {
    echo "<h2>Invalid student ID.</h2>";
}
?>
