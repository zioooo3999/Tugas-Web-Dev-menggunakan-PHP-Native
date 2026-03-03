<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message_text = trim($_POST['message']);
    if (!empty($message_text)) {
        $stmt = $pdo->prepare("INSERT INTO chat_messages (username, message) VALUES (?, ?)");
        $stmt->execute([$_SESSION['username'], $message_text]);
        header('Location: komunitas.php');
        exit;
    } else {
        $message = 'Message cannot be empty.';
    }
}

// Fetch chat messages
$stmt = $pdo->query("SELECT username, message, created_at FROM chat_messages ORDER BY created_at DESC LIMIT 50");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Komunitas - Wartek</title>
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

        .chat-container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.8);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.5);
            padding: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .chat-messages {
            height: 400px;
            overflow-y: auto;
            margin-bottom: 20px;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }

        .message {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.1);
        }

        .message strong {
            color: #fff;
        }

        .message small {
            color: #aaa;
        }

        .message-form {
            display: flex;
            gap: 10px;
        }

        .message-form input[type="text"] {
            flex: 1;
            padding: 12px;
            border: 1px solid #888;
            border-radius: 8px;
            background: #555;
            color: #fff;
            font-size: 16px;
        }

        .message-form input[type="text"]:focus {
            outline: none;
            border-color: #aaa;
        }

        .message-form button {
            background: linear-gradient(45deg, #444, #777);
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: transform 0.2s ease;
        }

        .message-form button:hover {
            transform: translateY(-2px);
            background: linear-gradient(45deg, #555, #888);
        }

        p.message {
            color: #ff6b6b;
            text-align: center;
            margin-bottom: 15px;
            font-weight: 500;
        }
    </style>
</head>
<body>
    <h1>Wartek Community Chat</h1>
    <a href="home.php" class="back-button">Back to Home</a>
    <div class="chat-container">
        <div class="chat-messages" id="chat-messages">
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <strong><?php echo htmlspecialchars($msg['username']); ?>:</strong> <?php echo htmlspecialchars($msg['message']); ?>
                    <br><small><?php echo $msg['created_at']; ?></small>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="komunitas.php" class="message-form">
            <input type="text" name="message" placeholder="Type your message..." required maxlength="500">
            <button type="submit">Send</button>
        </form>
    </div>
</body>
</html>
