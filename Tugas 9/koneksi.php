<?php
$server = "localhost";
$user = "root";
$password = "";
$nama_database = "db_pendaftaran";
$port = 3307;

$db = mysqli_connect($server, $user, $password, $nama_database, $port);

if (!$db) {
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}
?>