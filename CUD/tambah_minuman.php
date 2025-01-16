<?php
require_once '../include/config.php';

if (isset($_POST['submit'])) {
    $nama_minuman = $_POST['nama_minuman'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];

    $query = "INSERT INTO minuman (nama_minuman, deskripsi, harga) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ssi", $nama_minuman, $deskripsi, $harga);

        if ($stmt->execute()) {
            header('Location:../menu.php');
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Minuman</title>    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../image/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="../style/form.css">
</head>
<body>
<nav class="navbar">
    <div class="logo"><img src="../image/Logo.png" alt=""></div>
    <ul class="nav-links">
        <li><a href="../index.html">Home</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Menu <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="../menu.php#makanan">Makanan</a>
            <a href="../menu.php#minuman">Minuman</a>
            </div>  
        </li>
        <li class="dropdown">
            <a href="" class="dropbtn">Tambahkan <i class="fa-solid fa-caret-down"></i></a>
            <div class="dropdown-content">
            <a href="../CUD/tambah_makanan.php">Makanan +</a>
            <a href="../CUD/tambah_minuman.php">Minuman +</a>
            </div>  
        </li>
        <li><a href="#">Contact</a></li>
    </ul>
    <div class="menu-icon">
    </div>
</nav>

    <form action="" method="post">
        <h1>Tambah Minuman</h1>
        <label for="minuman">Nama Minuman :</label>
        <input type="text" id="minuman" name="nama_minuman" required>
        <label for="deskripsi">Deskripsi Minuman : </label>
        <input type="text" name="deskripsi" id="deskripsi" required>
        <label for="harga">Harga Minuman : </label>
        <input type="number" id="harga" name="harga" required>
        <button type="submit" name="submit">Tambah</button>
    </form>
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

    const links = document.querySelectorAll("a");

    links.forEach(link => {
        link.addEventListener("click", (event) => {
            const href = link.getAttribute("href");
            if (href && !href.startsWith("#") && !href.startsWith("javascript")) {
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
