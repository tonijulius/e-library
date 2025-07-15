<?php
include 'koneksi.php';
session_start();

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Cek apakah username sudah digunakan
    $cek = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    if (mysqli_num_rows($cek) > 0) {
        $message = "Username sudah digunakan.";
    } else {
        $insert = mysqli_query($conn, "INSERT INTO admin (nama, username, password)
                                       VALUES ('$nama', '$username', '$password')");
        if ($insert) {
            header("Location: login_admin.php?daftar=berhasil");
            exit();
        } else {
            $message = "Pendaftaran gagal. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; max-width: 500px; margin: auto; }
        input, button { width: 100%; padding: 10px; margin: 10px 0; }
        .error { color: red; }
    </style>
</head>
<body>
    <h2>Registrasi Admin Baru</h2>
    <?php if (!empty($message)) echo "<p class='error'>$message</p>"; ?>
    <form method="post" action="">
        <label>Nama Lengkap</label>
        <input type="text" name="nama" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Daftar</button>
    </form>
    <p><a href="login_admin.php">Sudah punya akun? Login di sini</a></p>
</body>
</html>
