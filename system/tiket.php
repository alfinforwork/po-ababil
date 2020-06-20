<?php
include_once('header.php');
// require_once('../connect.php');
function rupiah($angka)
{

	$hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $hasil_rupiah;
}

if (isset($_GET['hapus'])) {
	$id   = $_GET['hapus'];
	if ($stmt = $con->prepare('DELETE FROM pemesanan WHERE kd_pemesanan=?')) {
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$message = "Berhasil hapus tiket!";
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
		$message = "Gagal hapus tiket!";
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
?>


<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<div class="col-lg-12 mb-12">
					<div class="card">
						<div class="card-header">
							<h6 class="text-uppercase mb-0">Tiket</h6>
						</div>
						<div class="card-body">
							<?php
							if ($_SESSION['level'] == 'pelanggan') {
								echo '<a href="../buy-ticket.php" class="btn bg-primary">Beli Tiket</a> <hr>';
							}
							?>
							<?php
							if ($_SESSION['level'] == 'admin') {
								echo '<a href="../pdf.php" class="btn bg-primary">cetak laporan</a> <hr>';
							}
							?>
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">

									<thead>
										<tr>
											<th>No</th>
											<th>Pelanggan</th>
											<th>Penjemputan</th>
											<th>Tujuan</th>
											<th>Tanggal</th>
											<th>Status</th>
											<th>Harga</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										// Menampilkan data tiket dalam tabel
										$id_pelanggan = $_SESSION['id'];
										$no = 1;
										if (($_SESSION['level'] == 'admin') | ($_SESSION['level'] == 'sopir')) {
											$stmt = $con->prepare(
												'SELECT 
													`kd_pemesanan`, 
													`pelanggan`.`pelanggan`,
													`alamatdari`,
													`alamatke`,
													`tgl_berangkat`,
													(`biaya`*`jml_tiket`) as biaya,
													`status`
												FROM pemesanan 
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
													) as biayas ON pemesanan.id_biaya = biayas.id_biaya'
											);
										} else {
											$stmt = $con->prepare(
												'SELECT 
													`kd_pemesanan`, 
													`pelanggan`.`pelanggan`,
													`alamatdari`,
													`alamatke`,
													`tgl_berangkat`,
													(`biaya`*`jml_tiket`) as biaya,
													`status`
												FROM pemesanan 
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
												WHERE pemesanan.id_pelanggan = ?'
											);
											$stmt->bind_param('i', $id_pelanggan);
										}

										if (
											$stmt &&
											$stmt->execute() &&
											$stmt->store_result() &&
											$stmt->bind_result($id, $pelanggan, $alamatdari, $alamatke, $tgl_berangkat, $harga, $status)
										) {
											while ($stmt->fetch()) {
												echo '<tr>
													<td scope="row">' . $no++ . '</td>
													<td>' . $pelanggan . '</td>
													<td>' . $alamatdari . '</td>
													<td>' . $alamatke . '</td>
													<td>' . $tgl_berangkat . '</td>';
												if ($status == 'belum dibayar') {
													echo '<td style="background: red; color: white">' . $status . '</td>';
												} else if ($status == 'sudah dibayar') {
													echo '<td style="background: green; color: white">' . $status . '</td>';
												} else if ($status == 'selesai') {
													echo '<td style="background: blue; color: white">' . $status . '</td>';
												} else {
													echo '<td style="background: black; color: white">' . $status . '</td>';
												}
												echo '
													<td>' . rupiah($harga) . '</td>
													<td><a href="detail-tiket.php?id=' . $id . '">Detail</a>';
												if ($_SESSION['level'] == 'admin') {
													echo ' | <a href="tiket.php?hapus=' . $id . '">Hapus</a>';
												}
												echo '</td>
												</tr>';
											}
										} else {
											echo '<tr>
													<td scope="row"></td>
													<td></td>
													<td></td>
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
			</div>
		</section>
	</div>

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		});
	</script>

	<?php
	include_once('footer.php');
	?>