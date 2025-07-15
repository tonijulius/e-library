<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

$cari = '';
if (isset($_GET['cari'])) {
    $cari = mysqli_real_escape_string($conn, $_GET['cari']);
    $query = "SELECT * FROM data_buku 
              WHERE judul LIKE '%$cari%' OR penulis LIKE '%$cari%' 
              ORDER BY id_buku ASC";
} else {
    $query = "SELECT * FROM data_buku ORDER BY id_buku ASC";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku - E-Library</title>
    <style>
        body {
            margin: 0;
            font-family: Inknut-Antiqua;
            background-color: #e9ffae;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
			height: 100px;
            padding: 10px 20px;
            background-color: #f9fffa;
        }

        .header-left {
            display: flex;
            align-items: center;
        }

        .header img {
            height: 110px;
			width: 150px;
            margin-right: 15px;
        }

        .header h1 {
            font-size: 50px;
			font-family: Inknut-Antiqua;
            margin: 0;
            font-weight: bold;
        }

        .home-link {
            font-weight: bold;
            font-size: 16px;
            text-decoration: none;
            color: black;
        }

        h2 {
            text-align: center;
            margin-top: 30px;
            font-size: 28px;
        }

        .tambah-btn {
            display: block;
            margin: 20px auto;
            background-color: #fff;
            padding: 12px 30px;
            border: 1px solid #000;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
        }

        .tambah-btn:hover {
            background-color: #d0ffd0;
        }
		
		.search-form {
			display: flex;
			justify-content: center;
			align-items: center;
			margin: 20px auto;
			gap: 10px;
		}

		.search-form input[type="text"] {
			padding: 10px;
			width: 300px;
			font-size: 16px;
			border: 2px solid #000;
			border-radius: 4px;
			font-family: Inknut-Antiqua;
		}

		.search-form button {
			padding: 10px 20px;
			background-color: #38c72a;
			color: white;
			border: 2px solid #000;
			border-radius: 4px;
			font-weight: bold;
			cursor: pointer;
			transition: background-color 0.3s ease;
		}

		.search-form button:hover {
			background-color: #2da620;
		}

		
        table {
            width: 95%;
            margin: 30px auto;
            border-collapse: collapse;
            background-color: #fff;
        }

        th, td {
            border: 1px solid #000;
            padding: 10px 15px;
            text-align: center;
        }

        th {
            background-color: #ccffcc;
        }

        tr:nth-child(even) {
            background-color: #f2fff2;
        }

        .aksi-btn {
            margin-right: 5px;
            padding: 6px 10px;
            font-size: 14px;
            background-color: #fff;
            border: 1px solid #000;
            text-decoration: none;
            color: black;
            transition: background-color 0.2s;
        }

        .aksi-btn:hover {
            background-color: #d0ffd0;
        }

        .link-baca {
            color: blue;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <img src="gambar/buku2.png" alt="Logo">
            <h1>E-LIBRARY</h1>
        </div>
        <a href="dashboard.php" class="home-link">HOME</a>
    </div>

    <h2>DAFTAR BUKU</h2>

    <a href="tambah_buku.php" class="tambah-btn">TAMBAH BUKU</a>
	
	<form method="GET" action="daftarbuku.php" class="search-form">
    <input type="text" name="cari" placeholder="Cari judul atau penulis..." 
           value="<?php echo isset($_GET['cari']) ? htmlspecialchars($_GET['cari']) : ''; ?>">
    <button type="submit">Cari</button>
	</form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
				<th>ISBN</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Kategori</th>
                <th>Link File</th>
                <th>Status</th>
                <th style="width: 120px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while($buku = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($buku['id_buku']) ?></td>
				<td><?= htmlspecialchars($buku['isbn']) ?></td>
                <td><?= htmlspecialchars($buku['judul']) ?></td>
                <td><?= htmlspecialchars($buku['penulis']) ?></td>
                <td><?= htmlspecialchars($buku['penerbit']) ?></td>
                <td><?= htmlspecialchars($buku['tahun_terbit']) ?></td>
                <td><?= htmlspecialchars($buku['kategori']) ?></td>
                <td>
                    <?php if (!empty($buku['link_file'])): ?>
						<a href="<?= htmlspecialchars($buku['link_file']) ?>" target="_blank">Baca</a>

                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($buku['status_buku']) ?></td>
                <td>
                    <a href="edit_daftar_buku.php?id=<?= $buku['id_buku'] ?>" class="aksi-btn">Edit</a>
                    <a href="hapus_daftar_buku.php?id=<?= $buku['id_buku'] ?>" class="aksi-btn" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
