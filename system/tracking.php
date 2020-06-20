<?php
require_once('header.php');
// require_once('../connect.php'); 
if ($_SESSION['level'] != 'sopir') {
	echo '<script>			
				window.location.href = "index.php";
			</script>';
}

$id_sopir		= $_SESSION['id'];

if (isset($_POST['simpan'])) {
	$id_mobil		= $_POST['id_mobil'];
	$mob 				= 0;

	$stmt = $con->prepare('UPDATE lokasi SET id_mobil=? WHERE id_mobil=?');
	$stmt->bind_param('ii', $mob, $id_mobil);
	$stmt->execute();

	if ($stmt = $con->prepare('UPDATE lokasi SET id_mobil=? WHERE id_sopir=?')) {
		$stmt->bind_param('ii', $id_mobil, $id_sopir);
		$stmt->execute();
		$message = "Berhasil menyimpan data!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "' . $message . '",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "tracking.php";
						});
					</script>';
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal menyimpan data!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Error!",
							text: "' . $message . '",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
		return false;
	}
	$stmt->close();
}
?>

<?php
$root  = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
?>

<script>
	function simpanPosisi(posisi) {
		const latitude = posisi.coords.latitude;
		const longitude = posisi.coords.longitude;
		var id = '<?php echo $id_sopir; ?>';

		let data = {
			'latitude': latitude,
			'longitude': longitude,
			'id': id
		};

		$.ajax({
			type: 'POST',
			url: '<?= $root ?>lokasi.php',
			data: data,
			success: function(response) {
				console.log(response);
				// alert('Lokasi berhasil disimpan');
			},
			error(xhr, status, eror) {
				console.log(eror);
			}
		});
	}
	$(document).ready(function() {
		setInterval(() => {
			console.log('update');
			navigator.geolocation.getCurrentPosition(simpanPosisi);
		}, 500);
	});
</script>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<div class="col-lg-12 mb-12">
					<div class="card">
						<div class="card-header">
							<h6 class="text-uppercase mb-0">Tracking</h6>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nomor Mobil</label>
									<div class="col-md-3">
										<select name="id_mobil" class="form-control">
											<?php
											$stmt = $con->prepare('SELECT * FROM mobil');
											$stmt->execute();
											$stmt->store_result();
											$stmt->bind_result($id_mobil, $nopol, $merk, $ket_mobil);

											while ($stmt->fetch()) {
												echo '<option value="' . $id_mobil . '" >' . $nopol . '</option>';
											}
											?>
										</select>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" name="simpan" class="btn btn-primary">Save</button>
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
	require_once('footer.php');
	?>