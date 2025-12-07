<!DOCTYPE html>
<html>
<head>
	<title>Login Aplikasi</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body class="body-login"> <div class="kotak_login">
		<p class="tulisan_login">User Login</p>
 
		<?php 
		if(isset($_GET['pesan'])){
			if($_GET['pesan']=="gagal"){
				echo "<div class='alert'>Username dan Password salah!</div>";
			}
            if($_GET['pesan']=="belum_login"){
				echo "<div class='alert'>Silahkan login dulu.</div>";
			}
		}
		?>
 
		<form action="cek_login.php" method="post">
			<label>Username</label>
			<input type="text" name="username" class="form_login" placeholder="Masukkan username .." required="required">
 
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Masukkan password .." required="required">
 
			<input type="submit" class="tombol_login" value="MASUK">
		</form>
	</div>
 
</body>
</html>