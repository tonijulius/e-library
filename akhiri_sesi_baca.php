<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

// Pastikan pengguna sudah login
if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

$id_pengguna = $_SESSION['pengguna'];

if (!isset($_POST['id_buku'])) {
    echo "ID buku tidak ditemukan.";
    exit();
}

$id_buku = $_POST['id_buku'];


// Ambil sesi baca yang aktif untuk pengguna dan buku ini
$query = "SELECT * FROM sesi_baca 
          WHERE id_pengguna = '$id_pengguna' 
          AND id_buku = '$id_buku' 
          AND status = 'aktif' 
          ORDER BY id_sesi_baca DESC LIMIT 1";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) === 1) {
    $now = date('Y-m-d H:i:s');

    // Update sesi menjadi selesai
    $update = "UPDATE sesi_baca 
               SET status = 'selesai', waktu_selesai_manual = '$now' 
               WHERE id_pengguna = '$id_pengguna' AND id_buku = '$id_buku' AND status = 'aktif'";
    if (mysqli_query($conn, $update)) {
        // Kembalikan status buku menjadi 'tersedia'
        $update_status = "UPDATE data_buku SET status_buku = 'tersedia' WHERE id_buku = '$id_buku'";
        mysqli_query($conn, $update_status);

        // Redirect ke halaman katalog
        header("Location: katalog_buku.php");
        exit();
    } else {
        echo "Gagal mengakhiri sesi baca.";
    }
} else {
    echo "Sesi baca tidak ditemukan atau sudah selesai.";
}
?>
