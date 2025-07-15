<?php
session_start();
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['pengguna'])) {
    header("Location: login_pengguna.php");
    exit();
}

// Ambil data dari form
$id_pengguna = $_SESSION['pengguna'];
$id_buku = $_POST['id_buku'] ?? '';
$durasi = isset($_POST['durasi']) ? (int) $_POST['durasi'] : 0;

// Cek apakah buku tersedia
$cek_status = mysqli_query($conn, "SELECT status_buku FROM data_buku WHERE id_buku = '$id_buku'");
if (!$cek_status || mysqli_num_rows($cek_status) == 0) {
    echo "Buku tidak ditemukan.";
    exit();
}

$status_buku = mysqli_fetch_assoc($cek_status)['status_buku'];
if ($status_buku !== 'tersedia') {
    echo "Buku sedang tidak tersedia untuk dibaca.";
    exit();
}

if ($durasi <= 0 || $durasi > 120) {
    echo "Durasi tidak valid (maksimal 120 menit).";
    exit();
}

$waktu_mulai = date('Y-m-d H:i:s');
$waktu_selesai = date('Y-m-d H:i:s', strtotime("+$durasi minutes", strtotime($waktu_mulai)));


    // Simpan sesi baca ke database
    $query_sesi = mysqli_query($conn, "INSERT INTO sesi_baca (id_pengguna, id_buku, waktu_mulai, waktu_selesai, status)
        VALUES ('$id_pengguna', '$id_buku', '$waktu_mulai', '$waktu_selesai', 'aktif')");

    if ($query_sesi) {
        // Update status buku
        mysqli_query($conn, "UPDATE data_buku SET status_buku = 'sedang_dibaca' WHERE id_buku = '$id_buku'");

        // Redirect ke halaman baca buku
        header("Location: baca_online.php?id_buku=$id_buku");
        exit();
    } else {
        echo "Gagal menyimpan sesi baca: " . mysqli_error($conn);
    }
?>
