<?php
session_start();
include 'koneksi.php';

// Validasi login admin
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil filter status jika ada
$keyword = $_GET['keyword'] ?? '';
$status = $_GET['status'] ?? '';

// Query dasar
$sql = "SELECT p.*, u.nama AS nama_pengguna, d.judul 
        FROM peminjaman p
        JOIN pengguna u ON p.id_pengguna = u.id_pengguna
        JOIN data_buku d ON p.id_buku = d.id_buku";

if (!empty($keyword)) {
    $keyword_safe = mysqli_real_escape_string($conn, $keyword);
    $query .= " AND (u.nama LIKE '%$keyword_safe%' OR d.judul LIKE '%$keyword_safe%')";
}

if ($status === 'aktif' || $status === 'selesai') {
    $sql .= " WHERE p.status_peminjaman = '$status'";
}

$sql .= " ORDER BY p.id_peminjaman DESC";

$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peminjaman Buku</title>
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
		
		form { 
			display: flex;
            margin-bottom: 20px;
			justify-content: center;
			align-items: center;
			
		}
        input[type="text"]{
            padding: 10px;
            width: 300px;
            border: 2px solid #000;
			border-radius: 4px;
			font-family: Inknut-Antiqua;
			margin-right: 5px;
        }
        button {
            padding: 10px 12px;
            border: 2px solid #000;
			border-radius: 4px;
            background-color: #4CAF50;
            color: white;
            border: none;
			font-family: Inknut-Antiqua;
        }
		
        .filter {
            margin-bottom: 20px;
        }
        .filter a {
            margin-right: 10px;
            text-decoration: none;
            color: #007BFF;
        }
        .filter a.active {
            font-weight: bold;
            text-decoration: underline;
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
        }
        th {  
			background-color: #ccffcc;
		}
        tr:hover { background-color: #f9f9f9; }
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
 
<h2>Daftar Peminjaman Buku</h2>

<!-- Form pencarian -->
<form method="get">
    <input type="text" name="keyword" placeholder="Cari nama/judul..." value="<?php echo htmlspecialchars($keyword); ?>">
    <button type="submit">Cari</button>
</form>

<div class="filter">
    <strong>Filter Status:</strong>
    <a href="?status=" class="<?php echo ($status === '') ? 'active' : ''; ?>">Semua</a>
    <a href="?status=aktif" class="<?php echo ($status === 'aktif') ? 'active' : ''; ?>">Aktif</a>
    <a href="?status=selesai" class="<?php echo ($status === 'selesai') ? 'active' : ''; ?>">Selesai</a>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pengguna</th>
            <th>Judul Buku</th>
            <th>Tanggal Pinjam</th>
            <th>Tanggal Kembali</th>
            <th>Tanggal Pengembalian</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_peminjaman']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_pengguna']); ?></td>
                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                <td><?php echo $row['tgl_pinjam']; ?></td>
                <td><?php echo $row['tgl_kembali']; ?></td>
                <td><?php echo $row['tgl_pengembalian'] ?? '-'; ?></td>
                <td><?php echo ucfirst($row['status_peminjaman']); ?></td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">Belum ada data peminjaman.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
