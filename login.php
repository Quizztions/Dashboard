<?php
session_start();
require 'config.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM students WHERE name = :name");
    $stmt->execute(['name' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Password is correct
        $_SESSION['student_id'] = $user['id']; // Changed to 'student_id'
        $_SESSION['username'] = $user['name'];
        header("Location: student_dash.php"); // Redirect to student dashboard
        exit();
    } else {
        // Invalid username or password
        echo "<script>alert('Invalid username or password.');window.location.href='login.html';</script>";
    }
}
?>
