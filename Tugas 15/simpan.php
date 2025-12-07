<?php
include 'koneksi.php';

$nim            = $_POST['nim'];
$nama_lengkap   = $_POST['nama_lengkap'];
$no_hp          = $_POST['no_hp'];
$tanggal_lahir  = $_POST['tanggal_lahir'];

$query = "INSERT INTO mahasiswa (nim, nama_lengkap, tanggal_lahir, no_hp) 
          VALUES ('$nim', '$nama_lengkap', '$tanggal_lahir', '$no_hp')";

if (mysqli_query($connect, $query)) {
    echo "<script>
            alert('Data Berhasil Disimpan!');
            window.location.href = 'cetak.php'; 
          </script>";
} else {
    echo "Gagal menyimpan data: " . mysqli_error($connect);
}
?>