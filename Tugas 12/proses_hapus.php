<?php
include "koneksi.php";

$id = $_GET['id'];

$query = "SELECT foto FROM siswa WHERE id='".$id."'";
$sql = mysqli_query($mysqli, $query);
$data = mysqli_fetch_array($sql); 

if(is_file("images/".$data['foto'])){ 
    unlink("images/".$data['foto']); 
}

$query2 = "DELETE FROM siswa WHERE id='".$id."'";
$sql2 = mysqli_query($mysqli, $query2); 

if($sql2){ 
    header("location: index.php"); 
}else{
    echo "Data gagal dihapus. <a href='index.php'>Kembali</a>";
}
?>