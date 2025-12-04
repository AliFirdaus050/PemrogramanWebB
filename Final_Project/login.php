<?php
session_start();
include 'koneksi.php';

if (isset($_GET['logout'])) {
    // Hapus semua session
    session_destroy();
    
    // Tampilkan pesan dan tendang balik ke halaman Home
    echo "<script>
            alert('Anda telah berhasil Logout.'); 
            window.location = 'index.php'; 
          </script>";
    exit; // Stop script di sini
}

// 1. Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    
    // 2. Tangkap data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // 3. Cek Koneksi Database
    if (!$conn) {
        die("Error Koneksi Database: " . mysqli_connect_error());
    }

    // 4. Query cek user
    $query_sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query_sql);

    // 5. Cek apakah query error (salah nama tabel/kolom)
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    // 6. Cek apakah data ditemukan
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Login Sukses
        $_SESSION['user'] = $data;
        $_SESSION['status_login'] = true;

        echo "<script>
            alert('Login Berhasil! Halo, " . $data['nama'] . "');
            // Redirect kembali ke halaman produk atau detail
            window.location = 'produk.php'; 
        </script>";
    } else {
        // Login Gagal
        echo "<script>
            alert('Login Gagal! Email atau Password salah.\\nSilakan coba lagi.');
            window.history.back(); // Kembali ke halaman sebelumnya
        </script>";
    }
}
?>