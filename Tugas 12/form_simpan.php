<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Siswa</title>
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

        
        .form-group {
            margin-bottom: 10px; 
        }

        label {
            display: block;
            margin-bottom: 3px; 
            font-weight: 600;
            color: #2c3e50;
            font-size: 12px;
        }

        input[type="text"], 
        textarea, 
        input[type="file"] {
            width: 100%;
            padding: 8px 10px;  
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 13px;    
        }

        input[type="text"]:focus, 
        textarea:focus {
            border-color: #154360;
            outline: none;
            background-color: #fbfbfb;
        }

        textarea {
            height: 60px;
            resize: none;
        }

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
        .radio-group input {
            margin-right: 5px;
        }

        input[type="file"] {
            padding: 5px; 
            font-size: 12px;
        }

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

        input[type="submit"]:hover {
            background-color: #1a5276;
        }

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

        .btn-batal:hover {
            background-color: #fceae9;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Tambah Data Siswa</h1>

        <form method="post" action="proses_simpan.php" enctype="multipart/form-data">
            
            <div class="form-group">
                <label>NIS</label>
                <input type="text" name="nis" placeholder="Masukkan NIS" required>
            </div>

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama" placeholder="Masukkan Nama" required>
            </div>

            <div class="form-group">
                <label>Jenis Kelamin</label>
                <div class="radio-group">
                    <label><input type="radio" name="jenis_kelamin" value="Laki-laki"> Laki-laki</label>
                    <label><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
                </div>
            </div>

            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="telp" placeholder="Contoh: 0812xxxx">
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" placeholder="Alamat singkat..."></textarea>
            </div>

            <div class="form-group">
                <label>Foto Siswa <span style="color:#888; font-size:11px; font-weight:normal;">(JPG/PNG)</span></label>
                <input type="file" name="foto" required>
            </div>

            <div class="btn-container">
                <input type="submit" value="Simpan">
                <a href="index.php" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>

</body>
</html>