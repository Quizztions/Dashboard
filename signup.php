<?php
require 'config.php'; // Ensure this path is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $rollNumber = $_POST['roll_number'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match.');window.location.href='signup.html';</script>";
        exit();
    }

    // Check if user already exists
    $stmt = $pdo->prepare("SELECT * FROM students WHERE roll_number = :roll_number");
    $stmt->execute(['roll_number' => $rollNumber]);
    if ($stmt->fetch()) {
        echo "<script>alert('Roll number already exists.');window.location.href='signup.html';</script>";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $pdo->prepare("INSERT INTO students (name, roll_number, password) VALUES (:name, :roll_number, :password)");
    if ($stmt->execute(['name' => $name, 'roll_number' => $rollNumber, 'password' => $hashedPassword])) {
        echo "<script>alert('Sign-up successful!');window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Sign-up failed. Please try again.');window.location.href='signup.html';</script>";
    }
}
?>
