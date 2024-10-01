<?php
session_start();
require 'config.php'; // Updated path to config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['admin_username'];
    $password = $_POST['admin_password'];

    // Prepare SQL statement to prevent SQL injection
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        // Password is correct
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        // Redirect to admin dashboard
        header("Location: ../admin/admin_dashboard.html"); // Updated path to admin_dashboard.html
        exit();
    } else {
        // Invalid username or password
        echo "<script>alert('Invalid username or password.');window.location.href='admin_login.html';</script>";
    }
}
?>
