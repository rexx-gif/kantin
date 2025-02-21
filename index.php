<?php
session_start();

$username = isset($_SESSION['user']) ? $_SESSION['user'] : 'Guest';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest';

echo "<script> alert('Selamat datang, " . htmlspecialchars($username) . " di X-Kantin !') </script>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-Kantin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="image/Logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="image/Logo.png" alt="Logo Kantin">
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li class="dropdown">
                <a href="menu.php" class="dropbtn">Menu <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-content">
                    <a href="menu.php#makanan">Makanan</a>
                    <a href="menu.php#minuman">Minuman</a>
                </div>
            </li>
        </ul>
        <div class="menu-icon">
            <a href="Login/login.php"> <?php echo htmlspecialchars($username) . " (" . htmlspecialchars($role) . ")"; ?> <i class="fa-solid fa-circle-user" style="color: #ffffff;"></i></a>
        </div>
    </nav>
    <div class="background-container">
        <img src="image/background.png" alt="Background Image" class="background-image">
        <div class="text-container">
            <h1> Hi <?php echo htmlspecialchars($username); ?></h1>
            <h1>Welcome to X-Kantin</h1>
            <p>
                Kami menyajikan berbagai pilihan makanan dan minuman segar dengan harga terjangkau. 
                Nikmati suasana nyaman dan menu yang bervariasi, cocok untuk makan bersama teman 
                atau sekadar bersantai.
            </p>
        </div>
        
    <script>

        // Untuk transisi lapisan hitam saat link diklik
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
