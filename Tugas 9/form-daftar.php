<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendaftaran Siswa Baru</title>
    <link rel="stylesheet" href="style.css"> </head>
</head>
<body>
    <header>
        <h3>Formulir Pendaftaran Siswa Baru</h3>
    </header>
    <form action="proses-pendaftaran.php" method="POST">
        <fieldset>
            <p>
                <label for="nama">Nama: </label>
                <input type="text" name="nama" placeholder="Nama lengkap" required />
            </p>
            <p>
                <label for="alamat">Alamat: </label>
                <textarea name="alamat" required></textarea>
            </p>
            <p>
                <label for="jenis_kelamin">Jenis Kelamin: </label>
                <label><input type="radio" name="jenis_kelamin" value="laki-laki"> Laki-laki</label>
                <label><input type="radio" name="jenis_kelamin" value="perempuan"> Perempuan</label>
            </p>
            <p>
                <label for="agama">Agama: </label>
                <select name="agama">
                    <option>Islam</option>
                    <option>Kristen</option>
                    <option>Hindu</option>
                    <option>Budha</option>
                    <option>Atheis</option>
                </select>
            </p>
            <p>
                <label for="asal_sekolah">Asal Sekolah: </label>
                <input type="text" name="asal_sekolah" placeholder="Nama sekolah" required />
            </p>
            <p>
                <input type="submit" value="Daftar" name="daftar" />
            </p>
        </fieldset>
    </form>
</body>
</html>