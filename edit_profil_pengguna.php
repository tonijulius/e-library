<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna'];
$query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $alamat = $_POST['alamat'];
    $no_telp = $_POST['no_telp'];
    $jk = $_POST['jk'];
    $password = $_POST['password'];

    // Enkripsi ulang password jika ada perubahan
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update = "UPDATE pengguna SET 
            nama = '$nama', 
            nik = '$nik',
            alamat = '$alamat', 
            no_telp = '$no_telp', 
            jk = '$jk',
            password = '$hashed_password' 
            WHERE id_pengguna = '$id_pengguna'";
    } else {
        $update = "UPDATE pengguna SET 
            nama = '$nama', 
            nik = '$nik',
            alamat = '$alamat', 
            no_telp = '$no_telp', 
            jk = '$jk' 
            WHERE id_pengguna = '$id_pengguna'";
    }

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Profil berhasil diperbarui'); window.location='profil_pengguna.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui profil');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profil Pengguna</title>
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
            width: 500px;
            background: white;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 0 10px #ccc;
        }
		h2 {
			text-align: center;
		}
        input, select {
            width: 95%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 12px;
        }
        button {
            padding: 10px 20px;
            background-color: steelblue;
            border: none;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: darkblue;
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
        </nav>
    </header>
	
<div class="container">
    <h2>Edit Profil</h2>
    <form method="post">
        <label>Nama:</label>
        <input type="text" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>

        <label>NIK:</label>
        <input type="text" name="nik" value="<?php echo htmlspecialchars($user['nik']); ?>" required>

        <label>Alamat:</label>
        <input type="text" name="alamat" value="<?php echo htmlspecialchars($user['alamat']); ?>" required>

        <label>No. Telepon:</label>
        <input type="text" name="no_telp" value="<?php echo htmlspecialchars($user['no_telp']); ?>" required>

        <label>Jenis Kelamin:</label>
        <select name="jk" required>
            <option value="1" <?php if ($user['jk'] == 1) echo 'selected'; ?>>Laki-laki</option>
            <option value="0" <?php if ($user['jk'] == 0) echo 'selected'; ?>>Perempuan</option>
        </select>

        <label>Username:</label>
        <input type="text" value="<?php echo htmlspecialchars($user['username']); ?>" disabled>

        <label>Password (biarkan kosong jika tidak ingin diubah):</label>
        <input type="password" name="password">

        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
