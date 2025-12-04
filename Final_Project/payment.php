<?php
session_start();
include 'koneksi.php';

// 1. Cek Login
if (!isset($_SESSION['status_login'])) {
    header("Location: login.php");
    exit;
}

// 2. Ambil Order ID dari URL
$order_id = $_GET['id'];

// 3. Ambil Data Pesanan dari Database
$ambil = $conn->query("SELECT * FROM orders WHERE id='$order_id'");
$detail = $ambil->fetch_assoc();

// Jika pesanan tidak ditemukan (atau milik orang lain)
if (!$detail || $detail['user_id'] !== $_SESSION['user']['id']) {
    echo "<script>alert('Pesanan tidak ditemukan!'); location='index.php';</script>";
    exit;
}

// 4. Konfigurasi Midtrans (TANPA COMPOSER - PAKE CURL BAWAAN PHP)
// ----------------------------------------------------------------
$serverKey = 'GANTI_DENGAN_SERVER_KEY_KAMU'; // <--- ISI SERVER KEY DISINI
$isProduction = false; // Kita masih mode Sandbox (Testing)
$apiUrl = $isProduction 
    ? 'https://app.midtrans.com/snap/v1/transactions' 
    : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

// 5. Siapkan Data untuk dikirim ke Midtrans
$transaction_details = [
    'order_id' => $order_id,
    'gross_amount' => (int) $detail['total_amount'], // Pastikan integer
];

// Ambil item produk untuk detail di Midtrans (Opsional tapi bagus)
$item_details = [];
$ambil_produk = $conn->query("SELECT * FROM order_items JOIN products ON order_items.product_id = products.id WHERE order_id='$order_id'");
while($produk = $ambil_produk->fetch_assoc()){
    $item_details[] = [
        'id' => $produk['product_id'],
        'price' => (int) $produk['price'],
        'quantity' => (int) $produk['qty'],
        'name' => substr($produk['name'], 0, 50) // Midtrans batasi nama max 50 char
    ];
}

$customer_details = [
    'first_name' => $detail['customer_name'],
    'phone' => $detail['customer_phone'],
    // 'email' => 'email_user@example.com' (Bisa diambil dari session user)
];

$payload = [
    'transaction_details' => $transaction_details,
    'item_details' => $item_details,
    'customer_details' => $customer_details
];

// 6. Kirim ke API Midtrans Menggunakan cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . base64_encode($serverKey . ':') // Auth Basic
]);

$response = curl_exec($ch);
curl_close($ch);

$data_midtrans = json_decode($response, true);
$snapToken = $data_midtrans['token'] ?? ''; // Ambil token pembayaran

// Simpan Token ke Database (Opsional, agar tidak request ulang terus)
if ($snapToken) {
    $conn->query("UPDATE orders SET snap_token='$snapToken' WHERE id='$order_id'");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - FocusZone</title>
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="GANTI_DENGAN_CLIENT_KEY_KAMU"></script> <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f8fb; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .payment-card { background: white; padding: 40px; border-radius: 10px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); text-align: center; width: 400px; }
        .payment-card h2 { color: #2c3e50; margin-bottom: 10px; }
        .amount { font-size: 2rem; color: #e74c3c; font-weight: bold; margin: 20px 0; }
        .order-id { color: #7f8c8d; margin-bottom: 30px; font-size: 0.9rem; }
        
        .btn-pay {
            background-color: #2c3e50; color: white; border: none; padding: 15px 30px;
            font-size: 1.1rem; border-radius: 5px; cursor: pointer; width: 100%; font-weight: bold; transition: 0.3s;
        }
        .btn-pay:hover { background-color: #2980b9; }
    </style>
</head>
<body>

    <div class="payment-card">
        <h2>Konfirmasi Pembayaran</h2>
        <p class="order-id">Order ID: <?= $order_id ?></p>
        
        <div class="amount">Rp <?= number_format($detail['total_amount']) ?></div>
        
        <p>Silakan selesaikan pembayaran Anda sebelum stok habis.</p>
        <br>
        
        <button id="pay-button" class="btn-pay">BAYAR SEKARANG</button>
    </div>

    <script type="text/javascript">
      var payButton = document.getElementById('pay-button');
      payButton.addEventListener('click', function () {
        // Panggil Snap Pop-up
        window.snap.pay('<?= $snapToken ?>', {
          onSuccess: function(result){
            alert("Pembayaran Berhasil!");
            // Redirect ke halaman sukses (nanti kita buat)
            window.location.href = "index.php";
          },
          onPending: function(result){
            alert("Menunggu Pembayaran!");
          },
          onError: function(result){
            alert("Pembayaran Gagal!");
          },
          onClose: function(){
            alert('Anda menutup popup tanpa menyelesaikan pembayaran');
          }
        });
      });
    </script>
</body>
</html>