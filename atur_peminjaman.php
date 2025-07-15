<?php
session_start();
include 'koneksi.php';

// Pastikan pengguna sudah login
if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

// Set zona waktu
date_default_timezone_set('Asia/Jakarta');

// Ambil data dari form
$id_pengguna = $_SESSION['pengguna'];
$id_buku = $_POST['id_buku'] ?? '';
$durasi = (int) ($_POST['durasi'] ?? 0); // dalam hari

// Validasi input
if (empty($id_buku) || $durasi <= 0) {
    echo "Data tidak valid.";
    exit();
}

// Cek apakah buku tersedia
$cek_status = mysqli_query($conn, "SELECT status_buku FROM data_buku WHERE id_buku = '$id_buku'");
if (!$cek_status || mysqli_num_rows($cek_status) == 0) {
    echo "Buku tidak ditemukan.";
    exit();
}

$status_buku = mysqli_fetch_assoc($cek_status)['status_buku'];
if ($status_buku !== 'tersedia') {
    echo "Buku sedang tidak tersedia untuk dipinjam.";
    exit();
}

// Hitung waktu mulai dan selesai dengan DateTime
$tgl_pinjam = new DateTime();
$tgl_kembali = clone $tgl_pinjam;
$tgl_kembali->modify("+$durasi days");

// Format waktu ke string
$tgl_pinjam_str = $tgl_pinjam->format("Y-m-d H:i:s");
$tgl_kembali_str = $tgl_kembali->format("Y-m-d H:i:s");

// Simpan ke tabel peminjaman
$query = "INSERT INTO peminjaman (id_pengguna, id_buku, tgl_pinjam, tgl_kembali, status_peminjaman)
          VALUES ('$id_pengguna', '$id_buku', '$tgl_pinjam_str', '$tgl_kembali_str', 'aktif')";

$insert = mysqli_query($conn, $query);

if ($insert) {
    // Update status buku
    mysqli_query($conn, "UPDATE data_buku SET status_buku = 'dipinjam' WHERE id_buku = '$id_buku'");
    
    // Redirect ke halaman baca pinjam
    header("Location: baca_pinjam.php");
    exit();
} else {
    echo "Gagal menyimpan data peminjaman.";
}
?>
