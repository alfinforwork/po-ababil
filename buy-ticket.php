<?php
session_start();
include_once('header.php');

if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit();
}

if (isset($_POST['beli'])) {
	$q = $con->query("SELECT id_biaya from biaya where id_lokasi_dari = $_POST[tmp_jemput] and id_lokasi_ke = $_POST[tmp_tujuan] ");
	$id_biaya = $q->fetch_assoc();
	$tgl_berangkat		= $_POST['tgl_berangkat'];
	$jml_tiket			= $_POST['jml_tiket'];
	$no_kursi			= $_POST['no_kursi'];
	$id_biaya			= $id_biaya['id_biaya'];
	$alamat_lengkap_dari = $_POST['alamatpenjemputan'];
	$alamat_lengkap_ke	= $_POST['alamattujuan'];
	$waktu				= $_POST['waktu'];
	$status				= 'belum dibayar';
	$id_pelanggan		= $_SESSION['id'];
	if ($jml_tiket == 0 or empty($jml_tiket)) {
		echo '<script type="text/javascript">							
							Swal.fire({
								title: "Error!",
								text: "Silahkan Pilih Nomor Kursi",
								type: "error",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href="buy-ticket.php"
							});
						</script>';
	} else {
		$sql = "INSERT INTO pemesanan
						(tgl_berangkat, jml_tiket, no_kursi, id_biaya, alamat_lengkap_dari, alamat_lengkap_ke, `status`, waktu, id_pelanggan) 
						VALUES ('$tgl_berangkat', '$jml_tiket', '$no_kursi', '$id_biaya', '$alamat_lengkap_dari', '$alamat_lengkap_ke', '$status', '$waktu', '$id_pelanggan')";
		if ($stmt = $con->query($sql)) {

			echo '<script type="text/javascript">
								window.location.href = "upload-bukti-transfer.php?id=' . $con->insert_id . '";
							</script>';
		} else {
			// Something is wrong with the sql statement.
			$message = "Transaksi belum berhasil!";
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
		}
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
					$email = $_SESSION['email'];
					$stmt = $con->query("SELECT * FROM pelanggan WHERE email = '$email' limit 1");
					if ($stmt->num_rows > 0) {
						$data = $stmt->fetch_assoc();
					} else {
						$email 		= "";
						$pelanggan 	= "";
						$tmp_lahir	= "";
						$tgl_lahir	= "";
						$alamat 		= "";
						$hp 			= "";
					}
				} else {
					$email 		= "";
					$pelanggan 	= "";
					$tmp_lahir	= "";
					$tgl_lahir	= "";
					$alamat 		= "";
					$hp 			= "";
				}
				?>
				<h3 class="footer-title mb-4 pb-lg-2">Form Pemesanan Tiket</h3>
				<form method="post">
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Nama Lengkap</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="text" class="form-control" style="background-color: rgba(0,0,0,0.1);color: black" value="<?= $data['pelanggan'] ?>" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Tempat Lahir</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="text" class="form-control" value="<?= $data['tmp_lahir'] ?>" style="background-color: rgba(0,0,0,0.1);color: black" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Tanggal Lahir</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="date" class="form-control" value="<?= $data['tgl_lahir'] ?>" style="background-color: rgba(0,0,0,0.1);color: black" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Alamat</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="text" class="form-control" value="<?= $data['alamat'] ?>" style="background-color: rgba(0,0,0,0.1);color: black" disabled>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Pilih kota penjemputan</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<select type="text" class="form-control" name="tmp_jemput" id="tmp_jemput" required="">
								<option value="0">Pilih kota penjemputan</option>
								<?php $query = $con->query('SELECT * from alamat where remove=1 and active=1');
								while ($key = $query->fetch_assoc()) { ?>
									<option value="<?= $key['id_alamat'] ?>"><?= $key['nama_lokasi'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Alamat spesifik penjemputan</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="text" class="form-control" name="alamatpenjemputan">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Tujuan</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<select type="text" class="form-control" name="tmp_tujuan" id="tmp_tujuan" required="">
								<option value="0">Pilih kota tujuan</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Alamat spesifik tujuan</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="text" class="form-control" name="alamattujuan">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Tanggal Berangkat</p>
						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<input type="date" class="form-control" id="tgl_berangkat" name="tgl_berangkat" required="">
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">Waktu Berangkat</p>
						</div>
						<div class="col-lg-4 form-group pl-lg-2">
							<select name="waktu" class="form-control" id="waktu">
								<option value="pagi">Pagi</option>
								<option value="sore">Sore</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">No Kursi</p>
						</div>
						<div class="col-lg-3 form-group pr-lg-2">


							<input type="hidden" class="form-control" name="jml_tiket" id="jml_tiket" required="">
							<input type="hidden" class="form-control" name="no_kursi" id="no_kursi" required="">

							<style type="text/css">
								.kursiaktif {
									background-color: green;
								}

								.kursitakaktif {
									background-color: red !important;
								}

								.kursiselect {
									background-color: blue;
								}

								.kursilist {
									flex: 1;
									padding: 10px;
									color: white;
									margin: 0.5px;
								}
							</style>
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


							<script src="system/js/axios.min.js"></script>
							<?php
							$root  = "https://" . $_SERVER['HTTP_HOST'];
							$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
							?>

							<script type="text/javascript">
								$('#tgl_berangkat').change(function() {
									var waktu = $('#waktu').val();
									var tanggal = $(this).val();
									console.log("tanggal berangkat = " + $(this).val());
									ajax(tanggal, waktu);
								});
								$('#waktu').change(function() {
									var waktu = $(this).val();
									var tanggal = $('#tgl_berangkat').val();
									ajax(tanggal, waktu);
									console.log("waktu = " + $(this).val());
								});
								$('#tmp_jemput').change(function() {
									var id_tmp_jemput = $(this).val();
									var html = '<option value="0">Pilih kota tujuan</option>';
									axios.get('<?= $root ?>api-buy-ticket.php?id=' + id_tmp_jemput).then(function(res) {
										res.data.map(value => {
											console.log(value);
											html += `<option value="${value.id_lokasi_ke}">${value.nama_lokasi}</option>`;
										})
										console.log(html);
										$('#tmp_tujuan').html(html);
									});

								})
								$('#tmp_tujuan').change(function() {
									var waktu = $(this).val();
									var tanggal = $('#tgl_berangkat').val();
									ajax(tanggal, waktu);
									console.log("waktu = " + $(this).val());
								})

								function ajax(tanggal, waktu) {
									$.get("<?= $root ?>buy-ticket-show-kursi.php/?tanggal=" + tanggal + "&waktu=" + waktu, function(res) {
										var result = JSON.parse(res);
										console.log(result.length);
										if (result.length == 0) {
											console.log("data kosong");
											for (var i = 1; i <= 8; i++) {
												$('#kursi' + i).removeClass("kursiselect");
												$('#kursi' + i).removeClass("kursitakaktif");
											}
										} else {
											$.each(result, function(index, value) {
												var no_kursi = value.no_kursi;
												var split = no_kursi.split(',');
												$.each(split, function(index2, value2) {
													if (value2 != '') {
														$('#kursi' + value2).addClass("kursitakaktif");
														console.log(value2);
													}
												})
												console.log(split);
											})
										}
									});
								}


								function klikkursi(prop) {
									$('#kursi' + prop).click(function() {
										$(this).toggleClass("kursiselect");
									});
								}
								setInterval(function() {
									var jmltiket = 0,
										tiket = '';
									for (var i = 1; i <= 8; i++) {
										if ($('#kursi' + i).hasClass("kursiselect") && !$('#kursi' + i).hasClass("kursitakaktif")) {
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
						<div class="col-lg">
							<p>Klik 2x untuk memilih kursi</p>
							<p style="color: red">Merah=kursi sudah dipesan</p>
							<p style="color: green">hijau=kursi kosong</p>
							<p style="color: blue">biru=kursi pilihan anda</p>
							<p>putih=kursi sopir</p>
						</div>
					</div>

					<!-- <div class="row">
						<div class="col-lg-4 form-group pr-lg-2">
							<p class="buy">No Kursi</p>
						</div>
						<div class="col-lg-3 form-group pl-lg-2">
							<input type="text" class="form-control" name="no_kursi" required="">
						</div>
						<div class="col-lg-5 form-group pr-lg-2">
							<p>* No kursi bisa berubah jika sudah dipesan orang lain</p>
						</div>
					</div> -->
					<!-- <div class="form-group">
							<textarea name="pesan" class="form-control" placeholder="Message" required=""></textarea>
						</div> -->
					<div class="row">
						<div class="col-lg-4 form-group pr-lg-2">

						</div>
						<div class="col-lg-8 form-group pl-lg-2">
							<button type="submit" name="beli" class="btn submit-contact-main">Beli</button>
						</div>
					</div>

				</form>
			</div>
			<!-- contact form -->
			<!-- contact address -->
			<div class="col-md-5 address">
				<h3 class="footer-title mb-4 pb-lg-2">Informasi</h3>
				<div class="row address-info-w3ls">
					<div class="col-3 address-left">
						<img src="images/calender.png" width="56" class="img-fluid">
					</div>
					<div class="col-9 address-right mt-2">
						<h5 class="address mb-2">Hari</h5>
						<p> Berangkat setiap Senin s/d Minggu.</p>
					</div>
				</div>
				<div class="row address-info-w3ls my-2">
					<div class="col-3 address-left">
						<img src="images/clock.png" width="56" class="img-fluid">
					</div>
					<div class="col-9 address-right mt-2">
						<h5 class="address mb-2">Waktu</h5>
						<p> Pagi : 08.00 WIB | Sore : 17.00 WIB</p>
					</div>
				</div>
				<div class="row address-info-w3ls">
					<div class="col-3 address-left">
						<img src="images/bus.png" width="56" class="img-fluid">
					</div>
					<div class="col-9 address-right mt-2">
						<h5 class="address mb-2">Mobil</h5>
						<p> Mobil L300</p>
					</div>
				</div>
				<p class="buy"></p>
				<p class="buy"> Denah tempat duduk</p>
				<div class="row address-info-w3ls my-2">
					<div class="col-12 address-left">
						<img src="images/denah.png" width="192" class="img-fluid">
					</div>
				</div>
			</div>
			<!-- //contact address -->
		</div>
	</div>
</section>
<!-- contact -->

<?php
include_once('footer.php');
?>