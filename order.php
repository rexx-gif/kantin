<?php
include('include/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity']; 
    $type = $_POST['type']; 

    $query_menu = $type === "makanan" 
        ? "SELECT harga FROM makanan WHERE id = ?" 
        : "SELECT harga FROM minuman WHERE id = ?";

    $stmt_menu = $conn->prepare($query_menu);
    $stmt_menu->bind_param("i", $menu_id);
    $stmt_menu->execute();
    $result = $stmt_menu->get_result();
    $menu = $result->fetch_assoc();

    if ($menu) {
        $harga = $menu['harga'];
        $total_harga = $harga * $quantity;

        $query_insert = "INSERT INTO pemesanan (user_id, menu_id, total_harga, type) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($query_insert);
        $stmt_insert->bind_param("iiis", $user_id, $menu_id, $total_harga, $type);

        if ($stmt_insert->execute()) {
            echo "Pemesanan berhasil dilakukan!";
        } else {
            echo "Gagal melakukan pemesanan. Silakan coba lagi.";
        }
    } else {
        echo "Menu tidak ditemukan.";
    }
} else {
    echo "Akses tidak valid.";
}
?>
