<?php
session_start();
include ('include/config.php'); 

// Cek apakah nama_makanan atau nama_minuman ada di URL
if (isset($_GET['nama_makanan'])) {
    $nama_makanan = $_GET['nama_makanan']; // Mengambil nama makanan dari URL
    
    // Ambil data makanan dari database berdasarkan nama
    $query = "SELECT * FROM makanan WHERE nama_makanan = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_makanan); // Menggunakan 's' untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Pastikan makanan ditemukan
    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();  // Menyimpan data makanan ke $item
    } else {
        $item = null; // Jika tidak ditemukan
    }

} elseif (isset($_GET['nama_minuman'])) {
    $nama_minuman = $_GET['nama_minuman']; // Mengambil nama minuman dari URL
    
    // Ambil data minuman dari database berdasarkan nama
    $query = "SELECT * FROM minuman WHERE nama_minuman = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nama_minuman); // Menggunakan 's' untuk string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Pastikan minuman ditemukan
    if ($result && $result->num_rows > 0) {
        $item = $result->fetch_assoc();  // Menyimpan data minuman ke $item
    } else {
        $item = null; // Jika tidak ditemukan
    }
}

// Mengecek apakah $item sudah didefinisikan
if (isset($item)) {
    $nama_item = htmlspecialchars($item['nama_makanan'] ?? $item['nama_minuman']);  // Menampilkan nama item
    $harga_item = number_format($item['harga'], 0, ',', '.');  // Menampilkan harga item
} else {
    $nama_item = "Item tidak ditemukan";
    $harga_item = "N/A";
}

// Proses ketika formulir konfirmasi dikirimkan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['quantity']) && $_POST['quantity'] > 0) {
        $quantity = $_POST['quantity'];
        $total_harga = $item['harga'] * $quantity;
        
        // Simpan pemesanan ke database
        if (isset($_GET['nama_makanan'])) {
            // Insert data makanan, termasuk nama_makanan
            $query_pemesanan = "INSERT INTO pemesanan (makanan_id, nama_makanan, quantity, total_harga, status) 
                                VALUES (?, ?, ?, ?, 'pending')";
            $stmt_pemesanan = $conn->prepare($query_pemesanan);
            $stmt_pemesanan->bind_param("isid", $item['id'], $item['nama_makanan'], $quantity, $total_harga);
        } elseif (isset($_GET['nama_minuman'])) {
            // Insert data minuman, termasuk nama_minuman
            $query_pemesanan = "INSERT INTO pemesanan (minuman_id, nama_minuman, quantity, total_harga, status) 
                                VALUES (?, ?, ?, ?, 'pending')";
            $stmt_pemesanan = $conn->prepare($query_pemesanan);
            $stmt_pemesanan->bind_param("isid", $item['id'], $item['nama_minuman'], $quantity, $total_harga);
        }

        // Eksekusi query dan cek apakah berhasil
        if ($stmt_pemesanan->execute()) {
            echo "Pemesanan berhasil!<br>";
            // Redirect atau tampilkan pesan sukses
            header('Location: menu.php');
            exit;
        } else {
            echo "Pemesanan gagal! Error: " . $stmt_pemesanan->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Konfirmasi Pemesanan</h1>
    <p>Item: <?php echo $nama_item; ?></p>
    <p>Harga: Rp <?php echo $harga_item; ?></p>
    <form method="POST">
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity" min="1" value="1" required>
        <button type="submit">Konfirmasi</button>
    </form>
</body>
</html>
