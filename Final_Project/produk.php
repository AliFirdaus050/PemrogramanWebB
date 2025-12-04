<?php
session_start();
include 'koneksi.php';

// Ambil data produk dari database
$query = mysqli_query($conn, "SELECT * FROM products ORDER BY id ASC");

// Hitung jumlah barang di keranjang untuk navbar
$jumlah_keranjang = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty) {
        $jumlah_keranjang += $qty;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - FocusZone</title>
    <style>
        /* =========================================
           1. RESET & BASIC STYLE
           ========================================= */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background-color: #f4f8fb;
            color: #333;
            padding-bottom: 50px;
        }

        /* =========================================
           2. NAVBAR STYLE
           ========================================= */
        .navbar {
            background-color: #2c3e50;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .logo {
            color: #ffffff;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .navbar .logo span {
            color: #e74c3c;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            transition: color 0.3s;
            font-size: 0.95rem;
        }

        .navbar ul li a:hover,
        .navbar ul li a.active {
            color: #ffffff;
        }

        .cart-badge {
            background-color: #e74c3c;
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 50%;
            position: absolute;
            top: -8px;
            right: -10px;
        }

        .cart-icon {
            position: relative;
        }

        /* =========================================
           3. PRODUCT GRID STYLE
           ========================================= */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h2.section-title {
            text-align: center;
            margin-bottom: 40px;
            color: #2c3e50;
            position: relative;
            font-size: 1.8rem;
        }

        h2.section-title::after {
            content: '';
            display: block;
            width: 60px;
            height: 3px;
            background: #e74c3c;
            margin: 10px auto 0;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            border-color: #e74c3c;
        }

        .image-container {
            padding: 20px;
            background: #fff;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid #f0f0f0;
        }

        .product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .product-info {
            padding: 20px;
            text-align: center;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-name {
            font-size: 1.1rem;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 700;
        }

        .product-price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .btn-buy {
            margin-top: auto;
            display: inline-block;
            background-color: #2c3e50;
            color: white;
            padding: 10px 0;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            transition: background 0.3s;
            width: 100%;
        }

        .btn-buy:hover {
            background-color: #e74c3c;
        }

        .empty-alert {
            grid-column: 1 / -1;
            text-align: center;
            padding: 50px;
            color: #777;
            font-style: italic;
        }

        /* =========================================
           4. MODAL POP-UP STYLE (WAJIB ADA AGAR TIDAK BOCOR)
           ========================================= */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }

        .modal-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            position: relative;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-box h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn-login-submit {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            width: 100%;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: bold;
        }

        .btn-close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
            color: #aaa;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Focus<span>Zone</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="produk.php" class="active" style="color:#fff;">Produk</a></li>
            
            <li>
                <a href="keranjang.php" class="cart-icon">
                    Keranjang
                    <?php if($jumlah_keranjang > 0): ?>
                        <span class="cart-badge"><?= $jumlah_keranjang ?></span>
                    <?php endif; ?>
                </a>
            </li>

            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="#" style="color:#e74c3c;">Halo, <?= $_SESSION['user']['nama'] ?></a></li>
                <li><a href="login.php?logout=true">Logout</a></li>
            <?php else: ?>
                <li><a href="#" onclick="openLogin(); return false;">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="container">
        <h2 class="section-title">Katalog Kamera</h2>

        <div class="product-grid">
            <?php 
            if (mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) { 
            ?>
                <div class="product-card">
                    <div class="image-container">
                        <img src="images/<?= $row['image']; ?>" alt="<?= $row['name']; ?>" class="product-image">
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?= $row['name']; ?></h3>
                        <p class="product-price">Rp <?= number_format($row['price'], 0, ',', '.'); ?></p>
                        <a href="detail.php?id=<?= $row['id']; ?>" class="btn-buy">Lihat Detail</a>
                    </div>
                </div>
            <?php 
                } 
            } else {
                echo "<div class='empty-alert'>Belum ada produk yang tersedia saat ini.</div>";
            }
            ?>
        </div>
    </div>

    <div id="loginModal" class="modal-overlay">
        <div class="modal-box">
            <span class="btn-close" onclick="closeLogin()">&times;</span>
            <h2>Login Member</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="user@gmail.com" required>
                </div>
                <div class="input-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukan password" required>
                </div>
                <button type="submit" name="login" class="btn-login-submit">MASUK SEKARANG</button>
            </form>
            <p style="margin-top: 10px; font-size: 0.9rem;">
                Belum punya akun? <a href="#">Daftar disini</a>
            </p>
        </div>
    </div>
    <script>
        function openLogin() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function closeLogin() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Tutup jika klik area gelap
        window.onclick = function(event) {
            let modal = document.getElementById('loginModal');
            if (event.target == modal) {
                closeLogin();
            }
        }
    </script>
    </body>
</html>