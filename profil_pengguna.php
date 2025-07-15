<?php
session_start();
include 'koneksi.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

// Ambil data pengguna dari session
$id_pengguna = $_SESSION['pengguna'];
$query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna - E-Library</title>
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
            width: 60%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 10px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            width: 30%;
        }
        .btn-edit {
            display: block;
            margin: 30px auto 0;
            padding: 10px 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
			width: 25%;
			text-align: center;
            text-decoration: none;
        }
        .btn-edit:hover {
            background-color: #218838;
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
        <h2>Profil Pengguna</h2>
        <table>
            <tr>
                <td class="label">Nama</td>
                <td>: <?php echo htmlspecialchars($user['nama']); ?></td>
            </tr>
            <tr>
                <td class="label">NIK</td>
                <td>: <?php echo htmlspecialchars($user['nik']); ?></td>
            </tr>
			<tr>
				<td class="label">Jenis Kelamin</td>
				<td>: 
					<?php 
					echo $user['jk'] == 1 ? 'Laki-laki' : 'Perempuan'; 
					?>
				</td>
			</tr>
            <tr>
                <td class="label">Alamat</td>
                <td>: <?php echo htmlspecialchars($user['alamat']); ?></td>
            </tr>
            <tr>
                <td class="label">No Telepon</td>
                <td>: <?php echo htmlspecialchars($user['no_telp']); ?></td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>: <?php echo htmlspecialchars($user['email']); ?></td>
            </tr>
            <tr>
                <td class="label">Username</td>
                <td>: <?php echo htmlspecialchars($user['username']); ?></td>
            </tr>
        </table>
        <a href="edit_profil_pengguna.php" class="btn-edit">Edit Profil</a>
    </div>
</body>
</html>
