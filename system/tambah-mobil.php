<?php

require_once('header.php');
// require_once('../connect.php');


if (isset($_POST['addMobil'])){
	$nopol		= $_POST['nopol'];
	$merk			= $_POST['merk'];
	$ket_mobil	= $_POST['ket_mobil'];

	// Mengecek apakah ada masukkan nopol dan merk
	if (!isset($nopol, $merk)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi nopol dan merk!');
	}
	// Memastikan tidak ada nopol atau input yang kosong.
	if (empty($nopol) || empty($merk)) {
		// Nopol atau merk masih kosong.
		die ('Nopol atau merk masih kosong');
	}

	// Mengecek apakah nopol ada yang sama.
	if ($stmt = $con->prepare('SELECT id_mobil, nopol FROM mobil WHERE nopol = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $nopol);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the nopol exists in the database.
		if ($stmt->num_rows > 0) {
			// Nopol sudah ada
			$message = "Nopol sudah ada, silahkan input nopol lain!";
			echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "'.$message.'",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
		} else {
			// Nopol belum ada, masukkan nopol ke database
			if ($stmt = $con->prepare('INSERT INTO mobil (nopol, merk, ket_mobil) VALUES (?, ?, ?)')) {
				$stmt->bind_param('sss', $nopol, $merk, $ket_mobil);
				$stmt->execute();
				$message = "Anda berhasil menambahkan mobil baru!";
				echo '<script type="text/javascript">							
							Swal.fire({
								title: "Sukses!",
								text: "'.$message.'",
								type: "success",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href = "mobil.php";
							});
						</script>';
			} else {
				// Something is wrong with the sql statement.
				$message = "Gagal menambahkan mobil baru!";
				echo '<script type="text/javascript">							
							Swal.fire({
								title: "Error!",
								text: "'.$message.'",
								type: "error",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.history.back();
							});
						</script>';
			}        
		}
		$stmt->close();
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal menambahkan mobil!";
		echo '<script type="text/javascript">							
					Swal.fire({
						title: "Error!",
						text: "'.$message.'",
						type: "error",
						timer: 2000,
						showConfirmButton: false
					}).then(function(result) { 
						window.history.back();
					});
				</script>';
	}
	$con->close();
}
?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<!-- Form Elements -->
				<div class="col-lg-12 mb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="h6 text-uppercase mb-0">Tambah Mobil</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nomor Polisi</label>
									<div class="col-md-3">
										<input type="text" name="nopol" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Merk / Type</label>
									<div class="col-md-6">
										<input type="text" name="merk" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Keterangan</label>
									<div class="col-md-6">
										<input type="text" name="ket_mobil" class="form-control">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" name="addMobil" class="btn btn-primary">Save</button>
										<a href="mobil.php" class="btn btn-secondary">Cancel</a>
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