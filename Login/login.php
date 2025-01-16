<?php
session_start();

// Daftar pengguna admin
$admin_users = [
    'rafi' => 'rawr',
    'ebin' => 'rawr',
];

// Ambil data dari form login
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($admin_users[$username]) && $admin_users[$username] === $password) {
        // Simpan username dan role admin ke session
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin';
        header('Location: ../index.php');
        exit;
    } elseif (!empty($username) && !empty($password)) {
        // Simpan username dan role pelanggan ke session
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'pelanggan';
        header('Location: ../menu.php');
        exit;
    } else {
        // Gagal login
        $_SESSION['error'] = "Username atau password salah. Silakan coba lagi.";
        header('Location: login.php');
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Logo.png" type="image/x-icon"></head>
<body>
    <h1>Silahkan Mengisi Form X-Kantin</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']);
    }
    ?>
    <form method="POST">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" required><br>
    <br>
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>

