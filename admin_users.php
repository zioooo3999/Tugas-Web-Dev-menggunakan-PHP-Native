<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

$message = '';

// Handle update user role request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_role'])) {
        $id = intval($_POST['id']);
        $role = $_POST['role'] === 'admin' ? 'admin' : 'buyer'; // sanitize role

        if ($id > 0) {
            $stmt = $pdo->prepare("UPDATE users SET role = ? WHERE id = ?");
            $stmt->execute([$role, $id]);
            $message = "User role updated successfully.";
        } else {
            $message = "Invalid user ID.";
        }
    }
}

// Fetch all users except self
$stmt = $pdo->prepare("SELECT id, username, role, created_at FROM users WHERE username != ? ORDER BY created_at DESC");
$stmt->execute([$_SESSION['username']]);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Users - Wartek</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f6f8fa; margin: 0; padding: 20px; }
        h1 { color: #2c3e50; }
        .message { color: green; font-weight: bold; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #ecf0f1; }
        form { margin: 0; }
        select { padding: 4px; }
        button { background-color: #2980b9; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #1c5980; }
    </style>
</head>
<body>
    <h1>Admin - Manage Users</h1>
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <form method="POST" action="admin_users.php">
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td>
                        <select name="role">
                            <option value="buyer" <?php echo $user['role'] === 'buyer' ? 'selected' : ''; ?>>Buyer</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                        <button type="submit" name="update_role">Update</button>
                    </td>
                </form>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
