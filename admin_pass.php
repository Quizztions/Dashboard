<?php
require 'config.php'; // Ensure this path is correct

$username = 'admin'; // Update with your desired username
$password = 'admin'; // Plaintext password

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into the database
$stmt = $pdo->prepare("INSERT INTO admins (username, password) VALUES (:username, :password)");
$stmt->execute(['username' => $username, 'password' => $hashed_password]);

echo "New admin created with hashed password.";
?>
