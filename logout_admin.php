<?php
session_start();
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Mengakhiri sesi

header("Location: login_admin.php"); // Kembali ke halaman login
exit();
?>