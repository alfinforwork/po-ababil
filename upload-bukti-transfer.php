	<?php
	session_start();
	include_once('header.php');

	function rupiah($angka)
	{

		$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
		return $hasil_rupiah;
	}

	// If the user is logged in redirect to the dashboard page...
	if (!isset($_SESSION['loggedin'])) {
		header('Location: login.php');
		exit();
	}

	if (isset($_POST['upload'])) {
		// get details of the uploaded file
		$fileTmpPath = $_FILES['upload']['tmp_name'];
		$fileName = $_FILES['upload']['name'];
		$fileSize = $_FILES['upload']['size'];
		$fileType = $_FILES['upload']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));

		$newFileName = md5(time() . $fileName) . '.' . $fileExtension;
		// directory in which the uploaded file will be moved
		$uploadFileDir = 'bukti_transfer/';
		$dest_path = $uploadFileDir . $newFileName;

		if (move_uploaded_file($fileTmpPath, $dest_path)) {
			$id = $_GET['id'];
			if ($stmt = $con->prepare('UPDATE pemesanan SET bukti_transfer=?,status="sudah dibayar" WHERE kd_pemesanan=?')) {
				$stmt->bind_param('si', $dest_path, $id);
				$stmt->execute();
				$message = "Berhasil upload bukti transfer!";
				echo '<script type="text/javascript">							
									Swal.fire({
										title: "Sukses!",
										text: "' . $message . '",
										type: "success",
										timer: 2000,
										showConfirmButton: false
									}).then(function(result) { 
										window.location.href = "system/tiket.php";
									});
								</script>';
				return false;
			}
		} else {
			$message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
		}
	}
	?>

	<!-- contact -->
	<section class="ab-info-main py-5" id="contact">
		<div class="container py-xl-5 py-lg-3">
			<!-- <div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Buy <span>Ticket</span></h3>
				<p class="titile-para-text mx-auto">
					Silahkan isi form dibawah ini.
				</p>
			</div> -->
			<div class="row contact-agileinfo pt-lg-4">
				<!-- contact form -->
				<div class="col-lg-7 contact-right mt-lg-0 mt-5">
					<?php
					if (!empty($_SESSION['email'])) {
						$stmt = $con->prepare('SELECT * FROM rekening LIMIT 1');
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($id, $nama, $norek, $bank);
						$stmt->fetch();
					}
					if (!empty($_GET['id'])) {
						$stmt = $con->prepare('SELECT (jml_tiket*biaya) as biaya, tgl_berangkat, kd_pemesanan, dibuat_tanggal FROM pemesanan
								JOIN biaya on pemesanan.id_biaya = biaya.id_biaya
								WHERE kd_pemesanan = ?
								LIMIT 1');
						$stmt->bind_param('i', $_GET['id']);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($biaya, $tgl_berangkat, $kd_pemesanan, $dibuat_tanggal);
						$stmt->fetch();
					}

					?>

					<h3 class="footer-title mb-4 pb-lg-2">Pesanan Anda berhasil dibuat</h3>

					<!-- <p> Maksimal Transfer 1 jam, admin akan menghapusnya :</p> <div id='jam' ></div> -->
					<div id='form'>
						<h3> HASIL TIMER</h3>
						<div style='background: #D20000;height: 100px;width: 100%; color: white;justify-content: center;display:flex;align-items: center'>
							<div id="waktumundur" class="text-center"></div>
							<?php $root  = "http://" . $_SERVER['HTTP_HOST'];
							$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']); ?>

							<script>
								var intervalnew = setInterval(function() {
									var tanggal = new Date("<?= $dibuat_tanggal  ?>");
									tanggal.setHours(tanggal.getHours() + 1)
									var tgl_berangkat = tanggal.getTime();
									var now = new Date().getTime();
									var waktumundur = tgl_berangkat - now;
									console.log('tgl berangkat ' + new Date("<?= $tgl_berangkat  ?>"));
									if (waktumundur <= 0) {
										console.log('expired');
										document.getElementById('waktumundur').innerHTML = "EXPIRED";
										document.getElementById('transfer').style.display = "none";
										alert("Waktu bayar telah EXPIRED");
										clearInterval(intervalnew);
										$.post('<?= $root ?>upload-bukti-transfer-action.php', {
											id_pemesanan: <?= $kd_pemesanan ?>
										}, function(data) {
											window.location.replace('<?= $root . 'system/tiket.php' ?>');
										});
									} else {
										console.log(waktumundur);
										document.getElementById('waktumundur').innerHTML = konversi(waktumundur);
										document.getElementById('transfer').style.display = "block";
									}
								}, 500);

								function konversi(input) {

									// Time calculations for days, hours, minutes and seconds
									var hari = Math.floor(input / (1000 * 60 * 60 * 24));
									var jam = Math.floor((input % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
									var menit = Math.floor((input % (1000 * 60 * 60)) / (1000 * 60));
									var detik = Math.floor((input % (1000 * 60)) / 1000);

									// Output the result in an element with id="demo"

									// return Math.floor(hari) + ' Hari ' + Math.floor(jam) + ' Jam ' + Math.floor(menit) + ' Menit ' + Math.floor(detik) + ' Detik ';
									return Math.floor(jam) + ' Jam ' + Math.floor(menit) + ' Menit ' + Math.floor(detik) + ' Detik ';
								}
							</script>
						</div>
					</div>
					<p>Silahkan transfer uang ke :</p><br>
					<form method="post" enctype="multipart/form-data">
						<div class="row">
							<div class="col-lg-4 form-group pr-lg-2">
								<img src="images/rek.png" width="94">
							</div>
							<div class="col-lg-3 form-group pl-lg-2">
								<p>Bank </p>
								<p>Nama </p>
								<p>No Rekening </p>
								<p>Biaya </p>

							</div>
							<div class="col-lg-5 form-group pl-lg-2">
								<p>: <?= $bank ?></p>
								<p>: <?= $nama ?></p>
								<p>: <?= $norek ?></p>

								<?php
								//$jml = $jml_tiket * 150000;
								echo '<p>: ' . rupiah($biaya) . '</p>';
								?>

							</div>
						</div>
						<br>
						<div id="transfer">
							<div class="row">
								<div class="col-lg-4 form-group pr-lg-2">
									<p>Upload bukti transfer</p>
								</div>
								<div class="col-lg-3 form-group pl-lg-2">
									<input type="file" name="upload" accept="image/png, image/jpeg">
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4 form-group pr-lg-2">

								</div>
								<div class="col-lg-8 form-group pl-lg-2">
									<button type="submit" name="upload" class="btn submit-contact-main">Upload</button>
								</div>
							</div>
						</div>

					</form>
				</div>
				<!-- contact form -->
			</div>
		</div>
	</section>
	<!-- contact -->

	<?php
	include_once('footer.php');
	?>