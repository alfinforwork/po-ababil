	<?php
	include_once('header.php');
	?>

	<!-- tracking -->
	<div class="login-contect py-5">
		<div class="container py-xl-5 py-3">
			<div class="login-body">
				<div class="login p-4 mx-auto">
					<h5 class="text-center mb-4">Tracking</h5>
					<!-- <form action="#" method="post">
						<div class="form-group">
							<label>Nomor Kendaraan</label>
							<input type="text" class="form-control" name="nomor" placeholder="" required="">
						</div>						
						<button type="submit" class="btn tracking mb-4">Tracking</button>
					</form> -->
					<table class="table card-text">
						<thead>
							<tr>
								<th>No</th>
								<th>No Kendaraan</th>
								<th>Mobil</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$no = 1;
							$q = $con->query("SELECT l.id_mobil, l.latitude, l.longitude, m.nopol, m.merk 
														FROM lokasi l JOIN mobil m ON l.id_mobil = m.id_mobil");

							echo "<pre>";
							print_r($q->fetch_assoc);
							echo "</pre>";

							$stmt = $con->prepare('SELECT l.id_mobil, l.latitude, l.longitude, m.nopol, m.merk 
														FROM lokasi l JOIN mobil m ON l.id_mobil = m.id_mobil');
							if (
								$stmt &&
								$stmt->execute() &&
								$stmt->store_result() &&
								$stmt->bind_result($id_mobil, $latitude, $longitude, $nopol, $merk)
							) {
								while ($stmt->fetch()) {
									echo '<tr>
										<td scope="row">' . $no++ . '</td>
										<td>' . $nopol . '</td>
										<td>' . $merk . '</td>
										<td>
											<a href="https://maps.google.com/maps?q=' . $latitude . ',' . $longitude . '" target="_blank">Tracking</a>
										</td>
									</tr>';
								}
							} else {
								echo '<tr>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>';
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //tracking -->

	<!-- map -->
	<!-- <section class="map">
		<iframe
			src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d423286.27404345275!2d-118.69191921441556!3d34.02016130939095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2sLos+Angeles%2C+CA%2C+USA!5e0!3m2!1sen!2sin!4v1522474296007"
			allowfullscreen></iframe>
	</section> -->
	<!-- //map -->

	<?php
	include_once('footer.php');
	?>