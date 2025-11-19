<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            max-width: 1100px; 
            margin: 0 auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .page-header {
            display: flex;
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee; 
        }

        h1 {
            color: #2c3e50;
            margin: 0; 
            font-size: 24px;
        }

        .btn-tambah {
    background-color: #154360; 
    color: white;
    padding: 8px 20px;         
    text-decoration: none;
    border-radius: 4px;       
    font-weight: 600;          
    font-size: 13px;           
    border: 1px solid #154360; 
    transition: all 0.3s ease;
    box-shadow: 0 2px 4px rgba(0,0,0,0.15); 
}

        .btn-tambah:hover {
    background-color: #1a5276; 
    border-color: #1a5276;
    transform: translateY(-1px);
}

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: #2c3e50;
            color: white;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 13px;
            letter-spacing: 0.5px;
        }

        tbody tr:nth-child(even) { background-color: #fdfdfd; }
        tbody tr:hover { background-color: #f1f1f1; }

        .foto-siswa {
            width: 80px;      
            height: auto;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.2);
            display: block;
        }

        .aksi-link {
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            margin-right: 8px;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-block;
        }

        .edit { 
            color: #f39c12; 
            background-color: rgba(243, 156, 18, 0.1);
        }
        
        .delete { 
            color: #e74c3c; 
            background-color: rgba(231, 76, 60, 0.1);
        }
        
        .edit:hover { background-color: #f39c12; color: white; }
        .delete:hover { background-color: #e74c3c; color: white; }

    </style>
</head>
<body>

    <div class="container">
        
        <div class="page-header">
            <h1>Daftar Data Siswa</h1>
            <a href="form_simpan.php" class="btn-tambah">+ Tambah Data Baru</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th width="100">Foto</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th width="140">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include "koneksi.php";
                $query = "SELECT * FROM siswa";
                $sql = mysqli_query($mysqli, $query);
                
                while($data = mysqli_fetch_array($sql)){ 
                ?>
                <tr>
                    <td>
                        <img src="images/<?php echo $data['foto']; ?>" class="foto-siswa" alt="Foto">
                    </td>
                    <td><?php echo $data['nis']; ?></td>
                    <td><strong><?php echo $data['nama']; ?></strong></td>
                    <td><?php echo $data['jenis_kelamin']; ?></td>
                    <td><?php echo $data['telp']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td>
                        <a href="form_ubah.php?id=<?php echo $data['id']; ?>" class="aksi-link edit">Ubah</a>
                        <a href="proses_hapus.php?id=<?php echo $data['id']; ?>" 
                           class="aksi-link delete" 
                           onclick="return confirm('Yakin hapus?')">
                           Hapus
                        </a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>