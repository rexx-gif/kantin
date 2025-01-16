<?php
session_start();
include('include/config.php');
include('include/OOPmakanan.php');
include('include/OOPminuman.php');

$makanan = new Makanan();
$datamakanan = $makanan->getMakanan();

$minuman = new Minuman();
$dataminuman = $minuman->getMinuman();

$query_makanan = "SELECT * FROM makanan";
$result_makanan = $conn->query($query_makanan); 
$num_rows_makanan = $result_makanan->num_rows;

$query_minuman = "SELECT * FROM minuman";
$result_minuman = $conn->query($query_minuman);
$num_rows_minuman = $result_minuman->num_rows;

if (isset($_GET['id_makanan'])) {
    // Pemesanan makanan
    $makanan_id = $_GET['id_makanan'];
    $quantity = $_POST['quantity'];
    
    // Ambil informasi makanan dari database
    $query = "SELECT * FROM makanan WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $makanan_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $makanan = $result->fetch_assoc();

    if ($makanan) {
        // Hitung total harga
        $total_harga = $makanan['harga'] * $quantity;
        
        // Simpan pemesanan ke database
        $user_id = $_SESSION['user_id']; // Ambil user_id dari session
        
        $query_pemesanan = "INSERT INTO pemesanan (user, makanan_id, quantity, total_harga, status) 
                            VALUES (?, ?, ?, ?, 'pending')";
        $stmt_pemesanan = $conn->prepare($query_pemesanan);
        $stmt_pemesanan->bind_param("iiid", $user_id, $makanan_id, $quantity, $total_harga);
        if ($stmt_pemesanan->execute()) {
            echo "Pemesanan berhasil!";
        } else {
            echo "Pemesanan gagal!";
        }
    }
} elseif (isset($_GET['id_minuman'])) {
    // Pemesanan minuman (mirip dengan pemesanan makanan)
    $minuman_id = $_GET['id_minuman'];
    $quantity = $_POST['quantity'];
    
    // Ambil informasi minuman dari database
    $query = "SELECT * FROM minuman WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $minuman_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $minuman = $result->fetch_assoc();

    if ($minuman) {
        // Hitung total harga
        $total_harga = $minuman['harga'] * $quantity;
        
        // Simpan pemesanan ke database
        $user_id = $_SESSION['user_id']; // Ambil user_id dari session
        
        $query_pemesanan = "INSERT INTO pemesanan (user_id, minuman_id, quantity, total_harga, status) 
                            VALUES (?, ?, ?, ?, 'pending')";
        $stmt_pemesanan = $conn->prepare($query_pemesanan);
        $stmt_pemesanan->bind_param("iiid", $user_id, $minuman_id, $quantity, $total_harga);
        if ($stmt_pemesanan->execute()) {
            echo "Pemesanan berhasil!";
        } else {
            echo "Pemesanan gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu X-Kantin</title>
    <link rel="stylesheet" href="style/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Logo.png" type="image/x-icon">
</head>
<body>
<nav class="navbar">
    <div class="logo"><img src="image/Logo.png" alt=""></div>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Menu <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="menu.php#makanan">Makanan <i class="fa-solid fa-burger"></i></a>
            <a href="menu.php#makanan">Makanan <i class="fa-solid fa-burger"></i></a>
            </div>  
        </li>
        <li class="dropdown">
            <a href="" class="dropbtn">Tambahkan <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="CUD/tambah_makanan.php">Makanan +</a>
            <a href="CUD/tambah_minuman.php">Minuman +</a>
            </div>  
        </li>
     </ul>
    <div class="menu-icon">
    <a href="Login/login.php"> <?php echo isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest'; ?> <i class="fa-solid fa-circle-user" style="color: #ffffff;"></i></a>
    </div>
</nav>

<section id="list">
        <h1 class="section-title">Makanan <i class="fa-solid fa-burger"></i></h1>
        <div class="list-container" id="makanan">
            <?php
            while ($row_makanan = $result_makanan->fetch_assoc()) {
            ?>
                <div class="list-card">
                    <h2 class="nama_makanan"><?php echo $row_makanan['nama_makanan']; ?></h2>
                    <p class="description"><?php echo $row_makanan['deskripsi']; ?></p>
                    <p class="price">Rp <?= number_format($row_makanan['harga'], 0, ',', '.'); ?></p>
                    <div class="list-actions">
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <a href="CUD/delete_makanan.php?id=<?php echo $row_makanan['id']; ?>" class="delete-btn">Delete</a>
                        <a href="CUD/update_makanan.php?id=<?php echo $row_makanan['id']; ?>" class="update-btn">Update</a>
                    <?php } elseif ($_SESSION['role'] == 'pelanggan') { ?>
                        <a href="order.php" class="buy-btn">Buy Now</a>
                    <?php } ?>
                </div>
                </div>
            <?php } ?>
        </div>
        <h1 class="section-title">Minuman <i class="fa-solid fa-wine-glass"></i></h1>
        <div class="list-container" id="minuman">
            <?php
            while ($row_minuman = $result_minuman->fetch_assoc()) {
            ?>
                <div class="list-card">
                    <h2><?php echo $row_minuman['nama_minuman']; ?></h2>
                    <p class="description"><?php echo $row_minuman['deskripsi']; ?></p>
                <p class="price">Rp <?= number_format($row_minuman['harga'], 0, ',', '.'); ?></p>
                    <div class="list-actions">
                        <a href="CUD/delete_minuman.php?id=<?php echo $row_minuman['id']; ?>" class="delete-btn">Delete</a>
                        <a href="CUD/update_minuman.php?id=<?php echo $row_minuman['id']; ?>" class="update-btn">Update</a>
                        <a href="order.php" class="buy-btn">Buy Now</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php $conn->close(); ?>
</body>
</html>
