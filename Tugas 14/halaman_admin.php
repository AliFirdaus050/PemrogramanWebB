<?php 
session_start();
if($_SESSION['level']==""){
	header("location:index.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="theme-admin"> <div class="navbar">
        <h1>Admin Panel</h1>
        <a href="logout.php" class="btn-logout">Logout</a>
    </div>

    <div class="container">
        <div class="card">
            <h2>Selamat Datang!</h2>
            <br>
            <p class="welcome-text">Halo <b><?php echo $_SESSION['username']; ?></b>.</p>
            <p>Anda login sebagai <span class="role-badge"><?php echo $_SESSION['level']; ?></span></p>
            <br>
            <p style="font-size: 14px; color: #777;">Anda memiliki akses penuh untuk mengelola user dan sistem.</p>
        </div>
    </div>

</body>
</html>