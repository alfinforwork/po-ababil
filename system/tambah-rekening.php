<?php

require_once('header.php');
// require_once('../connect.php');

if (isset($_POST['addRekening'])){
	$nama		= $_POST['nama'];
	$norek	= $_POST['norek'];
	$bank		= $_POST['bank'];

	// Mengecek apakah ada masukkan nama dan nomer rekening
	if (!isset($nama, $norek)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi nama dan nomer rekening!');
	}
	// Memastikan tidak ada nama atau input yang kosong.
	if (empty($nama) || empty($norek)) {
		// Nama atau nomer rekening masih kosong.
		die ('Nama atau nomer rekening masih kosong');
	}

	// Mengecek apakah nomer rekening ada yang sama.
	if ($stmt = $con->prepare('SELECT id_rekening, norek FROM rekening WHERE norek = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $norek);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the nama exists in the database.
		if ($stmt->num_rows > 0) {
			// Nomer rekening sudah ada
			$message = "Nomer rekening sudah ada, silahkan input nomer lain!";
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
			// Nomer rekening belum ada, masukkan nomer ke database
			if ($stmt = $con->prepare('INSERT INTO rekening (nama, norek, bank) VALUES (?, ?, ?)')) {
				$stmt->bind_param('sss', $nama, $norek, $bank);
				$stmt->execute();
				$message = "Anda berhasil menambahkan rekening baru!";
				echo '<script type="text/javascript">							
							Swal.fire({
								title: "Sukses!",
								text: "'.$message.'",
								type: "success",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href = "rekening.php";
							});
						</script>';
			} else {
				// Something is wrong with the sql statement.
				$message = "Gagal menambahkan rekening baru!";
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
		$message = "Gagal menambahkan rekening baru!";
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
							<h3 class="h6 text-uppercase mb-0">Tambah Rekening</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nama</label>
									<div class="col-md-3">
										<input type="text" name="nama" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nomor Rekening</label>
									<div class="col-md-6">
										<input type="text" name="norek" class="form-control" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Bank</label>
									<div class="col-md-6">
										<input type="text" name="bank" class="form-control">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" name="addRekening" class="btn btn-primary">Save</button>
										<a href="rekening.php" class="btn btn-secondary">Cancel</a>
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