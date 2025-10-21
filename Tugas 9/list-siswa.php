<?php include("koneksi.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Pendaftaran Siswa Baru</title>
    <link rel="stylesheet" href="style.css"> </head>
</head>
<body>
    <header>
        <h3>Siswa yang sudah mendaftar</h3>
    </header>

    <nav>
        <a href="form-daftar.php">[+] Tambah Baru</a>
    </nav>
    <br>
    <table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Agama</th>
            <th>Asal Sekolah</th>
            <th>Tindakan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql = "SELECT * FROM calon_siswa";
        $query = mysqli_query($db, $sql);
        $no = 1;

        while($siswa = mysqli_fetch_array($query)){
            echo "<tr>";
            echo "<td>".$no++."</td>";
            echo "<td>".$siswa['nama']."</td>";
            echo "<td>".$siswa['alamat']."</td>";
            echo "<td>".$siswa['jenis_kelamin']."</td>";
            echo "<td>".$siswa['agama']."</td>";
            echo "<td>".$siswa['asal_sekolah']."</td>";
            echo "<td>";
            echo "<a href='form-edit.php?id=".$siswa['id']."'>Edit</a> | ";
            echo "<a href='delete.php?id=".$siswa['id']."' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>
    <p>Total: <?php echo mysqli_num_rows($query) ?></p>
    </body>
</html>