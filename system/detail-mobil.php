<?php
require_once('header.php');
// require_once('../connect.php');

$id = $_GET['id'];

if (isset($_POST['updateMobil'])) {
	$nopol		= $_POST['nopol'];
	$merk			= $_POST['merk'];
	$ket_mobil	= $_POST['ket_mobil'];

	// Mengecek apakah ada masukkan nopol dan merk
	if (!isset($nopol, $merk)) {
		// Menampilkan pesan tidak boleh kosong.
		die('Silahkan isi nopol dan merk!');
	}
	// Memastikan tidak ada nopol atau input yang kosong.
	if (empty($nopol) || empty($merk)) {
		// Nopol atau merk masih kosong.
		die('Nopol atau merk masih kosong');
	}

	if ($stmt = $con->prepare('UPDATE mobil SET nopol=?, merk=?, ket_mobil=? WHERE id_mobil=?')) {
		$stmt->bind_param('sssi', $nopol, $merk, $ket_mobil, $id);
		$stmt->execute();
		$message = "Anda berhasil mengubah data mobil!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "' . $message . '",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "mobil.php";
						});
					</script>';
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal edit data!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Gagal!",
							text: "' . $message . '",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "mobil.php";
						});
					</script>';
		return false;
	}
	$stmt->close();
	$con->close();
}

$stmt = $con->prepare('SELECT * FROM mobil WHERE id_mobil = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nopol, $merk, $ket_mobil);
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
							<h3 class="h6 text-uppercase mb-0">Detail Mobil</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nomor Polisi</label>
									<div class="col-md-3">
										<input type="text" name="nopol" class="form-control" value="<?= $nopol; ?>" required <?= ($_SESSION['level'] == 'admin') ? '' : 'readonly' ?>>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Merk / Type</label>
									<div class="col-md-6">
										<input type="text" name="merk" class="form-control" value="<?= $merk; ?>" required <?= ($_SESSION['level'] == 'admin') ? '' : 'readonly' ?>>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Keterangan</label>
									<div class="col-md-6">
										<input type="text" name="ket_mobil" class="form-control" value="<?= $ket_mobil; ?>" <?= ($_SESSION['level'] == 'admin') ? '' : 'readonly' ?>>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<?php
										if ($_SESSION['level'] == 'admin') {
											echo '<button type="submit" name="updateMobil" class="btn btn-primary">Edit</button>';
										}
										?>
										<a href="mobil.php" class="btn btn-secondary">Back</a>
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