<?php

require_once('header.php');
// require_once('../connect.php');

$id = $_GET['id'];

if (isset($_POST['addjadwal'])){
	$jam		= $_POST['jam'];
	$ket		= $_POST['ket'];

	// Mengecek apakah ada masukkan jam dan keterangan
	if (!isset($jam, $ket)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi jam dan keterangan!');
	}
	// Memastikan tidak ada jam atau input yang kosong.
	if (empty($jam) || empty($ket)) {
		// jam dan keterangan masih kosong.
		die ('jam dan keterangan masih kosong');
	}

	// Update data
	if ($stmt = $con->prepare('UPDATE jadwal SET jam=?, ket_jadwal=? WHERE id_jadwal=?')) {
		$stmt->bind_param('ssi', $jam, $ket, $id);
		$stmt->execute();
		$message = "Anda berhasil mengubah data jadwal!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "'.$message.'",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "jadwal.php";
						});
					</script>';
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal edit data!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Gagal!",
							text: "'.$message.'",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "jadwal.php";
						});
					</script>';
		return false;
	}        
	
	$stmt->close();	
	$con->close();
}


$stmt = $con->prepare('SELECT * FROM jadwal WHERE id_jadwal = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $jam, $ket_jadwal);
$stmt->fetch();
?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<!-- Form Elements -->
				<div class="col-lg-12 mb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="h6 text-uppercase mb-0">Detail Jadwal</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Jam</label>
									<div class="col-md-3">
										<input type="text" name="jam" class="form-control" value="<?=$jam;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">keterangan</label>
									<div class="col-md-6">
										<input type="text" name="ket" class="form-control" value="<?=$ket_jadwal;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<?php
										if ($_SESSION['level'] == 'admin'){
											echo '<button type="submit" name="addjadwal" class="btn btn-primary">Save</button>';
										}
										?>
										<a href="jadwal.php" class="btn btn-secondary">Back</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

<?php
	include_once('footer.php');
?>