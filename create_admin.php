<?php
require_once 'config/database.php';

// Delete existing admin first
$delete = $pdo->prepare("DELETE FROM users WHERE username = ?");
$delete->execute(['admin']);

// Create new admin
$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->execute([$username, $hashed_password]);

// Verify the user was created
$check = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$check->execute(['admin']);
$user = $check->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo "Admin user created successfully!<br>";
    echo "Username: admin<br>";
    echo "Password: admin123<br>";
} else {
    echo "Failed to create admin user!";
}
?>