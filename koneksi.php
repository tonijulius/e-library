<?php
	$host = 'localhost';
	$user = 'root';
	$pass = '';
	$db = 'db_elibrary';
	
	$conn = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>