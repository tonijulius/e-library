<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil ID buku dari parameter URL
if (!isset($_GET['id'])) {
    echo "ID buku tidak ditemukan.";
    exit();
}

$id_buku = $_GET['id'];

// Ambil data buku dari database
$query = "SELECT * FROM data_buku WHERE id_buku = '$id_buku'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Data buku tidak ditemukan.";
    exit();
}

$row = mysqli_fetch_assoc($result);

// Proses update saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $sinopsis = $_POST['sinopsis'];

    $link_file = $row['link_file']; // default ke file lama

    // Cek jika file baru diupload
    if (isset($_FILES['file_buku']) && $_FILES['file_buku']['error'] === UPLOAD_ERR_OK) {
        $nama_file = $_FILES['file_buku']['name'];
        $tmp_file = $_FILES['file_buku']['tmp_name'];
        $target_dir = "Buku/";
        $target_file = $target_dir . basename($nama_file);

        if (move_uploaded_file($tmp_file, $target_file)) {
            $link_file = $target_file;
        } else {
            echo "<script>alert('Gagal upload file baru.');</script>";
        }
    }

    $query_update = "UPDATE data_buku SET 
		isbn = '$isbn',
        judul = '$judul',
        penulis = '$penulis',
        penerbit = '$penerbit',
        tahun_terbit = '$tahun_terbit',
        kategori = '$kategori',
        sinopsis = '$sinopsis',
        link_file = '$link_file'
        WHERE id_buku = '$id_buku'";

    if (mysqli_query($conn, $query_update)) {
        echo "<script>alert('Buku berhasil diperbarui!'); window.location.href='daftar_buku.php';</script>";
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Buku</title>
    <style>
        body { font-family: Arial; background-color: #e5fe9b; margin: 0; }
		
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
		
		
        .form-container {
            max-width: 600px;
            margin: auto;
			margin-top: 20px;
            background-color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: 2px solid #000;
        }
        h2 { text-align: center; margin-bottom: 20px; }
        label { display: block; font-weight: bold; margin-top: 10px; }
        input, textarea {
            width: 95%;
            padding: 10px;
            margin-top: 5px;
            border: 2px solid black;
            background-color: #fefefe;
            font-size: 14px;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #38c72a;
            border: none;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: #2ea91e;
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
            <a href="daftarbuku.php">DAFTAR BUKU</a>
            <a href="dashboard.php">HOME</a>
        </nav>
    </header>
	
    <div class="form-container">
        <h2>Edit Data Buku</h2>
        <form method="POST" enctype="multipart/form-data">
            <label>ID Buku</label>
            <input type="text" name="id_buku" value="<?php echo $row['id_buku']; ?>" readonly>
			
			<label>ISBN</label>
            <input type="text" name="isbn" value="<?php echo $row['isbn']; ?>" required>
			
            <label>Judul</label>
            <input type="text" name="judul" value="<?php echo $row['judul']; ?>" required>

            <label>Penulis</label>
            <input type="text" name="penulis" value="<?php echo $row['penulis']; ?>" required>

            <label>Penerbit</label>
            <input type="text" name="penerbit" value="<?php echo $row['penerbit']; ?>" required>

            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" value="<?php echo $row['tahun_terbit']; ?>" required>

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?php echo $row['kategori']; ?>" required>

            <label>Sinopsis</label>
            <textarea name="sinopsis" rows="4"><?php echo $row['sinopsis']; ?></textarea>

            <label>File Buku (PDF)</label>
            <input type="file" name="file_buku" accept="application/pdf">
            <small>File saat ini: <?php echo basename($row['link_file']); ?></small>
			<br>
            <button type="submit">Simpan Perubahan</button>
        </form>
    </div>
</body>
</html>
