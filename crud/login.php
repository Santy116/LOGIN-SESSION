<?php
session_start();
require_once '../config/database.php';
require_once '../models/User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $userData = $user->login($email, $password);

    if ($userData) {
        $_SESSION['user'] = [
            'id' => $userData['id'],
            'username' => $userData['username'],
            'email' => $userData['email'],
            'level' => $userData['level']
        ];

        if ($userData['level'] == 0) {
            header("Location: ../animals.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        $error = "Email atau password salah.";
    }
}
?>
<!-- Form Login -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Login</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
        <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>
