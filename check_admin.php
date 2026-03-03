<?php
require_once 'config.php';

$stmt = $pdo->query("SELECT username, role FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "Users in database:\n";
foreach ($users as $user) {
    echo "Username: " . $user['username'] . ", Role: " . $user['role'] . "\n";
}
?>
