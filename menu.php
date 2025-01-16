<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="style/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Logo.png" type="image/x-icon">
</head>
<body>
<nav class="navbar">
    <div class="logo"><img src="image/Logo.png" alt=""></div>
    <ul class="nav-links">
        <li><a href="index.html">Home</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Menu <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="menu.php#makanan">Makanan</a>
            <a href="menu.php#minuman">Minuman</a>
            </div>  
        </li>
        <li class="dropdown">
            <a href="" class="dropbtn">Tambahkan <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="CUD/tambah_makanan.php">Makanan +</a>
            <a href="CUD/tambah_minuman.php">Minuman +</a>
            </div>  
        </li>
        <li><a href="#">Contact</a></li>
    </ul>
    <div class="menu-icon">
    </div>
</nav>


<section id="list">
        <h1 class="section-title">Makanan <i class="fa-solid fa-burger"></i></h1>
        <div class="list-container" id="makanan">
            <?php
            while ($row_makanan = $result_makanan->fetch_assoc()) {
            ?>
                <div class="list-card">
                    <h2><?php echo $row_makanan['nama_makanan']; ?></h2>
                    <p class="description"><?php echo $row_makanan['deskripsi']; ?></p>
                    <p class="price">Rp <?= number_format($row_makanan['harga'], 0, ',', '.'); ?></p>
                    <div class="list-actions">
                        <a href="CUD/delete_makanan.php?id=<?php echo $row_makanan['id']; ?>" class="delete-btn">Delete</a>
                        <a href="CUD/update_makanan.php?id=<?php echo $row_makanan['id']; ?>" class="update-btn">Update</a>
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
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php $conn->close(); ?>
    <script>
document.addEventListener("DOMContentLoaded", () => {
    const transitionLayer = document.createElement("div");
    transitionLayer.style.position = "fixed";
    transitionLayer.style.top = "0";
    transitionLayer.style.left = "0";
    transitionLayer.style.width = "100%";
    transitionLayer.style.height = "100%";
    transitionLayer.style.backgroundColor = "black";
    transitionLayer.style.zIndex = "9999";
    transitionLayer.style.opacity = "0";
    transitionLayer.style.pointerEvents = "none";
    transitionLayer.style.transition = "opacity 1s ease-in-out";
    document.body.appendChild(transitionLayer);

    const allLinks = document.querySelectorAll("a");
    
    allLinks.forEach(link => {
        link.addEventListener("click", (event) => {
            const href = link.getAttribute("href");

            // Cek apakah link ada di dalam dropdown
            const isDropdownLink = link.closest(".dropdown-content");

            if (href && !href.startsWith("#") && !href.startsWith("javascript") && !isDropdownLink) {
                event.preventDefault();
                transitionLayer.style.pointerEvents = "auto";
                transitionLayer.style.opacity = "1";

                setTimeout(() => {
                    window.location.href = href;
                }, 1000);
            }
        });
    });

    window.addEventListener("pageshow", () => {
        transitionLayer.style.opacity = "0";
        setTimeout(() => {
            transitionLayer.style.pointerEvents = "none";
        }, 1000);
    });
});

    </script>
</body>
</html>
