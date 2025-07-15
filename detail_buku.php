<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID Buku tidak ditemukan.";
    exit();
}

$id_buku = $_GET['id'];
$query = "SELECT db.*, kb.gambar 
          FROM data_buku db 
          JOIN katalog_buku kb ON db.id_buku = kb.id_buku 
          WHERE db.id_buku = '$id_buku'";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "Data buku tidak ditemukan.";
    exit();
}


$buku = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Detail Buku - E-Library</title>
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
            display: flex;
            padding: 10px;
            gap: 10px;
        }
        .cover {
            width: 300px;
            height: 440px;
            border: 1px solid #000;
        }
		
       .book-details {
		  margin-top: 20px;
		  max-width: 600px;
		}

		.detail-item {
		  display: flex;
		  margin-bottom: 10px;
		  align-items: flex-start;
		}

		.detail-item .label {
		  width: 150px;
		  font-weight: bold;
		}

		.detail-item .colon {
		  width: 10px;
		  text-align: center;
		}

		.detail-item .value {
		  flex: 1;
		}

        .buttons {
			margin-left: 350px;
			margin-top: 0px;
        }
        .btn {
            background-color: #32b60c;
            color: white;
            padding: 15px 30px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 20px;
            display: inline-block;
        }
		
		.modal {
		  display: none;
		  position: fixed;
		  z-index: 10;
		  left: 0;
		  top: 0;
		  width: 100%; height: 100%;
		  background-color: rgba(0,0,0,0.4);
		}

		.modal-content {
		  background-color: #fff;
		  margin: 15% auto;
		  padding: 20px;
		  width: 300px;
		  border-radius: 8px;
		  text-align: center;
		  font-family: Inknut-Antiqua;
		}
		
		.modal-content input[type="hidden"] {
			display: none;
		}
		
		.modal-content select {
			width: 100%;
			padding: 10px;
			border-radius: 6px;
			border: 1px solid #ccc;
			font-size: 16px;
			margin-bottom: 15px;
			box-sizing: border-box;
		}
		.modal-content button {
			padding: 10px 20px;
			background-color: #007bff; /* Warna biru */
			color: #fff;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 16px;
			transition: background-color 0.3s;
		}
		
		.modal-content button:hover {
			background-color: #0056b3;
		}
		
		.close {
		  float: right;
		  font-size: 20px;
		  cursor: pointer;
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
			<a href="profil_pengguna.php">PROFIL</a>
			<a href="logout_pengguna.php">LOGOUT</a>
        </nav>
    </header>

    <div class="container">
        <img class="cover" src="gambar/<?php echo htmlspecialchars($buku['gambar']); ?>" alt="Sampul Buku">
		<div class="book-details">
			  <div class="detail-item">
				<span class="label">Judul</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['judul']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">ISBN</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['isbn']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Penulis</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['penulis']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Penerbit</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['penerbit']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Tahun Terbit</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['tahun_terbit']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Kategori</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['kategori']); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Sinopsis</span>
				<span class="colon">:</span>
				<span class="value"><?php echo nl2br(htmlspecialchars($buku['sinopsis'])); ?></span>
			  </div>
			  <div class="detail-item">
				<span class="label">Status Buku</span>
				<span class="colon">:</span>
				<span class="value"><?php echo htmlspecialchars($buku['status_buku']); ?></span>
			  </div>
			</div>
			    
        </div>
			<div class="buttons">
                <button class="btn" onclick="openModal()">BACA ONLINE</button>
				<button class="btn" onclick="openModalPinjam()">PINJAM BUKU</button>
            </div>
			
			<div id="modalBaca" class="modal">
				 <div class="modal-content">
					<span class="close" onclick="closeModal()">&times;</span>
					<h3>Pilih Durasi Baca</h3>
					<form method="post" action="atur_sesi_baca.php">
						<input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
						<select name="durasi" type="number" required>
							<option value="5">5 Menit</option>
							<option value="30">30 Menit</option>
							<option value="60">1 Jam</option>
							<option value="120">2 Jam</option>
						</select>
						<br><br>
						<button type="submit">Mulai Baca</button>
					</form>
				 </div>
			</div>
			
			<div id="modalPinjam" class="modal">
				<div class="modal-content">
				<span class="close" onclick="closeModal()">&times;</span>
					<h3>Pilih Durasi Peminjaman</h3>
					<form method="post" action="atur_peminjaman.php">
						<input type="hidden" name="id_buku" value="<?php echo $id_buku; ?>">
							<select name="durasi" required>
								<option value="1">1 Hari</option>
								<option value="3">3 Hari</option>
								<option value="7">7 Hari</option>
								<option value="14">14 Hari</option>
							</select>
							<br><br>
							<button type="submit">Pinjam Buku</button>
					</form>
				</div>
			</div>

		<script>
			function openModal() {
				document.getElementById('modalBaca').style.display = 'block';
				}
			function closeModal() {
				document.getElementById('modalBaca').style.display = 'none';
				}
			function openModalPinjam() {
				document.getElementById('modalPinjam').style.display = 'block';
				}
			function closeModal() {
				document.getElementById('modalPinjam').style.display = 'none';
				}
		</script>
</body>
</html>
