<?php
session_start();
include 'koneksi.php';

// ---------------------------------------------------
// KEAMANAN 1: CEK LOGIN
// ---------------------------------------------------
// Jika user mencoba buka checkout.php tapi belum login
if (!isset($_SESSION['status_login'])) {
    echo "<script>
            alert('Silakan login terlebih dahulu!'); 
            window.location='produk.php'; 
          </script>";
    exit;
}

// ---------------------------------------------------
// KEAMANAN 2: CEK KERANJANG
// ---------------------------------------------------
if (empty($_SESSION['cart'])) {
    echo "<script>
            alert('Keranjang kosong, belanja dulu yuk!'); 
            window.location='produk.php';
          </script>";
    exit;
}

// ---------------------------------------------------
// LOGIKA PROSES PESANAN
// ---------------------------------------------------
if (isset($_POST['checkout'])) {
    $user_id = $_SESSION['user']['id']; // Ambil ID dari session login
    $nama = $_POST['nama'];
    $telepon = $_POST['telepon'];
    $alamat = $_POST['alamat'];
    
    // Buat Order ID Unik
    $order_id = "ORD-" . date('Ymd') . "-" . rand(1000, 9999);
    $total_belanja = 0;

    // Hitung Total
    foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
        $ambil = mysqli_query($conn, "SELECT * FROM products WHERE id='$id_produk'");
        $pecah = mysqli_fetch_assoc($ambil);
        $total_belanja += ($pecah['price'] * $jumlah);
    }

    // A. Simpan data Pelanggan ke tabel 'orders'
    $conn->query("INSERT INTO orders (id, user_id, customer_name, customer_address, customer_phone, total_amount) 
                  VALUES ('$order_id', '$user_id', '$nama', '$alamat', '$telepon', '$total_belanja')");

    // B. Simpan Rincian Barang ke tabel 'order_items'
    foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
        $ambil = mysqli_query($conn, "SELECT * FROM products WHERE id='$id_produk'");
        $pecah = mysqli_fetch_assoc($ambil);
        $harga = $pecah['price'];

        $conn->query("INSERT INTO order_items (order_id, product_id, qty, price) 
                      VALUES ('$order_id', '$id_produk', '$jumlah', '$harga')");
    }

    // C. Kosongkan Keranjang karena sudah dipesan
    unset($_SESSION['cart']);

    // D. Redirect ke Pembayaran
    echo "<script>
            alert('Pesanan berhasil dibuat! Lanjut ke pembayaran.'); 
            window.location='payment.php?id=$order_id';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - FocusZone</title>
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
        }

        /* =========================================
           3. LAYOUT CHECKOUT
           ========================================= */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
            display: flex;
            gap: 30px;
        }
        
        /* KOLOM KIRI (FORM) */
        .checkout-left {
            flex: 2;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .checkout-left h2 {
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input, 
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        /* KOLOM KANAN (RINGKASAN) */
        .checkout-right {
            flex: 1;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: fit-content;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 0.9rem;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #eee;
            font-weight: bold;
            font-size: 1.2rem;
            color: #e74c3c;
        }
        
        /* BUTTON */
        .btn-process {
            background-color: #2c3e50;
            color: white;
            border: none;
            padding: 15px;
            width: 100%;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-process:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="logo">Focus<span>Zone</span></div>
        <ul>
            <li><a href="keranjang.php">Kembali ke Keranjang</a></li>
            
            <?php if (isset($_SESSION['user'])): ?>
                <li><a href="#" style="color:#e74c3c;"><?= $_SESSION['user']['nama'] ?></a></li>
                <li><a href="login.php?logout=true">Logout</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="container">
        
        <div class="checkout-left">
            <h2>Alamat Pengiriman</h2>
            <form method="post">
                <div class="form-group">
                    <label>Nama Penerima</label>
                    <input type="text" name="nama" value="<?= $_SESSION['user']['nama'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon / WhatsApp</label>
                    <input type="text" name="telepon" placeholder="Contoh: 08123456789" required>
                </div>
                <div class="form-group">
                    <label>Alamat Lengkap</label>
                    <textarea name="alamat" rows="3" placeholder="Jalan, Nomor Rumah, Kecamatan, Kota..." required></textarea>
                </div>
                <div class="form-group">
                    <label>Catatan (Opsional)</label>
                    <textarea name="catatan" rows="2" placeholder="Pesan untuk kurir..."></textarea>
                </div>
                
                <button type="submit" name="checkout" class="btn-process">BUAT PESANAN</button>
            </form>
        </div>

        <div class="checkout-right">
            <h2>Ringkasan Pesanan</h2>
            <br>
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $id_produk => $jumlah): 
                $ambil = mysqli_query($conn, "SELECT * FROM products WHERE id='$id_produk'");
                $pecah = mysqli_fetch_assoc($ambil);
                $subtotal = $pecah['price'] * $jumlah;
                $total += $subtotal;
            ?>
            <div class="summary-item">
                <span><?= $pecah['name']; ?> (x<?= $jumlah ?>)</span>
                <span>Rp <?= number_format($subtotal) ?></span>
            </div>
            <?php endforeach; ?>
            
            <div class="total-row">
                <span>Total Bayar</span>
                <span>Rp <?= number_format($total) ?></span>
            </div>
        </div>

    </div>

</body>
</html>