<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_buku = $_POST['id_buku'];
    $isbn = $_POST['isbn'];
    $judul = $_POST['judul'];
    $penulis = $_POST['penulis'];
    $penerbit = $_POST['penerbit'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $kategori = $_POST['kategori'];
    $sinopsis = $_POST['sinopsis'];

    $upload_dir = "Buku/";
    $file_name = basename($_FILES["link_file"]["name"]);
    $target_file = $upload_dir . $file_name;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($file_type != "pdf") {
        echo "<script>alert('Hanya file PDF yang diperbolehkan!');</script>";
    } elseif (move_uploaded_file($_FILES["link_file"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO data_buku (id_buku, isbn, judul, penulis, penerbit, tahun_terbit, kategori, sinopsis, link_file) 
                  VALUES ('$id_buku', '$isbn', '$judul', '$penulis', '$penerbit', '$tahun_terbit', '$kategori', '$sinopsis', '$target_file')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Buku berhasil ditambahkan!'); window.location.href='daftar_buku.php';</script>";
        } else {
            echo "Error saat menyimpan data: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Upload file gagal!');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Buku</title>
    <style>
        body { 
			background-color: #e5fe9b; 
			font-family: Arial; margin: 0; 
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
        .container { padding: 30px 100px; }
        h2 { text-align: center; font-size: 28px; margin-bottom: 30px; }
        form {
            display: flex;
            flex-direction: column;
            max-width: 900px;
            margin: auto;
        }
        label { font-weight: bold; margin-bottom: 5px; }
        input, textarea {
            margin-bottom: 20px;
            padding: 10px;
            font-size: 16px;
            border: 2px solid black;
            background-color: #fffafa;
        }
        textarea { resize: vertical; }
        button {
            width: 200px;
            padding: 10px;
            font-weight: bold;
            background-color: #20c020;
            color: white;
            border: 2px solid black;
            cursor: pointer;
            font-size: 18px;
            align-self: flex-start;
        }
        button:hover { background-color: #1a9b1a; }
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

    <div class="container">
        <h2>DAFTAR BUKU</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="id_buku">ID BUKU</label>
            <input type="text" name="id_buku" required>

            <label for="isbn">ISBN</label>
            <input type="text" name="isbn" required>

            <label for="judul">JUDUL</label>
            <input type="text" name="judul" required>

            <label for="penulis">PENULIS</label>
            <input type="text" name="penulis" required>

            <label for="penerbit">PENERBIT</label>
            <input type="text" name="penerbit" required>

            <label for="tahun_terbit">TAHUN TERBIT</label>
            <input type="number" name="tahun_terbit" required>

            <label for="kategori">KATEGORI</label>
            <input type="text" name="kategori" required>

            <label for="sinopsis">SINOPSIS</label>
            <textarea name="sinopsis" rows="4"></textarea>

            <label for="link_file">UPLOAD FILE PDF</label>
            <input type="file" name="link_file" accept="application/pdf" required>

            <button type="submit">TAMBAHKAN</button>
        </form>
    </div>
</body>
</html>
