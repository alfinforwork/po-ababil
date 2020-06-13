<?php
// Change this to your connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'db_ababil';
//Coba dan hubungkan menggunakan info di atas.
$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$koneksi = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Jika ada kesalahan dengan koneksi, hentikan skrip dan tampilkan kesalahan.
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
