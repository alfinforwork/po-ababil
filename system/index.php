<?php

require_once('header.php');
// require_once('../connect.php');

?>

<!-- HOME -->
<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
			<?php
			if ($_SESSION['level'] != 'pelanggan'){
				echo '
				<div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
					<div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
						<div class="flex-grow-1 d-flex align-items-center">
							<div class="dot mr-3 bg-red"></div>
							<div class="text">
								<h6 class="mb-0">Tiket Terjual</h6>';
								
									$stmt = $con->prepare('SELECT * FROM pemesanan');
									$stmt->execute();
									$stmt->store_result();
									$count = $stmt->num_rows;
									echo '<span class="text-gray">'.$count.'</span>
								
							</div>
						</div>
						<div class="icon text-white bg-red"><i class="fas fa-receipt"></i></div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
					<div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
						<div class="flex-grow-1 d-flex align-items-center">
							<div class="dot mr-3 bg-green"></div>
							<div class="text">
								<h6 class="mb-0">Pelanggan</h6>';
									$stmt = $con->prepare('SELECT * FROM pelanggan');
									$stmt->execute();
									$stmt->store_result();
									$count = $stmt->num_rows;
									echo '<span class="text-gray">'.$count.'</span>
							</div>
						</div>
						<div class="icon text-white bg-green"><i class="fas fa-users"></i></div>
					</div>
				</div>';
			} else {
				echo '
				<div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
					<div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
						<div class="flex-grow-1 d-flex align-items-center">
							<div class="dot mr-3 bg-red"></div>
							<div class="text">
								<h6 class="mb-0">Tiket Anda</h6>';
									$stmt = $con->prepare('SELECT * FROM pemesanan WHERE id_pelanggan=?');
									$stmt->bind_param('i', $id);
									$stmt->execute();
									$stmt->store_result();
									$count = $stmt->num_rows;
									echo '<span class="text-gray">'.$count.'</span>
							</div>
						</div>
						<div class="icon text-white bg-red"><i class="fas fa-receipt"></i></div>
					</div>
				</div>';
			}
			?>
				<div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
					<div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
						<div class="flex-grow-1 d-flex align-items-center">
							<div class="dot mr-3 bg-blue"></div>
							<div class="text">
								<h6 class="mb-0">Mobil</h6>
								<?php
									$stmt = $con->prepare('SELECT * FROM mobil');
									$stmt->execute();
									$stmt->store_result();
									$count = $stmt->num_rows;
									echo '<span class="text-gray">'.$count.'</span>';
								?>
							</div>
						</div>
						<div class="icon text-white bg-blue"><i class="fa fa-bus"></i></div>
					</div>
				</div>
				<div class="col-xl-3 col-lg-6 mb-4 mb-xl-0">
					<div class="bg-white shadow roundy p-4 h-100 d-flex align-items-center justify-content-between">
						<div class="flex-grow-1 d-flex align-items-center">
							<div class="dot mr-3 bg-violet"></div>
							<div class="text">
								<h6 class="mb-0">Sopir</h6>
								<?php
									$stmt = $con->prepare('SELECT * FROM sopir');
									$stmt->execute();
									$stmt->store_result();
									$count = $stmt->num_rows;
									echo '<span class="text-gray">'.$count.'</span>';
								?>
							</div>
						</div>
						<div class="icon text-white bg-violet"><i class="fas fa-user-cog"></i></div>
					</div>
				</div>
			</div>
		</section>
	</div>
<!-- END HOME -->

<?php
	include_once('footer.php');
?>