<?php
$host       = "localhost";
$user       = "root";
$password   = "";
$database   = "tutorial";
$port       = 3307; 

$connect    = mysqli_connect($host, $user, $password, $database, $port);

if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>