<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna'];

$query = "SELECT p.*, d.judul, d.penulis, k.gambar
          FROM peminjaman p
          JOIN data_buku d ON p.id_buku = d.id_buku
          JOIN katalog_buku k ON d.id_buku = k.id_buku
          WHERE p.id_pengguna = '$id_pengguna' AND p.status_peminjaman = 'aktif' AND p.tgl_kembali > NOW()
          ORDER BY p.tgl_pinjam DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Peminjaman Buku</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
			font-family: Inknut-Antiqua;
            background-color: #e9ffae;
            margin: 0; 
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
        h1 { margin-bottom: 20px; text-align: center; }
        .buku-card { display: flex; background: #fff; align-items: center; border: 1px solid #ccc; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        .buku-card img { width: 100px; height: auto; margin-right: 20px; border-radius: 6px; }
        .buku-info h2 { margin: 0 0 5px 0; }
        .actions { margin-top: 10px; }
        .actions a, .actions form button {
            padding: 8px 12px;
            margin-right: 10px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions form { display: inline; }
    </style>
</head>
<body>
	<header>
        <div style="display: flex; align-items: center;">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <nav>
            <a href="katalog_buku.php">HOME</a>
			<a href="logout_pengguna.php">LOGOUT</a>
        </nav>
    </header>
	
    <h1>Daftar Buku yang Kamu Pinjam</h1>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="buku-card">
                <img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Sampul Buku">
                <div class="buku-info">
                    <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
                    <p><strong>Penulis:</strong> <?php echo htmlspecialchars($row['penulis']); ?></p>
                    <p><strong>Tanggal Kembali:</strong> <?php echo date("d-m-Y H:i", strtotime($row['tgl_kembali'])); ?></p>

                    <div class="actions">
                        <a href="baca_pinjam.php?id_buku=<?php echo urlencode($row['id_buku']); ?>">Baca Buku</a>
                        <form action="akhiri_pinjaman.php" method="post">
                            <input type="hidden" name="id_buku" value="<?php echo $row['id_buku']; ?>">
                            <button type="submit">Kembalikan Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Tidak ada buku yang sedang kamu pinjam saat ini.</p>
    <?php endif; ?>
</body>
</html>
