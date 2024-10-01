<?php
// Include database connection file
require 'config.php'; // Update with your actual connection file path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $username = $_POST['username'];
    $roll_no = $_POST['roll_no'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    try {
        // Prepare the SQL statement to update the password
        $sql = "UPDATE students SET password = :password WHERE name = :username AND roll_number = :roll_no";
        $stmt = $pdo->prepare($sql);
        
        // Bind the parameters
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':roll_no', $roll_no);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Password updated successfully!'); window.location.href = 'login.html';</script>";
        } else {
            echo "<script>alert('Error updating password. Please try again later.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        // Handle potential errors
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
