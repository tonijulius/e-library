<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda E-Library</title>
    <style>
		body {
			margin: 0;
			padding: 0;
			font-family: Georgia, serif;
			background: url('gambar/gambar_perpus.jpeg') no-repeat center center fixed;
			background-size: cover;
			color: #000;
		}

		.login-container {
			position: absolute;
			top: 20px;
			right: 30px;
			display: flex;
			gap: 10px;
		}

		.login-btn {
			padding: 10px 15px;
			background-color: #ccff99;
			color: black;
			font-weight: bold;
			text-decoration: none;
			border: 2px solid #333;
			border-radius: 5px;
			transition: background-color 0.3s;
		}
		.login-btn:hover {
			background-color: #b3ff66;
		}

		.login-btn.admin {
			background-color: #ffd966;
		}
		.login-btn.admin:hover {
			background-color: #ffcd3c;
		}


		.container {
			text-align: center;
			padding-top: 80px;
		}

		.logo {
			width: 250px;
			margin-bottom: 5px;
			margin-left: 0px;
			
		}

		.judul {
			font-size: 48px;
			font-weight: bold;
			margin-bottom: 10px;
			background-color: rgba(255,255,255,0.7);
			display: inline-block;
			padding: 10px 30px;
		}

		.motto {
			font-size: 18px;
			font-style: italic;
			background-color: rgba(255,255,255,0.8);
			margin: 20px auto;
			padding: 10px 20px;
			width: 80%;
			max-width: 700px;
			border-radius: 6px;
			
		}

		.bestseller {
			margin: 50px auto;
			padding: 30px;
			width: 85%;
			max-width: 950px;
			border: 0px solid ;
		}

		.bestseller h2 {
			margin-bottom: 20px;
			font-size: 26px;
			color: black;
			font-weight: bold;
			margin-bottom: 10px;
			background-color: rgba(255,255,255,0.7);
			display: inline-block;
			padding: 10px 30px;
			
		}

		.buku-list {
			display: flex;
			justify-content: center;
			gap: 20px;
			flex-wrap: wrap;
		}

		.buku-list img {
			width: 150px;
			height: auto;
			border: 2px solid black;
			box-shadow: 3px 3px 6px rgba(0,0,0,0.3);
		}

	</style>
</head>
<body>

<div class="login-container">
    <a href="login_pengguna.php" class="login-btn pengguna">Login Pengguna</a>
    <a href="login_admin.php" class="login-btn admin">Login Admin</a>
</div>

<!-- Logo & Judul -->
<div class="container">
    <img src="gambar/buku2.png" class="logo" alt="Logo E-Library">
	<br>
    <h1 class="judul">E-LIBRARY</h1>
    <p class="motto">"Melalui teknologi dan literasi digital, kami membuka pintu pengetahuan bagi siapa pun yang ingin belajar dan tumbuh."</p>
	<br>
    <!-- Buku Best Seller -->
    <div class="bestseller">
        <h2>BUKU BEST SELLER KAMI</h2>
        <div class="buku-list">
            <img src="gambar/pengantarilmuhukum.png" alt="Ilmu Hukum">
            <img src="gambar/webprogramming.png" alt="Web Programming">
            <img src="gambar/sejarahperadabanislam.png" alt="Sejarah Islam">
            <img src="gambar/konsepdasarekonomi.png" alt="Ekonomi">
			<img src="gambar/sejarahnasionalindonesia.png" alt="Sejarah Indonesia">
        </div>
    </div>
</div>

</body>
</html>
