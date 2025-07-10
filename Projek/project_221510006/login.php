<?php
session_start();
include 'config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (!$username || !$password) {
        $error = "Please enter username and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $password_hash, $role);
            $stmt->fetch();

            if (password_verify($password, $password_hash)) {
                // Login success
                $_SESSION['user_id'] = $id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;
                header("Location: index.php");  // redirect to main page
                exit;
            } else {
                $error = "Incorrect password.";
            }
        } else {
            $error = "Username not found.";
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
        <h2>Login</h2>
        <?php if ($error): ?>
        <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label><br>
            <input type="text" name="username" required><br><br>

            <label>Password:</label><br>
            <input type="password" name="password" required><br><br>

            <input type="submit" value="Login">
        </form>

        <p class="form-footer-text">Don't have an account? <a href="signup.php">Sign up here</a>.</p>
    </div>
</body>
</html>
