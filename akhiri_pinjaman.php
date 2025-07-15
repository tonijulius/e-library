<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

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




// Cek apakah ada peminjaman aktif untuk buku ini oleh pengguna
$cek = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_pengguna = '$id_pengguna' AND id_buku = '$id_buku' AND status_peminjaman = 'aktif'");

if (!$cek) {
    echo "Gagal menjalankan query cek peminjaman.";
    exit();
}

if (mysqli_num_rows($cek) == 0) {
    echo "Tidak ada peminjaman aktif yang perlu diakhiri untuk buku ini.";
    exit();
}

// Update status peminjaman dan waktu pengembalian
$now = date("Y-m-d H:i:s");
$update = mysqli_query($conn, "UPDATE peminjaman SET status_peminjaman = 'selesai', tgl_pengembalian = '$now' WHERE id_pengguna = '$id_pengguna' AND id_buku = '$id_buku' AND status_peminjaman = 'aktif'");

if (!$update) {
    echo "Gagal mengakhiri peminjaman.";
    exit();
}

// Update status buku menjadi 'tersedia'
$update_buku = mysqli_query($conn, "UPDATE data_buku SET status_buku = 'tersedia' WHERE id_buku = '$id_buku'");

if (!$update_buku) {
    echo "Peminjaman berhasil diakhiri, tetapi gagal memperbarui status buku.";
} else {
    echo "Peminjaman berhasil diakhiri.";
}

header("Location: katalog_buku.php");
exit();
?>
