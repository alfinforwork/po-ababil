	<?php
	session_start();
	include_once('header.php');
	require_once('./vendor/autoload.php');

	function rupiah($angka)
	{

		$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
		return $hasil_rupiah;
	}







	$kd_pembayaran = $_GET['id'];

	$query = $con->query("SELECT * FROM pemesanan JOIN biaya ON pemesanan.id_biaya = biaya.id_biaya WHERE kd_pemesanan='$kd_pembayaran' ")->fetch_object();
	$query_user = $con->query("SELECT * FROM pelanggan WHERE id_pelanggan = '$_SESSION[id]' ")->fetch_object();



	$jumlah_biaya = $query->biaya * $query->jml_tiket;

	$params = array(
		'transaction_details' => array(
			'order_id' => date("Ymd") . rand(),
			'gross_amount' => $jumlah_biaya // no decimal allowed
		),
		"customer_details" => [
			"first_name" => "",
			"last_name" => $query_user->pelanggan,
			"email" => $query_user->email,
			"phone" => $query_user->hp
		],
		"custom_expiry" => [
			"order_time" => date('Y-m-d H:i:s'),
			"expiry_duration" => 1,
			"unit" => "day"
		]
	);
	$midtransconfig = new \Midtrans\Config;
	// $midtransconfig = new \Veritrans_Config;
	$midtransSnap	= new \Midtrans\Snap;
	// $midtransSnap	= new \Veritrans_Snap;

	// Set your Merchant Server Key
	$midtransconfig::$serverKey = 'SB-Mid-server-270TWDakPQ0jjPb9OKRI92WS';
	// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
	$midtransconfig::$isProduction = true;
	// Set sanitization on (default)
	$midtransconfig::$isSanitized = true;
	// Set 3DS transaction for credit card to true
	$midtransconfig::$is3ds = true;

	$snapToken = $midtransSnap::getSnapToken($params);

	if (empty($query->id_pembayaran)) {
	} else {
		$datanotif = \Midtrans\Transaction::status($query->id_pembayaran);
		if ($datanotif->transaction_status == "settlement" && $query->status == 'belum dibayar') {
			header("Location:upload-bukti-transfer-selesai.php?id=$kd_pembayaran");
		}
		if ($datanotif->transaction_status == "settlement" && $query->status == 'sudah bayar') {
			header("Location:system/tiket.php");
		}
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
			<div class="contact-agileinfo pt-lg-4">
				<!-- contact form -->
				<div class="contact-right mt-lg-0 mt-5">
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
					<!-- <div id='form'>
						<h3> HASIL TIMER</h3>
						<div style='background: #D20000;height: 100px;width: 100%; color: white;justify-content: center;display:flex;align-items: center'>
							<div id="waktumundur" class="text-center"></div>
							<?php $root  = "https://" . $_SERVER['HTTP_HOST'];
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
					</div> -->
					<div class="row">
						<div class="col-md-2" style="display: flex;justify-content: center;padding-top: 5%">
							<img src="images/rek.png" style="align-items: center;width: 94px;height:94px">
						</div>
						<?php if (isset($datanotif)) { ?>
							<div class="col-md-6">
								<table class="table table-sm my-4 mx-auto col-md-5 bg-blue">
									<?php if (isset($datanotif->store)) { ?>
										<tr>
											<td class="font-weight-bold">Tempat Pembayaran</td>
											<td><?= $datanotif->store ?></td>
										</tr>
										<tr>
											<td class="font-weight-bold">Kode Transaksi</td>
											<td><?= $datanotif->payment_code ?></td>
										</tr>
									<?php } ?>
									<?php if (isset($datanotif->payment_type)) { ?>
										<tr>
											<td class="font-weight-bold">Tempat Pembayaran</td>
											<td><?= $datanotif->payment_type ?></td>
										</tr>
									<?php } ?>
									<?php if (isset($datanotif->approval_code)) { ?>
										<tr>
											<td class="font-weight-bold">Approval Code</td>
											<td><?= $datanotif->approval_code ?></td>
										</tr>
									<?php } ?>
									<?php if (isset($datanotif->va_numbers)) { ?>
										<tr>
											<td class="font-weight-bold">Bank</td>
											<td><?= $datanotif->va_numbers[0]->bank ?></td>
										</tr>
										<tr>
											<td class="font-weight-bold">Va Number</td>
											<td><?= $datanotif->va_numbers[0]->va_number ?></td>
										</tr>

									<?php } ?>
									<tr>
										<td class="font-weight-bold">Biaya</td>
										<td><?= $datanotif->gross_amount ?></td>
									</tr>
									<!-- <tr>
										<td class="font-weight-bold">Tenggang Waktu</td>
										<td class="font-weight-bold"><span id="waktuawal"><?= $datanotif->transaction_time ?></span></td>
									</tr>
									<tr>
										<td class="font-weight-bold">Waktu Mundur</td>
										<td class="font-weight-bold" style="color: red"><span id="waktumundur"><?= $datanotif->transaction_time ?></span></td>
									</tr> -->
									<!-- <script>
										var intervalnew = setInterval(function() {
											var tanggal = new Date("<?= $datanotif->transaction_time  ?>");
											var tgl_berangkat = tanggal.getTime();
											var now = new Date().getTime();
											var waktumundur = tgl_berangkat - now;
											console.log('tgl berangkat ' + new Date(tgl_berangkat));
											if (waktumundur <= 0) {
												console.log('expired');
												document.getElementById('waktumundur').innerHTML = "EXPIRED " + konversi(waktumundur);
												document.getElementById('transfer').style.display = "none";
												// alert("Waktu bayar telah EXPIRED");
												// clearInterval(intervalnew);
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
									</script> -->
									<tr>
										<td class="font-weight-bold">Status Transaksi</td>
										<td><?= $datanotif->transaction_status ?></td>
									</tr>
									<tr>
										<td class="text-center" colspan="2">Informasi Selengkapnya Silahkan Cek Email Anda</td>
									</tr>
									<tr>
										<td colspan="2" class="font-weight-bold text-center"><a href="<?= $query->url_panduan_pembayaran ?>">Panduan Pembayaran</a></td>
									</tr>
									<tr>
										<td></td>
										<td></td>
									</tr>
								</table>
							</div>
						<?php } else { ?>
							<div class="col-md-2">
								<p>Nama </p>
								<p>No Rekening </p>
								<p>Biaya </p>

							</div>
							<div class="col-md-4">
								<p>: <?= $nama ?></p>
								<p>: <?= $norek ?></p>

								<?php
								//$jml = $jml_tiket * 150000;
								echo '<p>: ' . rupiah($biaya) . '</p>';
								?>
							</div>
						<?php } ?>



					</div>
					<br>
					<div id="transfer">
						<div class="row">
							<div class="col-lg-4 form-group pr-lg-2">

							</div>
							<div class="col-lg-8 form-group pl-lg-2">
								<script src="system/js/axios.min.js" type="text/javascript"></script>
								<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KOObE-Oc9gK-mPxI"></script>

								<?php if (!isset($datanotif) || $datanotif->transaction_status == 'expired' || $datanotif->transaction_status == 'cancel') { ?>
									<button id="pay-button" type="button" class="btn btn-sm btn-primary">Pilih Metode Pembayaran</button>
								<?php } ?>
								<script type="text/javascript">
									var payButton = document.getElementById('pay-button');
									payButton.addEventListener('click', function() {
										// snap.pay('<SNAP_TOKEN>');
										snap.show();
										snap.pay('<?= $snapToken ?>', {
											onSuccess: function(result) {
												console.log('success');
												console.log(result);
												axios.post('<?= $root . "system/api_pembayaran.php?id=$kd_pembayaran" ?>', result).then(response => {
													console.log(response);
													alert('Success');
													window.location.href = "<?= $root . "upload-bukti-transfer.php?id=$kd_pembayaran" ?>"
												});
											},
											onPending: function(result) {
												console.log('pending');
												axios.post('<?= $root . "system/api_pembayaran.php?id=$kd_pembayaran" ?>', result).then(response => {
													alert('Pending');
													window.location.href = "<?= $root . "upload-bukti-transfer.php?id=$kd_pembayaran" ?>"
												});
												console.log(result);
											},
											onError: function(result) {
												console.log('error');
												console.log(result);
												alert('Error');
											},
											onClose: function() {
												console.log('customer closed the popup without finishing the payment');
											}
										});
									});
								</script>
							</div>
						</div>
					</div>

				</div>
				<!-- contact form -->
			</div>
		</div>
	</section>
	<!-- contact -->

	<?php
	include_once('footer.php');
	?>