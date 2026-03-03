<?php
require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT username, role FROM users WHERE username = 'admin'");
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo "Admin user found: " . $user['username'] . " with role: " . $user['role'];
    } else {
        echo "Admin user not found in database.";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
