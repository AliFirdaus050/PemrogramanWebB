<?php
session_start();
include 'koneksi.php';

// Hitung jumlah keranjang untuk navbar
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
    <title>Home - FocusZone</title>
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
            color: #fff;
            font-size: 1.6rem;
            font-weight: 800;
        }

        .navbar .logo span {
            color: #e74c3c;
        }

        .navbar ul {
            list-style: none;
            display: flex;
            gap: 25px;
        }

        .navbar ul li a {
            text-decoration: none;
            color: #bdc3c7;
            font-weight: 500;
            transition: 0.3s;
        }

        .navbar ul li a:hover,
        .navbar ul li a.active {
            color: #fff;
        }

        .cart-badge {
            background: #e74c3c;
            color: white;
            padding: 2px 6px;
            border-radius: 50%;
            font-size: 0.7rem;
            vertical-align: top;
        }

        /* =========================================
           3. HERO SECTION
           ========================================= */
        .hero {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('https://images.unsplash.com/photo-1516035069371-29a1b244cc32?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            height: 500px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: white;
            padding: 20px;
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .btn-cta {
            background-color: #e74c3c;
            color: white;
            padding: 15px 40px;
            text-decoration: none;
            font-size: 1.1rem;
            border-radius: 30px;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(231, 76, 60, 0.4);
        }

        .btn-cta:hover {
            background-color: #c0392b;
            transform: translateY(-3px);
        }

        /* =========================================
           4. FEATURES SECTION
           ========================================= */
        .features {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 60px 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-box {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            flex: 1;
            transition: 0.3s;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
            display: block;
        }

        .feature-title {
            font-weight: bold;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        /* =========================================
           5. FOOTER STYLE
           ========================================= */
        footer {
            background: #2c3e50;
            color: #bdc3c7;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        /* =========================================
           6. MODAL POP-UP STYLE
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
            <li><a href="index.php" class="active" style="color:#fff;">Home</a></li>
            <li><a href="produk.php">Produk</a></li>
            <li>
                <a href="keranjang.php">Keranjang 
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
    <section class="hero">
        <h1>Abadikan Setiap Momen</h1>
        <p>Temukan kamera terbaik untuk kebutuhan fotografi dan videografi Anda. Kualitas terjamin dengan harga kompetitif hanya di FocusPoint.</p>
        <a href="produk.php" class="btn-cta">Belanja Sekarang</a>
    </section>
    <section class="features">
        <div class="feature-box">
            <span class="feature-icon">📷</span>
            <h3 class="feature-title">Produk Original</h3>
            <p>Semua kamera dan lensa yang kami jual dijamin 100% original dan bergaransi resmi.</p>
        </div>
        <div class="feature-box">
            <span class="feature-icon">🚚</span>
            <h3 class="feature-title">Pengiriman Cepat</h3>
            <p>Kami bekerja sama dengan ekspedisi terpercaya agar barang sampai dengan aman dan cepat.</p>
        </div>
        <div class="feature-box">
            <span class="feature-icon">🛡️</span>
            <h3 class="feature-title">Pembayaran Aman</h3>
            <p>Transaksi nyaman dengan berbagai metode pembayaran dan proteksi keamanan.</p>
        </div>
    </section>
    <footer>
        <p>&copy; 2024 FocusPoint Camera Store. All Rights Reserved.</p>
    </footer>
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

        // Tutup jika klik area gelap (overlay)
        window.onclick = function(event) {
            let modal = document.getElementById('loginModal');
            if (event.target == modal) {
                closeLogin();
            }
        }
    </script>
    </body>
</html>