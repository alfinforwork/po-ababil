<?php

require_once('header.php');
// require_once('../connect.php');

if (isset($_POST['addJadwal'])){
	$jam			= $_POST['jam'];
	$ket_jadwal	= $_POST['ket_jadwal'];

	// Mengecek apakah Jadwal ada yang sama.
	if ($stmt = $con->prepare('SELECT id_jadwal, jam FROM jadwal WHERE jam = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $jam);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the nama exists in the database.
		if ($stmt->num_rows > 0) {
			// Jadwal sudah ada
			$message = "Jadwal sudah ada, silahkan input jadwal lain!";
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
			// Jadwal belum ada, masukkan nomer ke database
			if ($stmt = $con->prepare('INSERT INTO jadwal (jam, ket_jadwal) VALUES (?, ?)')) {
				$stmt->bind_param('ss', $jam, $ket_jadwal);
				$stmt->execute();
				$message = "Anda berhasil menambahkan jadwal baru!";
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
			} else {
				// Something is wrong with the sql statement.
				$message = "Gagal menambahkan jadwal baru!";
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
		$message = "Gagal menambahkan jadwal baru!";
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
							<h3 class="h6 text-uppercase mb-0">Tambah Jadwal</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Jam</label>
									<div class="col-md-3">
										<input type="text" name="jam" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Keterangan</label>
									<div class="col-md-6">
										<input type="text" name="ket_jadwal" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" name="addJadwal" class="btn btn-primary">Save</button>
										<a href="jadwal.php" class="btn btn-secondary">Cancel</a>
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