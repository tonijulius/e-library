<?php
session_start();
include 'koneksi.php';

// Cek jika bukan admin
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil input pencarian dan filter
$keyword = $_GET['keyword'] ?? '';
$filter_status = $_GET['status'] ?? '';

// Query dasar
$query = "SELECT s.*, u.nama AS nama_pengguna, d.judul 
          FROM sesi_baca s
          JOIN pengguna u ON s.id_pengguna = u.id_pengguna
          JOIN data_buku d ON s.id_buku = d.id_buku
          WHERE 1=1";

// Tambahkan filter keyword jika ada
if (!empty($keyword)) {
    $keyword_safe = mysqli_real_escape_string($conn, $keyword);
    $query .= " AND (u.nama LIKE '%$keyword_safe%' OR d.judul LIKE '%$keyword_safe%')";
}

// Tambahkan filter status jika dipilih
if (!empty($filter_status)) {
    $filter_status_safe = mysqli_real_escape_string($conn, $filter_status);
    $query .= " AND s.status = '$filter_status_safe'";
}

$query .= " ORDER BY s.id_sesi_baca DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Aktivitas Baca Online</title>
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
        input[type="text"], select {
            padding: 6px;
            margin-right: 8px;
        }
        button {
            padding: 6px 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        table {
            width: 100%;
            border-collapse: collapse;
			margin-top: 10px;
			background-color: #fff;
        }
        th, td {
            padding: 10px; border: 1px solid #ccc;
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
 
<h2>Daftar Aktivitas Baca Online Pengguna</h2>

<!-- Form pencarian & filter -->
<form method="get">
    <input type="text" name="keyword" placeholder="Cari nama/judul..." value="<?php echo htmlspecialchars($keyword); ?>">
    <select name="status">
        <option value="">Semua Status</option>
        <option value="aktif" <?php if ($filter_status === 'aktif') echo 'selected'; ?>>Aktif</option>
        <option value="selesai" <?php if ($filter_status === 'selesai') echo 'selected'; ?>>Selesai</option>
    </select>
    <button type="submit">Cari</button>
</form>

<table>
    <thead>
        <tr>
            <th>ID Sesi</th>
            <th>Nama Pengguna</th>
            <th>Judul Buku</th>
            <th>Waktu Mulai</th>
            <th>Waktu Selesai</th>
            <th>Waktu Selesai Manual</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id_sesi_baca']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_pengguna']); ?></td>
                <td><?php echo htmlspecialchars($row['judul']); ?></td>
                <td><?php echo $row['waktu_mulai']; ?></td>
                <td><?php echo $row['waktu_selesai']; ?></td>
                <td>
                    <?php
                        echo $row['waktu_selesai_manual'] ? $row['waktu_selesai_manual'] : '-';
                    ?>
                </td>
                <td><?php echo ucfirst($row['status']); ?></td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="7">Tidak ada sesi baca yang ditemukan.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

</body>
</html>
