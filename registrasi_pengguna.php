<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jk = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telepon'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($conn, "SELECT * FROM pengguna WHERE username='$username' OR nik='$nik'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username atau NIK sudah terdaftar.";
    } else {
        $query = "INSERT INTO pengguna (nama, nik, jk, alamat, no_telp, email, username, password)
                  VALUES ('$nama', '$nik', '$jk', '$alamat', '$no_telp', '$email', '$username', '$password')";
        if (mysqli_query($conn, $query)) {
            header("Location: login_pengguna.php?pesan=berhasil");
            exit();
        } else {
            $error = "Gagal mendaftar. Coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Pengguna</title>
    <style>
        body {
           font-family: Inknut-Antiqua;
           background-color: #e9ffae;
           margin: 0;
        }
		
         .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
			height: 100px;
            padding: 10px 20px;
            background-color: #f9fffa;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header img {
            height: 110px;
			width: 150px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 50px;
			font-family: Inknut-Antiqua;
            margin: 0;
            font-weight: bold;
        }

        .home-link {
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            color: black;
        }
		
        .container {
            width: 60%;
            margin: auto;
            padding-top: 40px;
        }
        h1 {
            text-align: center;
            font-size: 36px;
            margin-bottom: 20px;
        }
        form {
            display: grid;
            grid-template-columns: 30% 70%;
            gap: 10px;
            align-items: center;
        }
        label {
            font-weight: bold;
            font-size: 18px;
        }
        input[type="text"], input[type="password"], input[type="email"], input[type="radio"] {
            padding: 10px;
            font-size: 16px;
            width: 95%;
        }
        .button-container {
            grid-column: span 2;
            text-align: center;
        }
        .btn {
            background-color: #28a745;
            border: 2px solid #000;
            color: white;
            padding: 10px 30px;
            font-size: 20px;
			font-family: Inknut-Antiqua;
            cursor: pointer;
            font-weight: bold;
        }
        .error {
            grid-column: span 2;
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>

	<div class="header">
        <div class="header-left">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <a href="login_pengguna.php" class="home-link">LOGIN</a>
    </div>
	
    <div class="container">
        <h1>REGISTRASI</h1>
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <label>NAMA</label>
            <input type="text" name="nama" required>

            <label>NIK</label>
            <input type="text" name="nik" required>

            <label>JENIS KELAMIN</label>
				<select name="jenis_kelamin" required style="padding: 10px; font-size: 16px; width: 100%;">
					<option value="">-- Pilih Jenis Kelamin --</option>
					<option value="1">Laki-laki</option>
					<option value="0">Perempuan</option>
				</select>


            <label>ALAMAT</label>
            <input type="text" name="alamat" required>

            <label>NO TELEPON</label>
            <input type="text" name="no_telepon" required>

            <label>EMAIL</label>
            <input type="email" name="email" required>

            <label>USERNAME</label>
            <input type="text" name="username" required>

            <label>PASSWORD</label>
            <input type="password" name="password" required>

            <div class="button-container">
                <button type="submit" class="btn">DAFTAR</button>
            </div>
        </form>
    </div>
</body>
</html>
