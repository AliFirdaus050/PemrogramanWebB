<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
$data = mysqli_fetch_assoc($query);

// Logika Tambah ke Keranjang Sederhana
if (isset($_POST['add_to_cart'])) {
    // Jika keranjang belum ada, buat array baru
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Simpan ID produk dan jumlah ke session
    $product_id = $_POST['product_id'];
    $qty = $_POST['qty'];
    
    // Cek jika produk sudah ada, tambahkan jumlahnya
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $qty;
    } else {
        $_SESSION['cart'][$product_id] = $qty;
    }
    
    echo "<script>alert('Produk masuk keranjang!'); window.location='keranjang.php';</script>";
}

// Hitung jumlah keranjang untuk navbar
$jumlah_keranjang = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $qty_item) {
        $jumlah_keranjang += $qty_item;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['name']; ?> - FocusPoint</title>
    <style>
        /* --- 1. GLOBAL STYLE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f4f8fb; color: #333; padding-bottom: 50px; }

        /* --- 2. NAVBAR STYLE --- */
        .navbar {
            background-color: #2c3e50; padding: 15px 50px; display: flex;
            justify-content: space-between; align-items: center;
            position: sticky; top: 0; z-index: 100; box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .navbar .logo { color: #fff; font-size: 1.6rem; font-weight: 800; }
        .navbar .logo span { color: #e74c3c; }
        .navbar ul { list-style: none; display: flex; gap: 25px; }
        .navbar ul li a { text-decoration: none; color: #bdc3c7; font-weight: 500; transition: 0.3s; }
        .navbar ul li a:hover { color: #fff; }
        .cart-badge { background: #e74c3c; color: white; padding: 2px 6px; border-radius: 50%; font-size: 0.7rem; vertical-align: top; }

        /* --- 3. DETAIL PRODUCT STYLE --- */
        .container { max-width: 1000px; margin: 40px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
        .detail-wrapper { display: flex; gap: 40px; align-items: start; }
        .img-detail { width: 100%; max-width: 400px; border-radius: 10px; border: 1px solid #eee; }
        .product-info h1 { font-size: 2rem; color: #2c3e50; margin-bottom: 10px; }
        .product-info h2 { color: #e74c3c; font-size: 1.8rem; margin-bottom: 20px; }
        .product-info p { line-height: 1.6; color: #555; margin-bottom: 30px; }
        .btn-add { background: #e74c3c; color: white; border: none; padding: 12px 25px; font-size: 1rem; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-add:hover { background: #c0392b; }

        /* --- 4. MODAL POP-UP STYLE --- */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); z-index: 999;
            justify-content: center; align-items: center;
        }
        .modal-box {
            background: white; padding: 30px; border-radius: 10px; width: 350px;
            text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3); position: relative;
            animation: fadeIn 0.3s;
        }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        .modal-box h2 { margin-bottom: 20px; color: #2c3e50; }
        .input-group { margin-bottom: 15px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .input-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .btn-login-submit { background-color: #e74c3c; color: white; border: none; padding: 10px 20px; width: 100%; border-radius: 5px; cursor: pointer; font-size: 1rem; font-weight: bold; }
        .btn-close { position: absolute; top: 10px; right: 15px; font-size: 20px; cursor: pointer; color: #aaa; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Cam<span>Zone</span></div>
        <ul>
            <li><a href="index.php">Home</a></li>
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
                <li><a href="#" onclick="openLogin()">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div class="container">
        <div class="detail-wrapper">
            <img src="images/<?= $data['image']; ?>" class="img-detail">
            <div class="product-info">
                <h1><?= $data['name']; ?></h1>
                <h2>Rp <?= number_format($data['price'], 0, ',', '.'); ?></h2>
                <p><?= $data['description']; ?></p>
                
                <form method="post" onsubmit="return checkLoginBeforeCart(event)">
                    <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                    <div style="margin-bottom: 15px;">
                        <label>Jumlah:</label>
                        <input type="number" name="qty" value="1" min="1" style="width: 60px; padding: 5px;">
                    </div>
                    <button type="submit" name="add_to_cart" class="btn-add">Masukan Keranjang</button>
                </form>
            </div>
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
            <p style="margin-top: 10px; font-size: 0.9rem;">Belum punya akun? <a href="#">Daftar disini</a></p>
        </div>
    </div>

    <script>
        // Ambil status login dari PHP
        const isLoggedIn = <?php echo isset($_SESSION['user']) ? 'true' : 'false'; ?>;

        function openLogin() {
            document.getElementById('loginModal').style.display = 'flex';
        }

        function closeLogin() {
            document.getElementById('loginModal').style.display = 'none';
        }

        // Fungsi Pencegat (Interceptor)
        function checkLoginBeforeCart(event) {
            if (!isLoggedIn) {
                event.preventDefault(); // Stop form agar tidak submit
                alert("Eits! Anda harus login dulu sebelum belanja.");
                openLogin(); // Buka pop-up
                return false;
            }
            return true; // Lanjut submit
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