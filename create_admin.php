<?php
require_once 'config.php';

// Check if admin user already exists
$stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
$stmt->execute(['admin']);

if ($stmt->rowCount() > 0) {
    echo 'Admin account already exists: username=admin, password=admin123';
} else {
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $insert = $pdo->prepare('INSERT INTO users (username, password, role) VALUES (?, ?, ?)');
    $insert->execute(['admin', $hashed_password, 'admin']);
    echo 'Admin account created: username=admin, password=admin123';
}
?>
