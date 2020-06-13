<?php

require_once('header.php');
// require_once('../connect.php');

$id = $_GET['id'];

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

	// Update data
	if ($stmt = $con->prepare('UPDATE rekening SET nama=?, norek=?, bank=? WHERE id_rekening=?')) {
		$stmt->bind_param('sssi', $nama, $norek, $bank, $id);
		$stmt->execute();
		$message = "Anda berhasil mengubah data rekening!";
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
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal mengubah data rekening!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Gagal!",
							text: "'.$message.'",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "rekening.php";
						});
					</script>';
		return false;
	}        
	
	$stmt->close();	
	$con->close();
}


$stmt = $con->prepare('SELECT * FROM rekening WHERE id_rekening = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nama, $norek, $bank);
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
							<h3 class="h6 text-uppercase mb-0">Detail Rekening</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nama</label>
									<div class="col-md-3">
										<input type="text" name="nama" class="form-control" value="<?=$nama;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nomor Rekening</label>
									<div class="col-md-6">
										<input type="text" name="norek" class="form-control" value="<?=$norek;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Bank</label>
									<div class="col-md-6">
										<input type="text" name="bank" class="form-control" value="<?=$bank;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<?php
										if ($_SESSION['level'] == 'admin'){
											echo '<button type="submit" name="addRekening" class="btn btn-primary">Save</button>';
										}
										?>										
										<a href="rekening.php" class="btn btn-secondary">Back</a>
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