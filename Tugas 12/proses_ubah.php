<?php
include "koneksi.php";

$id            = $_POST['id'];
$nis           = $_POST['nis'];
$nama          = $_POST['nama'];
$jenis_kelamin = $_POST['jenis_kelamin'];
$telp          = $_POST['telp'];
$alamat        = $_POST['alamat'];

if($_FILES['foto']['name'] != ""){

    $foto = $_FILES['foto']['name'];
    $tmp  = $_FILES['foto']['tmp_name'];
    
    $fotobaru = date('dmYHis').$foto;
    $path = "images/".$fotobaru;

    if(move_uploaded_file($tmp, $path)){
        
        $query_cari = "SELECT foto FROM siswa WHERE id='".$id."'";
        $sql_cari   = mysqli_query($mysqli, $query_cari);
        $data_cari  = mysqli_fetch_array($sql_cari);
        
        if(is_file("images/".$data_cari['foto'])) {
            unlink("images/".$data_cari['foto']);
        }

        $query = "UPDATE siswa SET nis='".$nis."', nama='".$nama."', jenis_kelamin='".$jenis_kelamin."', telp='".$telp."', alamat='".$alamat."', foto='".$fotobaru."' WHERE id='".$id."'";
        $sql = mysqli_query($mysqli, $query);

        if($sql){
            header("location: index.php");
        }else{
            echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
            echo "<br><a href='form_ubah.php?id=".$id."'>Kembali Ke Form</a>";
        }
    }else{
        echo "Maaf, Gambar gagal untuk diupload.";
        echo "<br><a href='form_ubah.php?id=".$id."'>Kembali Ke Form</a>";
    }

}
else{ 
    $query = "UPDATE siswa SET nis='".$nis."', nama='".$nama."', jenis_kelamin='".$jenis_kelamin."', telp='".$telp."', alamat='".$alamat."' WHERE id='".$id."'";
    $sql = mysqli_query($mysqli, $query);

    if($sql){
        header("location: index.php");
    }else{
        echo "Maaf, Terjadi kesalahan saat mencoba untuk menyimpan data ke database.";
        echo "<br><a href='form_ubah.php?id=".$id."'>Kembali Ke Form</a>";
    }
}
?>