<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Fetch products from database
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Products - Wartek</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #333 0%, #666 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            color: #ccc;
        }

        h1 {
            color: #fff;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            font-weight: 700;
        }

        .back-button {
            display: inline-block;
            background: rgba(0, 0, 0, 0.8);
            color: #aaa;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }

        .back-button:hover {
            transform: translateY(-2px);
            color: #ccc;
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product {
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.7);
        }

        .product h3 {
            margin-top: 0;
            color: #fff;
            font-size: 1.4em;
            font-weight: 600;
            border-bottom: 2px solid #aaa;
            padding-bottom: 10px;
        }

        .product p {
            font-size: 0.95em;
            color: #aaa;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .price {
            font-weight: 700;
            font-size: 1.3em;
            color: #fff;
            margin-top: 15px;
            text-align: right;
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            h1 { font-size: 2em; }
            .product-list { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <h1>Wartek Products</h1>
    <a href="home.php" class="back-button">Back to Home</a>
    <div class="product-list">
    <?php foreach ($products as $product): ?>
        <div class="product">
            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <div class="price">Rp <?php echo number_format($product['price'], 2, ',', '.'); ?></div>
        </div>
    <?php endforeach; ?>
    </div>
</body>
</html>
