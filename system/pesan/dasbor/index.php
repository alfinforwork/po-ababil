<?php
session_start();
error_reporting(0);
include_once '../../connect.php';
include_once '../dasbor/setting/status_session.php';
$id_pelanggan = $_SESSION['id_pelanggan'];
$nama_member = mysqli_query($koneksi, "SELECT nama_lengkap FROM member WHERE id_member='$id_member'");
$data=mysqli_fetch_array($nama_member);

?>
<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<div class="col-lg-12 mb-12">
					<div class="card">
						<div class="card-header">
							<h6 class="text-uppercase mb-0">Bantuan</h6>
						</div>
						<div class="card-body">
							<p>Jika Anda memerlukan bantuan, silahkan hubungi kami :</p> 
							<p>Telp  : +62 856 4749 5224</p>
							<p>Email : ababil.trans@gmail.com </p>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<!DOCTYPE html>
<html>
<head>
	<title>Halaman Member : [<?php echo $data['nama_lengkap'];?>]</title>
</head>
<body>
<h1>Selamat Datang [<?php echo $data['nama_lengkap'];?>] di halaman Member</h1>

<?php 
	$pesan_baru=mysqli_query("SELECT * FROM chat WHERE id_admin='$id' and sudah_dibaca='belum'");
	$jumlah_pesan_baru=mysqli_num_rows($pesan_baru);

	if($jumlah_pesan_baru == 0){
		echo "<h3><a href='../system/pesan/dasbor/pesan.php?id_admin=".$id."'>Tidak Ada Pesan Baru (0)</a></h3>";
	}
	else if($jumlah_pesan_baru > 0){
		echo "<h3><a href='../../pesan.php?id_admin=".$id."' style='color:red;'>Pesan Baru (".$jumlah_pesan_baru.")</a></h3>";
	}
?>

<p>Ini adalah contoh halaman member</p>
<p><a href="lain.php">Halaman lain</a></p>
<p>Teks ini hanya bisa dibaca oleh member</p>
<p><a href="logout.php"><strong>LOGOUT</strong></p>
</body>
</html>