<?php
// student_dash.php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}

// Include the database connection
include 'config.php';

// Get the name from the session
$username = $_SESSION['username'];

// Fetch available quizzes
$stmt = $pdo->prepare("SELECT * FROM quizzes ORDER BY created_at DESC");
$stmt->execute();
$quizzes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Quizztions</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* [Your existing CSS styles here] */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background: url('bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        header {
            position: sticky;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            background: #002f6c;
            color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            z-index: 1000;
        }

        .logo {
            font-size: 1.8em;
            font-weight: 700;
        }

        .navbar a {
            font-size: 18px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            margin-left: 35px;
        }

        .navbar a:hover {
            color: rgba(112, 112, 112, 0.411);
            transition: .3s;
        }

        footer {
            
            bottom: 0;
            text-align: center;
            padding: 8px;
            background: #002f6c;
            color: #fff;
            font-size: 0.7em;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.3);
        }

        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #e0f7fa;
        }

        .welcome-box {
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            text-align: center;
            padding: 20px;
            margin: 30px auto;
            width: 100%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .dashboard-container {
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: 20px auto;
        }

        .box {
            background: #f9f9f9;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .box h2 {
            margin-top: 0;
            color: #1e3c72;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 15px 30px;
            font-size: 1.2em;
            color: #fff;
            background-color: #1e3c72;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
            margin: 10px;
        }

        .btn:hover {
            background-color: #2a5298;
            transform: scale(1.05);
        }

        .quiz-item {
            background: #fff;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9em;
        }

        .quiz-item h3 {
            margin: 0;
        }

        .quiz-item button {
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .quiz-item button:hover {
            background-color: #0056b3;
        }

        .profile-link {
            font-size: 18px;
            font-weight: bold;
            color: white;
            margin-left: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <header class="header">
        <div class="logo">Quizztions</div>
        <nav class="navbar">
            <a href="#">About</a>
            <a href="#">Services</a>
            <a href="logout.php">Logout</a>
            <a href="profile.html" class="profile-link">Profile</a>
        </nav>
    </header>

    <!-- Welcome Box outside the layout -->
    <div class="welcome-box">
        <h2>Welcome, <span id="student-name"><?php echo htmlspecialchars($username); ?></span></h2>
        <p>Get ready to test your knowledge!</p>
    </div>
    

    <div class="dashboard-container">
       

        <!-- Available Quizzes Box -->
        <div class="box">
            <h2>Available Quizzes</h2>
            <?php if (empty($quizzes)): ?>
                <p>No quizzes available at the moment.</p>
            <?php else: ?>
                <?php foreach ($quizzes as $quiz): ?>
                    <div class="quiz-item">
                        <h3><?php echo htmlspecialchars($quiz['quiz_title']); ?></h3>
                        <button class="btn" onclick="startQuiz(<?php echo $quiz['id']; ?>)">Start Quiz</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
         <!-- Completed Quizzes Box -->

        <div class="box">
            <h2>Completed Quizzes</h2>
            
            <table>
                <thead>
                    <tr>
                        <th>Quiz Title</th>
                        <th>Score</th>
                        <th>Attended Questions</th>
                        <th>Correct</th>
                        <th>Wrong</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include 'fetch_completed_quizzes.php'; ?>
                </tbody>
            </table>
        </div>

      

       
    </div>

        
    <footer>
        <div>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a> | <a href="#">Contact Us</a>
        </div>
        <div>
            © 2024 Quizztions. All rights reserved.
        </div>
    </footer>

    <script>
        function startQuiz(quizId) {
            window.location.href = 'quiz.html?quiz_id=' + quizId;
        }

        function viewResults() {
            window.location.href = 'student_results.html';
        }
    </script>
</body>

</html>
