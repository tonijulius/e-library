<?php
include 'koneksi.php';
date_default_timezone_set('Asia/Jakarta');

// Ambil semua peminjaman yang sudah melewati waktu kembali dan masih aktif
$query = "SELECT * FROM peminjaman 
          WHERE status_peminjaman = 'aktif' 
          AND tgl_kembali < NOW()";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id_buku = $row['id_buku'];
        $id_peminjaman = $row['id_peminjaman'];
        $waktu_kembali = date("Y-m-d H:i:s");

        // Update status peminjaman
        $update = "UPDATE peminjaman 
                   SET status_peminjaman = 'selesai', 
                       tgl_pengembalian = '$waktu_kembali' 
                   WHERE id_peminjaman = '$id_peminjaman'";

        mysqli_query($conn, $update);

        // Ubah status buku jadi tersedia
        $update_buku = "UPDATE data_buku 
                        SET status_buku = 'tersedia' 
                        WHERE id_buku = '$id_buku'";

        mysqli_query($conn, $update_buku);
		
		header("Location: katalog_buku.php");
        exit();
    }
    //echo "Peminjaman kadaluwarsa berhasil diakhiri.";
} else {
   // echo "Tidak ada peminjaman yang perlu diakhiri.";
}
?>
