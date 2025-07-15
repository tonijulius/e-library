<?php
session_start();
include 'koneksi.php';

$pesan = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek data admin
    $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['admin'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $pesan = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - E-Library</title>
    <style>
        body {
            margin: 0;
            font-family: Inknut-Antiqua;
            background-color: #e9ffae;
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

        .login-box {
            background-color: #dfffa5;
            max-width: 400px;
            margin: 40px auto;
            padding: 30px;
            border: 0px solid #ccc;
            text-align: center;
        }
        .login-box h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 80%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #000;
            font-size: 16px;
        }
        .login-box input[type="submit"] {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 10px 25px;
            border: 2px solid #000;
            cursor: pointer;
            font-weight: bold;
        }
        .error-msg {
            color: red;
            font-size: 14px;
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

    <div class="login-box">
        <h2>ADMIN</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="USERNAME" required><br>
            <input type="password" name="password" placeholder="PASSWORD" required><br>
            <input type="submit" value="LOGIN">
        </form>
    </div>
</body>
</html>
