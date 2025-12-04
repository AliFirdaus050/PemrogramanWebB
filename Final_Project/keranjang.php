<?php
session_start();
include 'koneksi.php';

// ---------------------------------------------------
// LOGIKA 1: HAPUS PRODUK
// ---------------------------------------------------
if (isset($_GET['hapus'])) {
    $id_hapus = $_GET['hapus'];
    unset($_SESSION['cart'][$id_hapus]);
    echo "<script>alert('Produk dihapus dari keranjang'); location='keranjang.php';</script>";
}

// ---------------------------------------------------
// LOGIKA 2: HITUNG KERANJANG (NAVBAR)
// ---------------------------------------------------
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
    <title>Keranjang - FocusZone</title>
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

        .navbar ul li a:hover {
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
           3. CART TABLE STYLE
           ========================================= */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .table-cart {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table-cart th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .table-cart td {
            padding: 15px;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
        }

        .table-cart img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* =========================================
           4. BUTTONS
           ========================================= */
        .btn-hapus {
            color: #e74c3c;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .btn-checkout {
            display: inline-block;
            background-color: #2c3e50;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            float: right;
            transition: 0.3s;
            cursor: pointer;
            border: none;
            font-size: 1rem;
        }

        .btn-checkout:hover {
            background-color: #27ae60;
        }

        .btn-back {
            display: inline-block;
            background-color: #95a5a6;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s;
        }

        /* Empty State */
        .empty-cart {
            text-align: center;
            padding: 50px 20px;
        }
        .empty-cart-icon {
            font-size: 5rem;
            color: #bdc3c7;
            margin-bottom: 20px;
        }

        /* =========================================
           5. MODAL POP-UP STYLE
           ========================================= */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
            justify-content: center; align-items: center;
        }

        .modal-box {
            background: white; padding: 30px; border-radius: 10px; width: 350px;
            text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative;
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .modal-box h2 { margin-bottom: 20px; color: #2c3e50; }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        
        .btn-login-submit {
            background-color: #e74c3c; color: white; border: none; padding: 10px 20px;
            width: 100%; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: bold;
        }
        
        .btn-close { position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer; color: #aaa; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Focus<span>Zone</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="produk.php">Produk</a></li>
            <li>
                <a href="keranjang.php" style="color:white;">Keranjang 
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
        <h2>Keranjang Belanja Anda</h2>

        <?php if (empty($_SESSION['cart'])): ?>
            
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3>Wah, keranjangmu masih kosong nih.</h3>
                <p>Yuk, cari kamera impianmu sekarang!</p>
                <br>
                <a href="produk.php" class="btn-checkout" style="float: none; background: #e74c3c;">Mulai Belanja</a>
            </div>

        <?php else: ?>

            <table class="table-cart">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $total_bayar = 0;
                    foreach ($_SESSION['cart'] as $id_produk => $jumlah): 
                        $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id_produk'");
                        $pecah = mysqli_fetch_assoc($query);
                        $subtotal = $pecah['price'] * $jumlah;
                        $total_bayar += $subtotal;
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><img src="images/<?= $pecah['image']; ?>" alt="Foto Produk"></td>
                        <td><?= $pecah['name']; ?></td>
                        <td>Rp <?= number_format($pecah['price']); ?></td>
                        <td><?= $jumlah; ?></td>
                        <td>Rp <?= number_format($subtotal); ?></td>
                        <td>
                            <a href="keranjang.php?hapus=<?= $id_produk ?>" class="btn-hapus" onclick="return confirm('Yakin ingin menghapus?');">&times;</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div style="text-align: right; margin-top: 20px;">
                <h3>Total Belanja: Rp <?= number_format($total_bayar); ?></h3>
                <br>
                <a href="produk.php" class="btn-back">Lanjut Belanja</a>
                
                <button onclick="checkCheckout()" class="btn-checkout">Checkout & Bayar</button>
            </div>

        <?php endif; ?>
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
            <p style="margin-top: 10px; font-size: 0.9rem;">Belum punya akun? <a href="#">Daftar disini</a></p>
        </div>
    </div>

    <script>
        // Cek status login dari PHP
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

        function openLogin() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function closeLogin() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Logic Tombol Checkout
        function checkCheckout() {
            if (isLoggedIn) {
                // Jika sudah login, pergi ke halaman checkout
                window.location.href = 'checkout.php';
            } else {
                // Jika belum login, buka pop-up
                alert("Silakan Login dulu untuk melanjutkan pembayaran!");
                openLogin();
            }
        }

        window.onclick = function(event) {
            let modal = document.getElementById('loginModal');
            if (event.target == modal) {
                closeLogin();
            }
        }
    </script>

</body>
</html>