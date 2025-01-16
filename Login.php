<?php
session_start();

$admin_users = [
    'rafi' => '$rafikeren=09',
    'ebin' => '$ebinrawr=32'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (isset($admin_users[$username]) && $admin_users[$username] === $password) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'admin';
        header('Location: admin.php');
        exit;
    } elseif (!empty($username) && !empty($password)) {
        $_SESSION['user'] = $username;
        $_SESSION['role'] = 'pelanggan';
        header('Location: user.php');
        exit;
    } else {
        $_SESSION['error'] = "Username atau password salah. Silakan coba lagi.";
        header('Location: Login.php');
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
</head>
<body>
    <h1>Login</h1>
    <?php
    // Tampilkan pesan error jika ada
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>{$_SESSION['error']}</p>";
        unset($_SESSION['error']); // Hapus pesan error setelah ditampilkan
    }
    ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>

