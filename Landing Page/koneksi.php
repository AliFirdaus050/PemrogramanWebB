<?php
$host = "127.0.0.1";
$user = "root";
$pass = "";          
$db   = "museum_siola_db";
$port = 3307;      

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
} 
?>