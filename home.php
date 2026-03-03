<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home - Wartek</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #e9ecef; margin: 0; padding: 0; }
        header { background-color: #007bff; color: white; padding: 15px 20px; }
        h1 { margin: 0; }
        nav { margin-top: 10px; }
        nav a { color: white; margin-right: 15px; text-decoration: none; font-weight: bold;}
        nav a:hover { text-decoration: underline; }
        .container { max-width: 960px; margin: 20px auto; }
        .welcome { font-size: 1.2em; margin-bottom: 20px; }
        .content { background: white; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .admin-links a { display: inline-block; margin: 10px 10px 10px 0; padding: 10px 15px; background-color: #28a745; color: white; border-radius: 4px; text-decoration: none; }
        .admin-links a:hover { background-color: #218838; }
    </style>
</head>
<body>
    <header>
        <h1>Wartek: Warung Teknologi</h1>
        <nav>
            <a href="home.php">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <div class="container">
        <div class="welcome">
            Hello, <?php echo htmlspecialchars($username); ?>! You are logged in as <?php echo htmlspecialchars($role); ?>.
        </div>
        <div class="content">
        <?php if ($role === 'admin'): ?>
            <div class="admin-links">
                <a href="admin_products.php">Manage Products</a>
                <a href="admin_users.php">Manage Users</a>
            </div>
        <?php else: ?>
            <p>Welcome to Wartek, your go-to place for technology products.</p>
            <p>Explore our latest products and start shopping!</p>
            <a href="products.php">View Products</a>
        <?php endif; ?>
        </div>
    </div>
</body>
</html>
