<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil nama file gambar yang akan dihapus
    $sql_select = "SELECT gambar FROM katalog_buku WHERE id = '$id'";
    $result_select = mysqli_query($conn, $sql_select);
    $data = mysqli_fetch_assoc($result_select);

    if ($data) {
        $gambar = $data['gambar'];

        // Hapus data dari database
        $sql_delete = "DELETE FROM katalog_buku WHERE id = '$id'";
        $result_delete = mysqli_query($conn, $sql_delete);

        if ($result_delete) {
            
            header("Location: atur_katalog.php");
            exit();
        } else {
            echo "Gagal menghapus data dari database.";
        }
    } else {
        echo "Data katalog tidak ditemukan.";
    }
} else {
    echo "ID katalog tidak valid.";
}
?>
