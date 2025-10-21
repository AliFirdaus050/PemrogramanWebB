<?php
include("koneksi.php");

if(isset($_POST['daftar'])){
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jk = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $sekolah = $_POST['asal_sekolah'];

    $sql = "INSERT INTO calon_siswa (nama, alamat, jenis_kelamin, agama, asal_sekolah) VALUE ('$nama', '$alamat', '$jk', '$agama', '$sekolah')";
    $query = mysqli_query($db, $sql);

    if($query) {
        header('Location: index.php?status=sukses');
    } else {
            header('Location: index.php?status=gagal');
    }
} else {
    die("Akses dilarang...");
}
?>