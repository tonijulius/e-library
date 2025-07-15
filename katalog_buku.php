<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

// Proses pencarian
$keyword = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$whereClause = $keyword ? "WHERE judul LIKE '%$keyword%' OR kategori LIKE '%$keyword%'" : '';

// Ambil data katalog dari database
$query = "SELECT * FROM katalog_buku $whereClause ORDER BY kategori, judul ASC";
$result = mysqli_query($conn, $query);

// Kelompokkan berdasarkan kategori
$kategoriBuku = [];
while ($row = mysqli_fetch_assoc($result)) {
    $kategori = $row['kategori'];
    if (!isset($kategoriBuku[$kategori])) {
        $kategoriBuku[$kategori] = [];
    }
    $kategoriBuku[$kategori][] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Katalog Buku - E-Library</title>
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
		
        .search-container {
            text-align: center;
            margin: 30px;
        }
        .search-container input[type="text"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
        }
        .search-container button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
        }
        .kategori {
            margin: 40px;
        }
        .kategori h2 {
            border-bottom: 2px solid black;
            padding-bottom: 10px;
			text-align: center;
        }
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        .card {
            width: 200px;
            background-color: white;
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            border-radius: 8px;
        }
        .card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        .card h4 {
            margin: 10px 0;
        }
        .card a {
            text-decoration: none;
            color: blue;
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
            <a href="daftar_bacaan_online.php">BACA ONLINE</a>
            <a href="daftar_pinjam_buku.php">PINJAM BUKU</a>
			<a href="profil_pengguna.php">PROFIL</a>
			<a href="logout_pengguna.php" class="logout-btn">LOGOUT</a>

        </nav>
    </header>

    <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari berdasarkan judul atau kategori" value="<?php echo htmlspecialchars($keyword); ?>">
            <button type="submit">Enter</button>
        </form>
    </div>

    <?php foreach ($kategoriBuku as $kategori => $bukuList): ?>
        <div class="kategori">
            <h2><?php echo htmlspecialchars($kategori); ?></h2>
            <div class="cards">
                <?php foreach ($bukuList as $buku): ?>
                    <div class="card">
                        <?php $gambarPath = 'gambar/' . htmlspecialchars($buku['gambar']); ?>
						<img src="<?php echo $gambarPath; ?>" alt="Sampul Buku" width="100">
                        <h4><?php echo htmlspecialchars($buku['judul']); ?></h4>
                        <a href="detail_buku.php?id=<?php echo urlencode($buku['id_buku']); ?>">Lihat Detail</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
