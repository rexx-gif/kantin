<?php
session_start();
include('include/config.php'); // Database connection

// Pastikan user sudah login
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

// Ambil nama pelanggan dari sesi
$nama_pelanggan = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';

// Cek apakah ada makanan atau minuman di URL
if (isset($_GET['nama_makanan'])) {
    $nama_makanan = $_GET['nama_makanan'];
    $query = "SELECT * FROM makanan WHERE nama_makanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_makanan);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
} elseif (isset($_GET['nama_minuman'])) {
    $nama_minuman = $_GET['nama_minuman'];
    $query = "SELECT * FROM minuman WHERE nama_minuman = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_minuman);
    $stmt->execute();
    $result = $stmt->get_result();
    $item = $result->fetch_assoc();
} else {
    $item = null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];
    $total_harga = $item['harga'] * $quantity;

    if (isset($_GET['nama_makanan'])) {
        $query_pemesanan = "INSERT INTO pemesanan (nama_pelanggan, makanan_id, nama_makanan, quantity, total_harga, status) 
                            VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt_pemesanan = $conn->prepare($query_pemesanan);
        $stmt_pemesanan->bind_param("sisid", $nama_pelanggan, $item['id'], $item['nama_makanan'], $quantity, $total_harga);
    } elseif (isset($_GET['nama_minuman'])) {
        $query_pemesanan = "INSERT INTO pemesanan (nama_pelanggan, minuman_id, nama_minuman, quantity, total_harga, status) 
                            VALUES (?, ?, ?, ?, ?, 'pending')";
        $stmt_pemesanan = $conn->prepare($query_pemesanan);
        $stmt_pemesanan->bind_param("sisid", $nama_pelanggan, $item['id'], $item['nama_minuman'], $quantity, $total_harga);
    }

    if ($stmt_pemesanan->execute()) {
        echo "Pemesanan berhasil!";
        header('Location: menu.php');
        exit;
    } else {
        echo "Pemesanan gagal! Error: " . $stmt_pemesanan->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
    <h1>Menu</h1>
    <p>Nama Pelanggan: <?php echo htmlspecialchars($nama_pelanggan); ?></p>
    <?php if ($item): ?>
        <p>Item: <?php echo htmlspecialchars($item['nama_makanan'] ?? $item['nama_minuman']); ?></p>
        <p>Harga: Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></p>
        <form method="POST">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" required>
            <button type="submit">Pesan</button>
        </form>
    <?php else: ?>
        <p>Item tidak ditemukan.</p>
    <?php endif; ?>
</body>
</html>
