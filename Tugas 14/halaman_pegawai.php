<?php 
session_start();
if($_SESSION['level']==""){
	header("location:index.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Halaman Pegawai</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="theme-pegawai">

    <div class="navbar">
        <h1>Portal Pegawai</h1>
        
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <div class="card">
            <h2>Selamat Bekerja!</h2>
            <br>
            
            <p class="welcome-text">Halo <b><?php echo $_SESSION['username']; ?></b>.</p>
            
            <p>Anda masuk sebagai  <span class="role-badge"><?php echo $_SESSION['level']; ?></span></p>
            
            <br>
            <p style="font-size: 14px; color: #777;">Silakan akses menu pekerjaan harian Anda di sini.</p>
        </div>
    </div>

</body>
</html>