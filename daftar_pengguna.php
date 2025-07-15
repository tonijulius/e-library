<?php
session_start();
include 'koneksi.php';

// Validasi login admin
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data pengguna dari database
$cari = $_GET['cari'] ?? '';
$sql = "SELECT * FROM pengguna";

if (!empty($cari)) {
    $cari_aman = mysqli_real_escape_string($conn, $cari);
    $sql .= " WHERE nama LIKE '%$cari_aman%' OR username LIKE '%$cari_aman%'";
}


$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengguna</title>
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

        .home-link {
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            color: black;
        }
        h2 { 
			margin-bottom: 20px;
			text-align: center;
		}
		
        .search-box {
			display: flex;
            margin-bottom: 20px;
			justify-content: center;
			align-items: center;
        }
        .search-box input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 2px solid #000;
			border-radius: 4px;
			font-family: Inknut-Antiqua;
        }
        .search-box button {
            padding: 8px 12px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-box button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
			background-color: #fff;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }
        th {
            background-color: #ccffcc;
        }
        tr:hover {
            background-color: #f9f9f9;
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
 
<h2>Daftar Pengguna Terdaftar</h2>
<div class="search-box">
    <form method="get" action="">
        <input type="text" name="cari" placeholder="Cari nama atau username..." value="<?php echo htmlspecialchars($cari); ?>">
        <button type="submit">Cari</button>
    </form>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
			<th>NIK</th>
            <th>Jenis Kelamin</th>
			<th>Alamat</th>
			<th>NO Telepon</th>
            <th>Email</th>
			<th>Username</th>
			<th>Password</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['id_pengguna']); ?></td>
            <td><?php echo htmlspecialchars($row['nama']); ?></td>
			<td><?php echo htmlspecialchars($row['nik']); ?></td>
            <td><?php echo $row['jk'] == '1' ? 'Laki-laki' : 'Perempuan'; ?></td>
			<td><?php echo htmlspecialchars($row['alamat']); ?></td>
			<td><?php echo htmlspecialchars($row['no_telp']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
			<td><?php echo htmlspecialchars($row['username']); ?></td>
			<td><?php echo htmlspecialchars($row['username']); ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

</body>
</html>
