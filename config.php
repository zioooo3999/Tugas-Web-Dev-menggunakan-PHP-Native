<?php
// Database configuration for Wartek: Warung Teknologi

$host = 'localhost';
$dbname = 'wartek';
$user = 'root';
$pass = '';

// Create connection
try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    // Create tables
    // Users table (for buyers)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Admins table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Products table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10,2) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Ensure created_at column exists (for existing tables without it)
    $result = $pdo->query("SHOW COLUMNS FROM products LIKE 'created_at'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE products ADD created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP");
    }

    // Ensure role column exists in users table (for existing tables without it)
    $result = $pdo->query("SHOW COLUMNS FROM users LIKE 'role'");
    if ($result->rowCount() == 0) {
        $pdo->exec("ALTER TABLE users ADD role VARCHAR(20) DEFAULT 'buyer'");
    }

} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>
