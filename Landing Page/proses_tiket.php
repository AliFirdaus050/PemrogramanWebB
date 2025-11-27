<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $tanggal = $_POST['tanggal'];
    $jumlah = $_POST['jumlah'];

    $stmt = $conn->prepare("INSERT INTO pemesanan_tiket (nama_lengkap, email, tanggal_kunjungan, jumlah_tiket) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nama, $email, $tanggal, $jumlah);

    if ($stmt->execute()) {
        echo "<script>
                alert('Pemesanan tiket berhasil! Terima kasih, $nama.');
                window.location.href = 'index.php'; 
              </script>";
    } else {
        echo "Gagal memesan tiket: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>