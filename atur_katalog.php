<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data katalog dari database
$query = "SELECT * FROM katalog_buku ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Katalog Buku</title>
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

        h2 {
            text-align: center;
            color: #333;
        }
		
		 .btn-tambah {
            display: block;
            margin: 20px auto;
            background-color: #fff;
            padding: 12px 30px;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
        }
		
        .container {
            max-width: 1000px;
            margin: auto;
			margin-top: 10px;
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
        }
       
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        img.sampul {
            max-width: 70px;
            border-radius: 4px;
        }
        .aksi a {
            margin: 0 4px;
            padding: 6px 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }
        .edit-btn {
            background: #2196F3;
        }
        .hapus-btn {
            background: #f44336;
        }
    </style>
</head>
<body>

 <div class="header">
        <div class="header-left">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <a href="dashboard.php" class="home-link">HOME</a>
    </div>
<h2>Daftar Katalog Buku</h2>
    <a href="tambah_katalog.php" class="btn-tambah">Tambah Katalog</a>

<div class="container">
    
    <table>
        <tr>
            <th>No</th>
            <th>Sampul</th>
            <th>Judul Buku</th>
            <th>Kategori</th>
            <th>ID Buku</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$no}</td>";
            echo "<td><img class='sampul' src='gambar/{$row['gambar']}' alt='Sampul Buku'></td>";
            echo "<td>{$row['judul']}</td>";
            echo "<td>{$row['kategori']}</td>";
            echo "<td>{$row['id_buku']}</td>";
            echo "<td class='aksi'>
                    <a class='edit-btn' href='edit_katalog.php?id={$row['id']}'>Edit</a>
                    <a class='hapus-btn' href='hapus_katalog.php?id={$row['id']}' onclick=\"return confirm('Yakin ingin menghapus entri katalog ini?')\">Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
        ?>
    </table>
</div>

</body>
</html>
