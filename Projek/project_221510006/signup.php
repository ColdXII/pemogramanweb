<?php
session_start();
include 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $role = $_POST['role'] === 'admin' ? 'admin' : 'viewer';  // only admin or viewer allowed

    if (!$username || !$password) {
        $error = "Please enter username and password.";
    } else {
        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Username already taken.";
        } else {
            // Insert new user
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password_hash, role) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $password_hash, $role);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit;
            } else {
                $error = "Error creating user: " . $stmt->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shoe Inventory</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Sign Up</h2>
        <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <label>Role:</label><br>
            <select name="role">
                <option value="viewer">Viewer</option>
                <option value="admin">Admin</option>
            </select><br><br><br>

            <input type="submit" value="Sign Up">
        </form>

        <p class="form-footer-text">Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
