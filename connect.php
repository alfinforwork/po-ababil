<?php
// Change this to your connection info.
$DATABASE_HOST = '103.145.226.94';
$DATABASE_USER = 'poababil_root';
$DATABASE_PASS = 'poababil';
$DATABASE_NAME = 'poababil_travel';
//Coba dan hubungkan menggunakan info di atas.
$con = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
$koneksi = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	// Jika ada kesalahan dengan koneksi, hentikan skrip dan tampilkan kesalahan.
	die('Failed to connect to MySQL: ' . mysqli_connect_error());
}
