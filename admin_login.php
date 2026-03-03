<?php
session_start();
require_once 'config.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $message = 'Please fill in all fields.';
    } else {
        // Mencari admin berdasarkan username DAN email
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ? AND email = ?");
        $stmt->execute([$username, $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = 'admin';
            header('Location: admin_products.php');
            exit;
        } else {
            $message = 'Invalid admin username, email or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Wartek</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            max-width: 400px;
            width: 90%;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo h1 {
            margin: 0;
            color: #764ba2;
            font-size: 2.5em;
        }

        .logo p {
            margin: 5px 0 0;
            color: #718096;
            font-weight: 500;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        h2 {
            text-align: center;
            color: #4a5568;
            margin-bottom: 25px;
            font-weight: 600;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #4a5568;
            font-size: 14px;
        }

        input[type=text], 
        input[type=email], 
        input[type=password] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 16px;
            box-sizing: border-box;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            width: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.2s ease;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .message {
            background-color: #fff5f5;
            color: #e53e3e;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #feb2b2;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .link {
            text-align: center;
            margin-top: 25px;
        }

        .link p {
            margin: 8px 0;
            font-size: 14px;
        }

        .link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="logo">
            <h1>Wartek</h1>
            <p>Admin Panel</p>
        </div>

        <h2>Admin Login</h2>

        <?php if ($message): ?>
            <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form method="POST" action="admin_login.php">
            <label for="username">Admin Username</label>
            <input type="text" id="username" name="username" required placeholder="Enter admin username">

            <label for="email">Admin Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter admin email">

            <label for="password">Admin Password</label>
            <input type="password" id="password" name="password" required placeholder="Enter password">

            <button type="submit">Login as Admin</button>
        </form>

        <div class="link">
            <p><a href="admin_register.php">Register as Admin</a></p>
            <p><a href="login.php">Back to User Login</a></p>
            <p><a href="index.php">Back to Home</a></p>
        </div>
    </div>

</body>
</html>