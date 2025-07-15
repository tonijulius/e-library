<?php
session_start();
include 'koneksi.php';

// Jika sudah login, langsung arahkan ke katalog
if (isset($_SESSION['pengguna'])) {
    header("Location: katalog_buku.php");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $query = "SELECT * FROM pengguna WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['pengguna'] = $user['id_pengguna'];
			$_SESSION['username'] = $user['username']; 
            header("Location: katalog_buku.php");
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Pengguna - E-Library</title>
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

        .beranda-link {
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            color: black;
        }
		
        .container {
            text-align: center;
            padding-top: 100px;
        }
        input[type=text], input[type=password] {
            width: 300px;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid black;
            font-size: 16px;
        }
        button {
            background-color: #1fa61f;
            color: white;
            padding: 10px 40px;
            font-size: 18px;
            border: 2px solid black;
            cursor: pointer;
            font-weight: bold;
        }
        .error {
            color: red;
        }
        a {
            color: blue;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        h2 {
            font-size: 24px;
        }
        .logo {
            margin-top: 20px;
        }
    </style>
</head>
<body>
	 <div class="header">
        <div class="header-left">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <a href="beranda_website.php" class="beranda-link">BERANDA</a>
    </div>
	
    <div class="container">
        <h2>LOGIN PENGGUNA</h2>
        <?php if ($error) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="USERNAME" required><br>
            <input type="password" name="password" placeholder="PASSWORD" required><br>
            <button type="submit">LOGIN</button>
        </form>
        <p>Belum punya akun? <a href="registrasi_pengguna.php">buat disini</a></p>
    </div>
</body>
</html>
