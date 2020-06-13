<?php

require_once('header.php');
// require_once('../connect.php');

$id = $_GET['id'];

if (isset($_POST['editTiket'])) {
	$alamatpenjemputan = $_POST['alamatpenjemputan'];
	$alamattujuan = $_POST['alamattujuan'];
	$stmt = $con->prepare('UPDATE pemesanan SET alamat_lengkap_dari=?,alamat_lengkap_ke=? WHERE kd_pemesanan=?');
	$stmt->bind_param('ssi', $alamatpenjemputan, $alamattujuan, $id);



	// Update data
	if ($stmt) {
		$stmt->execute();
		$message = "Anda berhasil mengubah data tiket!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "' . $message . '",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "tiket.php";
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
							window.location.href = "tiket.php";
						});
					</script>';
		return false;
	}

	$stmt->close();
	$con->close();
}


$stmt = $con->prepare(
	'SELECT 
		`tgl_berangkat`,
		`jml_tiket`,
		`no_kursi`,
		`bukti_transfer`,
		`alamatdari`,
		`alamatke`,
		`waktu`,
		`status` ,
		`alamat_lengkap_dari`,
		`alamat_lengkap_ke`
	FROM (SELECT @nomor:=1) as nomor, pemesanan 
	INNER JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan 
	INNER JOIN (
		SELECT 
			id_biaya,
			biaya.biaya,
			alamatdari.nama_lokasi AS alamatdari,
			alamatke.nama_lokasi AS alamatke
		FROM biaya
		JOIN alamat AS alamatdari ON biaya.id_lokasi_dari = alamatdari.id_alamat
		JOIN alamat AS alamatke ON biaya.id_lokasi_ke = alamatke.id_alamat
		) as biayas ON pemesanan.id_biaya = biayas.id_biaya 
	WHERE pemesanan.kd_pemesanan = ? LIMIT 1'
);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($tgl_berangkat, $jml_tiket, $no_kursi, $bukti_transfer, $tmp_jemput, $tmp_tujuan, $waktu, $status, $alamat_spesifik_dari, $alamat_spesifik_ke);
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
							<h3 class="h6 text-uppercase mb-0">Detail Tiket</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Tanggal Berangkat</label>
									<div class="col-md-3">
										<input type="date" name="tgl_berangkat" class="form-control" value="<?= $tgl_berangkat; ?>" required readonly="">
									</div>
								</div>
								<div class="line"></div>
								<div class="row">
									<div class="col-lg-4 form-group pr-lg-2">
										<p class="buy">No Kursi</p>
									</div>
									<div class="col-lg-3 form-group pr-lg-2">

										<style type="text/css">
											.kursiaktif {
												background-color: green;
											}

											.kursitakaktif {
												background-color: red;
											}

											.kursiselect {
												background-color: blue !important;
											}

											.kursilist {
												flex: 1;
												padding: 10px;
												color: white;
												margin: 0.5px;
											}
										</style>

										<input type="hidden" class="form-control" name="jml_tiket" id="jml_tiket" required="">
										<input type="hidden" class="form-control" name="no_kursi" id="no_kursi" required="">

										<div class="border">
											<div style="display: flex;flex-direction: row;">
												<div id="kursi1" class="kursiaktif kursilist" onclick="klikkursi(1)">1</div>
												<div id="kursi2" class="kursiaktif kursilist" onclick="klikkursi(2)">2</div>
												<div class="kursilist" style="color: black !important">S</div>
											</div>
											<div style="display: flex;flex-direction: row;">
												<div id="kursi3" class="kursiaktif kursilist" onclick="klikkursi(3)">3</div>
												<div id="kursi4" class="kursiaktif kursilist" onclick="klikkursi(4)">4</div>
												<div id="kursi5" class="kursiaktif kursilist" onclick="klikkursi(5)">5</div>
											</div>
											<div style="display: flex;flex-direction: row;">
												<div id="kursi6" class="kursiaktif kursilist" onclick="klikkursi(6)">6</div>
												<div id="kursi7" class="kursiaktif kursilist" onclick="klikkursi(7)">7</div>
												<div id="kursi8" class="kursiaktif kursilist" onclick="klikkursi(8)">8</div>
											</div>
										</div>

										<script type="text/javascript">
											<?php foreach (explode(',', $no_kursi) as $k) {
												for ($i = 1; $i <= 8; $i++) {
													if ($k == $i) {
											?>
														$('#kursi' + <?= $i ?>).addClass("kursiselect");
											<?php
													}
												}
											} ?>

											// function klikkursi(prop) {
											// 	$('#kursi'+prop).click(function () {
											// 		$(this).toggleClass("kursiselect");
											// 	});
											// }
											setInterval(function() {
												var jmltiket = 0,
													tiket = '';
												for (var i = 1; i <= 8; i++) {
													if ($('#kursi' + i).hasClass("kursiselect")) {
														jmltiket++;
														tiket += i + ',';
													}
												}
												$('#jml_tiket').val(jmltiket);
												$('#no_kursi').val(tiket);
												console.log(tiket);
											}, 500);
										</script>

									</div>
								</div>

								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Waktu Berangkat</label>
									<div class="col-md-3">
										<input type="hidden" name="waktu" value="<?= $waktu ?>">
										<select name="waktu1" class="form-control" disabled="">
											<option value="pagi" <?php
																	if ($waktu == 'pagi') {
																		echo 'selected';
																	}
																	echo '>Pagi</option>
											<option value="sore"';
																	if ($waktu == 'sore') {
																		echo 'selected';
																	}
																	echo '>Sore</option>';
																	?> </select> </div> </div> <div class="line">
									</div>

									<div class="form-group row">
										<label class="col-md-3 form-control-label">Tempat Penjemputan</label>
										<div class="col-md-8">
											<input type="text" max="8" name="tmp_jemput" class="form-control" value="<?= $tmp_jemput; ?>" readonly required>
										</div>
									</div>
									<div class="line"></div>
									<div class="form-group row">
										<label class="col-md-3 form-control-label">Alamat Spesifik Penjemputan</label>
										<div class="col-md-8">
											<input type="text" max="8" name="alamatpenjemputan" class="form-control" value="<?= $alamat_spesifik_dari ?>" readonly required>
										</div>
									</div>
									<div class="line"></div>
									<div class="form-group row">
										<label class="col-md-3 form-control-label">Tujuan</label>
										<div class="col-md-8">
											<input type="text" max="8" name="tmp_tujuan" class="form-control" value="<?= $tmp_tujuan; ?>" readonly required>
										</div>
									</div>
									<div class="line"></div>
									<div class="form-group row">
										<label class="col-md-3 form-control-label">Alamat Spesifik Tujuan</label>
										<div class="col-md-8">
											<input type="text" max="8" name="alamattujuan" class="form-control" value="<?= $alamat_spesifik_ke ?>" readonly required>
										</div>
									</div>
									<div class="line"></div>
									<?php
									if ($_SESSION['level'] == 'admin') {
										echo '<div class="form-group row">
											<label class="col-md-3 form-control-label">Status</label>
											<div class="col-md-8">
											<select name="status" class="form-control">
												<option value="belum dibayar"';
										if ($status == 'belum dibayar') {
											echo 'selected';
										}
										echo '>Belum dibayar</option>
													<option value="sudah dibayar"';
										if ($status == 'sudah dibayar') {
											echo 'selected';
										}
										echo '>Sudah dibayar</option>
													<option value="selesai"';
										if ($status == 'selesai') {
											echo 'selected';
										}
										echo '>Selesai</option>
												</select>
											</div>
										</div>
										<div class="line"></div>';
									}
									?>
									<div class="form-group row">
										<div class="col-md-9 ml-auto">
											<?php

											if ($_SESSION['level'] == 'pelanggan') {
												if ($status == 'belum dibayar') {
													echo '
													<!--<button type="submit" name="editTiket" class="btn btn-primary">Save</button>-->
												<a href="tiket.php" class="btn btn-secondary">Back</a>
												<a href="../upload-bukti-transfer.php?id=' . $id . '" class="btn btn-success">Upload bukti transfer</a>';
												} else {
													echo '<a href="tiket.php" class="btn btn-secondary">Back</a>';
												}
											}
											if ($_SESSION['level'] == 'sopir') {
												echo '<a href="tiket.php" class="btn btn-secondary">Back</a>';
											}
											if ($_SESSION['level'] == 'admin') {
												echo '
											<!--<button type="submit" name="editTiket" class="btn btn-primary">Save</button>-->
											<a href="tiket.php" class="btn btn-secondary">Back</a>';
												if (empty($bukti_transfer)) {
													echo " Belum upload bukti transfer";
												} else {
													echo '
												<a href="../' . $bukti_transfer . '" target="_blank" class="btn btn-danger">Cek bukti transfer</a>';
												}
											}
											//<a href="../upload-bukti-transfer.php?id='.$id.'" class="btn btn-success">Upload bukti transfer</a>
											?>

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