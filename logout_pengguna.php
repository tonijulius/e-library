<?php
session_start();
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Mengakhiri sesi

header("Location: login_pengguna.php"); // Kembali ke halaman login
exit();
?>
