<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data katalog yang akan diedit
if (!isset($_GET['id'])) {
    header("Location: atur_katalog.php");
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM katalog_buku WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) !== 1) {
    echo "Data tidak ditemukan.";
    exit();
}

$data = mysqli_fetch_assoc($result);

// Ambil semua data_buku untuk dropdown
$buku_query = mysqli_query($conn, "SELECT id_buku FROM data_buku ORDER BY id_buku ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'];
    $kategori = $_POST['kategori'];
    $id_buku = $_POST['id_buku'];

    // Upload gambar baru jika ada
    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $folder = "gambar/";

        move_uploaded_file($tmp, $folder . $gambar);

      

        $update = "UPDATE katalog_buku SET gambar='$gambar', judul='$judul', kategori='$kategori', id_buku='$id_buku' WHERE id='$id'";
    } else {
        $update = "UPDATE katalog_buku SET judul='$judul', kategori='$kategori', id_buku='$id_buku' WHERE id='$id'";
    }

    if (mysqli_query($conn, $update)) {
        header("Location: atur_katalog.php");
        exit();
    } else {
        echo "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Katalog Buku</title>
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
        }
        form {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
        }
        button {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }
        img.preview {
            max-width: 150px;
            display: block;
            margin-bottom: 10px;
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
	
    <h2>Edit Katalog Buku</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Gambar Sampul:</label>
		<img id="preview" src="gambar/<?php echo $data['gambar']; ?>" alt="Sampul Buku" class="preview">
        <input type="file" name="gambar"  onchange="previewGambar(event)">

        <label>Judul Buku:</label>
        <input type="text" name="judul" value="<?php echo htmlspecialchars($data['judul']); ?>" required>

        <label>Kategori:</label>
        <input type="text" name="kategori" value="<?php echo htmlspecialchars($data['kategori']); ?>" required>

        <label>ID Buku (dari data_buku):</label>
        <select name="id_buku" required>
            <option value="">-- Pilih ID Buku --</option>
            <?php while ($buku = mysqli_fetch_assoc($buku_query)): ?>
                <option value="<?php echo $buku['id_buku']; ?>" <?php echo ($data['id_buku'] === $buku['id_buku']) ? 'selected' : ''; ?>>
                    <?php echo $buku['id_buku']; ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>
	<script>
	function previewGambar(event) {
		const reader = new FileReader();
		reader.onload = function(){
			const output = document.getElementById('preview');
			output.src = reader.result;
		};
		reader.readAsDataURL(event.target.files[0]);
	}
	</script>

</body>
</html>
