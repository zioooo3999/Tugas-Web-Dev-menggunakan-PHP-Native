

pj<?php
require_once 'config.php';

$username = 'admin';
$password = 'admin123';

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    echo "Login successful for admin. Role: " . $user['role'];
} else {
    echo "Login failed for admin.";
}
?>
