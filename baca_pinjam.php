<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna'];

$query = "SELECT p.*, d.judul, d.penulis, d.link_file, k.gambar 
          FROM peminjaman p
          JOIN data_buku d ON p.id_buku = d.id_buku
          JOIN katalog_buku k ON d.id_buku = k.id_buku
          WHERE p.id_pengguna = '$id_pengguna' AND p.status_peminjaman = 'aktif' AND p.tgl_kembali > NOW()
          ORDER BY p.id_peminjaman DESC LIMIT 1";


$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<h2>Tidak ada buku yang sedang kamu pinjam saat ini.</h2>";
    exit();
}

$data = mysqli_fetch_assoc($result);
$judul = $data['judul'];
$penulis = $data['penulis'];
$gambar = $data['gambar'];
$id_buku = $data['id_buku'];
$link_file = $data['link_file'];
$tgl_kembali = strtotime($data['tgl_kembali']) * 1000; // for JS countdown
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Baca Pinjam Buku</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { 
			font-family: Inknut-Antiqua;
            background-color: #e9ffae;
            margin: 0; 
		}
		
        .header {
			background-color: #f8fffa;
			color: black;
			padding: 15px 30px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.header img {
			height: 50px;
			margin-right: 15px;
		}

		.header h1 {
			font-size: 24px;
			margin: 0;
		}

		.header nav a {
			color: black;
			text-decoration: none;
			margin-left: 20px;
			font-weight: bold;
		}

		.countdown {
			font-weight: bold;
			font-size: 16px;
			color: red;
			margin-left: 20px;
		}
        iframe { width: 100%; height: 600px; border: 1px solid #ccc; margin-top: 20px; }
        .info { display: flex; gap: 20px; align-items: center; }
        .info img { width: 150px; height: auto; border-radius: 8px; }
		.btn-kembali { background: #e74c3c; color: white; padding: 10px 20px; border: none; border-radius: 6px; cursor: pointer; margin-top: 10px; }
        .btn-kembali:hover { background: #c0392b; }
    </style>
</head>
<body>
<div class="header">
		<div style="display: flex; align-items: center;">
			<img src="gambar/buku2.png" alt="Logo">
			<h1>E-LIBRARY</h1>
		</div>
		
		<div style="display: flex; align-items: center;">
			<nav>
				<a href="katalog_buku.php">HOME</a>
			</nav>
			<span id="countdown" class="countdown"></span>
		</div>
	</div>

<div class="info">
    <img src="<?php echo 'gambar/' . htmlspecialchars($gambar); ?>" alt="Sampul Buku">
    <div>
        <h2><?php echo htmlspecialchars($judul); ?></h2>
        <p><strong>Penulis:</strong> <?php echo htmlspecialchars($penulis); ?></p>
		<form action="akhiri_pinjaman.php" method="post">
            <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">
            <button type="submit" class="btn-kembali">Kembalikan Sekarang</button>
        </form>
    </div>
</div>

<iframe src="<?php echo htmlspecialchars($data['link_file']); ?>"></iframe>

<script>
    const countdownElement = document.getElementById("countdown");
    const waktuSelesai = <?php echo $tgl_kembali; ?>;

    function updateCountdown() {
        const now = new Date().getTime();
        const distance = waktuSelesai - now;

        if (distance <= 0) {
            alert("Waktu pinjam habis. Kamu akan diarahkan ke halaman utama.");
            window.location.href = 'auto_kembalikan.php?id_buku=<?php echo $id_buku; ?>';
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        countdownElement.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);
</script>
</body>
</html>
