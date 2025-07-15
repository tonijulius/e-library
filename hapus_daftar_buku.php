<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}
if (isset($_GET['id'])) {
    $id_buku = $_GET['id'];

    // Ambil data buku dulu untuk ambil link file
    $query = "SELECT link_file FROM data_buku WHERE id_buku = '$id_buku'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Hapus file PDF dari server
    if ($row && file_exists($row['link_file'])) {
        unlink($row['link_file']);
    }

    // Hapus data dari database
    $query_delete = "DELETE FROM data_buku WHERE id_buku = '$id_buku'";
    if (mysqli_query($conn, $query_delete)) {
        echo "<script>alert('Data buku berhasil dihapus'); window.location.href='daftar_buku.php';</script>";
    } else {
        echo "Gagal menghapus data: " . mysqli_error($conn);
    }

} else {
    echo "ID buku tidak ditemukan.";
}
?>
