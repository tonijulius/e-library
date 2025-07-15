<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$pesan = "";

// Proses form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $id_buku = $_POST['id_buku'];
    $kategori = $_POST['kategori'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "gambar/";

    // Validasi id_buku
    $cek = mysqli_query($conn, "SELECT id_buku FROM data_buku WHERE id_buku = '$id_buku'");
    if (mysqli_num_rows($cek) == 0) {
        $pesan = "ID Buku tidak ditemukan di database utama.";
    } else {
        // Upload gambar
        if (!is_dir($folder)) mkdir($folder);
        move_uploaded_file($tmp, $folder . $gambar);

        // Simpan ke katalog
        $query = "INSERT INTO katalog_buku (id_buku, judul, kategori, gambar) 
                  VALUES ('$id_buku', '$judul', '$kategori', '$gambar')";
        if (mysqli_query($conn, $query)) {
            $pesan = "Buku berhasil ditambahkan ke katalog.";
        } else {
            $pesan = "Gagal menambahkan ke katalog.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Atur Katalog Buku</title>
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
		
        h2 {
            text-align: center;
            color: #333;
        }
        .form-container {
            background: #fff;
            padding: 20px 30px;
            border-radius: 10px;
            max-width: 500px;
            margin: auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="file"] {
            margin: 10px 0 15px;
        }
		
		img#preview {
            display: none;
            max-width: 100%;
            height: auto;
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 5px;
            margin-bottom: 15px;
        }
		
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        .pesan {
            margin-bottom: 15px;
            padding: 10px;
            background: #e0f7fa;
            color: #00796b;
            border-left: 5px solid #00796b;
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
            <a href="atur_katalog.php">KATALOG</a>
            <a href="dashboard.php">HOME</a>
        </nav>
    </header>
	
    <h2>Tambah Katalog Buku</h2>
    <div class="form-container">
        <?php if ($pesan != "") echo "<div class='pesan'>$pesan</div>"; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="gambar">Upload Gambar Sampul:</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" onchange="previewGambar()" required>
			<img id="preview" src="#" alt="Preview Gambar">
			<br>

            <label for="judul">Judul Buku:</label>
            <input type="text" name="judul" id="judul" required>

            <label for="kategori">Kategori:</label>
            <input type="text" name="kategori" id="kategori" required>

            <label for="id_buku">Pilih ID Buku:</label>
            <select name="id_buku" id="id_buku" required>
                <option value="">-- Pilih ID Buku --</option>
                <?php
                $buku = mysqli_query($conn, "SELECT id_buku, judul FROM data_buku ORDER BY id_buku ASC");
                while ($row = mysqli_fetch_assoc($buku)) {
                    echo "<option value='" . $row['id_buku'] . "'>" . $row['id_buku'] . " - " . $row['judul'] . "</option>";
                }
                ?>
            </select>

            <button type="submit">Tambahkan</button>
        </form>
    </div>
	<script>
		function previewGambar() {
			const input = document.getElementById('gambar');
			const preview = document.getElementById('preview');

			const file = input.files[0];
			if (file) {
				const reader = new FileReader();
				reader.onload = function(e) {
					preview.src = e.target.result;
					preview.style.display = 'block';
				};
				reader.readAsDataURL(file);
			}
		}
	</script>
</body>
</html>
