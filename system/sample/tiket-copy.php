<?php
	include_once('header.php');
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
							<a href="#" class="btn bg-primary">Beli Tiket</a> <hr>
							<table id="example" class="table card-text">
								<thead>
									<tr>
										<th>No</th>
										<th>Pelanggan</th>
										<th>Tujuan</th>
										<th>Tanggal</th>
										<th>Harga</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<th scope="row">1</th>
										<td>Mark</td>
										<td>Semarang</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">2</th>
										<td>Thornton</td>
										<td>Klaten</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">3</th>
										<td>Larry</td>
										<td>Solo</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">4</th>
										<td>Mark</td>
										<td>Semarang</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">5</th>
										<td>Thornton</td>
										<td>Klaten</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">6</th>
										<td>Larry</td>
										<td>Solo</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">7</th>
										<td>Mark</td>
										<td>Semarang</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">8</th>
										<td>Thornton</td>
										<td>Klaten</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">9</th>
										<td>Larry</td>
										<td>Solo</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">10</th>
										<td>Mark</td>
										<td>Semarang</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">11</th>
										<td>Thornton</td>
										<td>Klaten</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
									<tr>
										<th scope="row">12</th>
										<td>Larry</td>
										<td>Solo</td>
										<td>18/12/2019</td>
										<td>150.000</td>
										<td>Dibayar</td>
										<td>Detail | Hapus</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<script>
		$(document).ready(function() {
			$('#example').DataTable();
		} );
	</script>
	
<?php
	include_once('footer.php');
?>