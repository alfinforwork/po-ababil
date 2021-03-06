<?php
	require_once('header.php');
	// require_once('../connect.php');

	// Hapus data rekening
	if(isset($_GET['hapus']))
	{
		$id   = $_GET['hapus'];
		if ($stmt = $con->prepare('DELETE FROM rekening where id_rekening=?')) {		
			$stmt->bind_param('i', $id);
			$stmt->execute();
			$message = "Berhasil hapus nomer rekening!";
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
			$message = "Gagal hapus nomer rekening!";
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
?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<div class="col-lg-12 mb-12">
					<div class="card">
						<div class="card-header">
							<h6 class="text-uppercase mb-0">Rekening</h6>
						</div>
						<div class="card-body">
							<?php
							if ($_SESSION['level'] == 'admin'){
								echo '<a href="tambah-rekening.php" class="btn bg-primary">Tambah</a> <hr>';
							}
							?>
							<div class="table-responsive">
								<table id="example" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama</th>
											<th>Nomer Rekening</th>
											<th>Bank</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
											// Menampilkan data rekening dalam tabel
											$no = 1;
											$stmt = $con->prepare('SELECT * FROM rekening');
											if (
												$stmt &&
												$stmt->execute() &&
												$stmt->store_result() &&
												$stmt->bind_result($id, $nama, $norek, $bank)
											) {
												while ($stmt -> fetch()) {
													echo '<tr>
														<td scope="row">'.$no++.'</td>
														<td>'.$nama.'</td>
														<td>'.$norek.'</td>
														<td>'.$bank.'</td>
														<td>
															<a href="detail-rekening.php?id='.$id.'">Detail</a>';
															if ($_SESSION['level'] == 'admin'){
																echo ' | <a href="rekening.php?hapus='.$id.'">Hapus</a>';
															}
														echo '
														</td>
													</tr>';
												}
											} else {
												echo '<tr>
														<td scope="row"></td>
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
		} );
	</script>
	
<?php
	require_once('footer.php');
?>