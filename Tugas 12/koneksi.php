<?php
$host = "127.0.0.1"; 
$user = "root";
$pass = "root"; 
$db   = "upload";
$port = 3307; 

$mysqli = mysqli_connect($host, $user, $pass, $db, $port);

if (!$mysqli) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>