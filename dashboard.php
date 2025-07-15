<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - E-Library</title>
    <style>
        body {
            margin: 0;
            font-family: Inknut-Antiqua;
            background-color: #e9ffae;
        }

        header {
            background-color: #f8fffa;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 30px;
        }
        header img { height: 80px; }
        header h1 { margin: 0; font-size: 36px; font-weight: bold; }
        nav a {
            margin-left: 20px;
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .menu-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 40px;
        }

        .menu-item {
            background-color: white;
            border: 2px solid black;
            padding: 20px 30px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s, transform 0.2s;
        }

        .menu-item:hover {
            background-color: #d0ffd0;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <header>
        <div style="display: flex; align-items: center;">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <nav>
			<a href="logout_admin.php">LOGOUT</a>
        </nav>
    </header>

    <div class="menu-container">
        <a href="atur_katalog.php" class="menu-item">KATALOG</a>
        <a href="daftar_pengguna.php" class="menu-item">DAFTAR PENGGUNA</a>
        <a href="daftar_buku.php" class="menu-item">DAFTAR BUKU</a>
        <a href="daftar_peminjaman.php" class="menu-item">PEMINJAMAN</a>
        <a href="daftar_pembaca_online.php" class="menu-item">PEMBACA ONLINE</a>
    </div>

</body>
</html>
