<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

if (!isset($_GET['id_buku'])) {
    echo "ID buku tidak ditemukan.";
    exit();
}

$id_buku = $_GET['id_buku'];
$id_pengguna = $_SESSION['pengguna'];

$sql = "SELECT b.*, s.waktu_mulai, s.waktu_selesai, s.status
        FROM data_buku b
        JOIN sesi_baca s ON b.id_buku = s.id_buku
        WHERE b.id_buku = '$id_buku' AND s.id_pengguna = '$id_pengguna' AND s.status = 'aktif'
        ORDER BY s.id_sesi_baca DESC LIMIT 1";

$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) == 0) {
    echo "Buku tidak ditemukan atau sesi tidak aktif.";
    exit();
}

$data = mysqli_fetch_assoc($result);
$judul = $data['judul'];
$penulis = $data['penulis'];
$link_file = $data['link_file'];
$waktu_selesai = $data['waktu_selesai'];

// Kirim timestamp waktu_selesai ke JS
$waktu_selesai_timestamp = strtotime($waktu_selesai) * 1000;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baca Online - <?php echo htmlspecialchars($judul); ?></title>
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

        .konten { padding: 20px; }
        .info { margin-bottom: 20px; }
        .btn-keluar { background: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        
         iframe {
            width: 100%;
            height: 80vh;
            border: none;
        }
        .footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
        }
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

        
    </div>
    <div class="konten">
        <div class="info">
            <p><strong>Judul:</strong> <?php echo htmlspecialchars($judul); ?></p>
            <p><strong>Penulis:</strong> <?php echo htmlspecialchars($penulis); ?></p>
            <p><strong>Waktu Berakhir:</strong> <?php echo date('H:i, d M Y', strtotime($waktu_selesai)); ?></p>
            <form action="akhiri_sesi_baca.php" method="post">
                <input type="hidden" name="id_buku" value="<?php echo htmlspecialchars($id_buku); ?>">
                <button type="submit" class="btn-keluar">Akhiri Sesi Baca Sekarang</button>
            </form>
        </div>
        <iframe src="<?php echo htmlspecialchars($link_file); ?>"></iframe>
		
		<div class="footer">
        &copy; <?php echo date("Y"); ?> E-Library - Semua Hak Dilindungi
    </div>
    </div>

    <script>
        const countdownElement = document.getElementById("countdown");
        const waktuSelesai = new Date(<?php echo $waktu_selesai_timestamp; ?>);

        const timerInterval = setInterval(() => {
            const now = new Date();
            const total = waktuSelesai - now;

            if (total <= 0) {
                clearInterval(timerInterval);

                // Kirim permintaan ke akhiri_sesi_baca.php secara otomatis
                fetch('akhiri_sesi_baca.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'id_buku=<?php echo urlencode($id_buku); ?>'
                })
                .then(response => response.text())
                .then(data => {
                    window.location.href = 'katalog_buku.php';
                })
                .catch(error => {
                    console.error('Gagal mengakhiri sesi otomatis:', error);
                    window.location.href = 'katalog_buku.php';
                });
                return;
            }

            const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((total / (1000 * 60)) % 60);
            const seconds = Math.floor((total / 1000) % 60);

            countdownElement.textContent = `Sisa waktu: ${hours}j ${minutes}m ${seconds}d`;
        }, 1000);
    </script>
</body>
</html>
