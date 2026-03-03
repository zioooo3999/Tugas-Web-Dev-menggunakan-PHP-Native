<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle form submissions for create, update, delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);

        if ($name && $price >= 0) {
            $stmt = $pdo->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $price]);
            $message = "Product created successfully.";
        } else {
            $message = "Product name and valid price are required.";
        }
    } elseif (isset($_POST['update'])) {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $price = floatval($_POST['price']);

        if ($id > 0 && $name && $price >= 0) {
            $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
            $stmt->execute([$name, $description, $price, $id]);
            $message = "Product updated successfully.";
        } else {
            $message = "Valid product ID, name and price are required.";
        }
    } elseif (isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        if ($id > 0) {
            $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $message = "Product deleted successfully.";
        } else {
            $message = "Valid product ID required for deletion.";
        }
    }
}

// Fetch all products
$products = $pdo->query("SELECT * FROM products ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Products - Wartek</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            color: #333;
        }

        h1 {
            color: #fff;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            font-weight: 700;
        }

        h2 {
            color: #fff;
            font-size: 1.8em;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .back-button {
            display: inline-block;
            background: rgba(255, 255, 255, 0.95);
            color: #667eea;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            margin-bottom: 20px;
            transition: transform 0.2s ease;
        }

        .back-button:hover {
            transform: translateY(-2px);
        }

        .message {
            color: #48bb78;
            margin-bottom: 15px;
            font-weight: bold;
            background: rgba(72, 187, 120, 0.1);
            padding: 10px;
            border-radius: 8px;
            border-left: 4px solid #48bb78;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        th, td {
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 15px;
            text-align: left;
        }

        th {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            font-weight: 600;
        }

        form {
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.95);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #4a5568;
            font-weight: 500;
        }

        input[type="text"], input[type="number"], textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        button {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: transform 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
        }

        .delete-button {
            background: linear-gradient(45deg, #e53e3e, #c53030);
        }

        .delete-button:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            body { padding: 10px; }
            h1 { font-size: 2em; }
            table { font-size: 14px; }
            th, td { padding: 10px; }
        }
    </style>
</head>
<body>
    <h1>Admin - Manage Products</h1>
    <a href="home.php" class="back-button">Back to Home</a>
    <a href="export_products.php" class="export-button">Export to Excel</a>
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <h2>Add New Product</h2>
    <form method="POST" action="admin_products.php">
        <input type="hidden" name="create" value="1" />
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required />

        <label for="description">Description</label>
        <textarea id="description" name="description"></textarea>

        <label for="price">Price (Rp)</label>
        <input type="number" step="0.01" id="price" name="price" required />

        <button type="submit">Add Product</button>
    </form>

    <h2>Existing Products</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Price (Rp)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <form method="POST" action="admin_products.php">
                    <td><?php echo htmlspecialchars($product['id']); ?><input type="hidden" name="id" value="<?php echo $product['id']; ?>" /></td>
                    <td><input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required /></td>
                    <td><textarea name="description"><?php echo htmlspecialchars($product['description']); ?></textarea></td>
                    <td><input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required /></td>
                    <td>
                        <button type="submit" name="update">Update</button>
                        <button type="submit" name="delete" class="delete-button" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
