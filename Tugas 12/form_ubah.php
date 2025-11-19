<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Data Siswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 450px; 
            background: #fff;
            padding: 20px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #2c3e50;
            margin: 0 0 15px 0;
            font-size: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }

        .form-group { margin-bottom: 10px; }

        label {
            display: block;
            margin-bottom: 3px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 12px;
        }

        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 13px;
        }

        input[type="text"]:focus, textarea:focus {
            border-color: #154360;
            outline: none;
            background-color: #fbfbfb;
        }

        textarea { height: 60px; resize: none; }

        .radio-group {
            display: flex;
            align-items: center;
            height: 30px;
        }
        .radio-group label {
            margin: 0 15px 0 0;
            font-weight: normal;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
        }
        .radio-group input { margin-right: 5px; }

        .btn-container {
            text-align: right;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #f5f5f5;
        }

        input[type="submit"] {
            background-color: #154360;
            color: white;
            padding: 8px 20px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            font-size: 13px;
            transition: background 0.3s;
        }
        input[type="submit"]:hover { background-color: #1a5276; }

        .btn-batal {
            background-color: #fff;
            color: #e74c3c;
            border: 1px solid #e74c3c;
            padding: 7px 20px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            margin-left: 8px;
            display: inline-block;
        }
        .btn-batal:hover { background-color: #fceae9; }

        .foto-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 5px;
            background-color: #f9f9f9;
            padding: 5px;
            border-radius: 4px;
            border: 1px solid #eee;
        }
        .foto-thumb {
            width: 35px;  
            height: 45px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ddd;
        }
        .foto-text {
            font-size: 11px;
            color: #666;
            line-height: 1.3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Ubah Data Siswa</h1>
        
        <?php
        include "koneksi.php";
        $id = $_GET['id'];
        $query = "SELECT * FROM siswa WHERE id='".$id."'";
        $sql = mysqli_query($mysqli, $query);
        $data = mysqli_fetch_array($sql);
        ?>

        <form method="post" action="proses_ubah.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" value="<?php echo $data['nis']; ?>" required>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" value="<?php echo $data['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="radio-group">
                    <?php
                    if($data['jenis_kelamin'] == "Laki-laki"){
                        echo "<label><input type='radio' name='jenis_kelamin' value='Laki-laki' checked> Laki-laki</label>";
                        echo "<label><input type='radio' name='jenis_kelamin' value='Perempuan'> Perempuan</label>";
                    }else{
                        echo "<label><input type='radio' name='jenis_kelamin' value='Laki-laki'> Laki-laki</label>";
                        echo "<label><input type='radio' name='jenis_kelamin' value='Perempuan' checked> Perempuan</label>";
                    }
                    ?>
                </div>
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="telp" value="<?php echo $data['telp']; ?>">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat"><?php echo $data['alamat']; ?></textarea>
            </div>

            <div class="form-group">
                <label>Foto</label>
                <div class="foto-info">
                    <img src="images/<?php echo $data['foto']; ?>" class="foto-thumb">
                    <div class="foto-text">
                        <strong>Foto saat ini.</strong><br>
                        Biarkan kosong jika tetap.
                    </div>
                </div>
                <input type="file" name="foto">
            </div>

            <div class="btn-container">
                <input type="submit" value="Simpan">
                <a href="index.php" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>

</body>
</html>