<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna'];

// Ambil sesi baca aktif
$query = "SELECT s.*, d.judul, k.gambar 
          FROM sesi_baca s 
          JOIN data_buku d ON s.id_buku = d.id_buku
          JOIN katalog_buku k ON d.id_buku = k.id_buku
          WHERE s.id_pengguna = '$id_pengguna' AND s.status = 'aktif' AND s.waktu_selesai > NOW()";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daftar Bacaan Online</title>
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
		
        .container {
            margin-top: 30px;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        .card img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            margin-right: 20px;
        }
        .card-content {
            flex: 1;
        }
        .card-content h3 {
            margin: 0 0 10px 0;
        }
        .card-content p {
            margin: 5px 0;
        }
        .card-content a {
            text-decoration: none;
            color: white;
            background: #28a745;
            padding: 8px 12px;
            border-radius: 5px;
            font-size: 0.9em;
        }
        .no-session {
            text-align: center;
            margin-top: 50px;
            font-size: 1.2em;
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
            <a href="katalog_buku.php">HOME</a>
			<a href="logout_pengguna.php">LOGOUT</a>
        </nav>
    </header>

    <div class="container">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="card">
                    <img src="gambar/<?php echo htmlspecialchars($row['gambar']); ?>" alt="Sampul Buku" width="100">
                    <div class="card-content">
                        <h3><?php echo htmlspecialchars($row['judul']); ?></h3>
                        <p>Mulai: <?php echo date('d-m-Y H:i', strtotime($row['waktu_mulai'])); ?></p>
                        <p>Berakhir: <?php echo date('d-m-Y H:i', strtotime($row['waktu_selesai'])); ?></p>
						<br>
                        <a href="baca_online.php?id_buku=<?php echo $row['id_buku']; ?>">Lanjutkan Membaca</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-session">Tidak ada buku yang sedang kamu baca atau waktu bacamu sudah habis.</p>
        <?php endif; ?>
    </div>
</body>
</html>
