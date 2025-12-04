<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_toko_kamera";
$port = 3307; 

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>