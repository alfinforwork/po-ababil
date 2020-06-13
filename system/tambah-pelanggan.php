<?php
require_once('header.php');
// require_once('../connect.php');

if (isset($_POST['addPelanggan'])){
	$pelanggan 	= $_POST['fullname'];
	$email		= $_POST['email'];
	$password 	= $_POST['password'];
	$tmp_lahir	= $_POST['tmp_lahir'];
	$tgl_lahir	= $_POST['tgl_lahir'];
	$alamat		= $_POST['alamat'];
	$hp 			= $_POST['hp'];

	// Mengecek apakah ada masukkan fullname, email dan password
	if (!isset($pelanggan, $email, $password)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi nama lengkap, email dan password !');
	}
	// Memastikan tidak ada input yang kosong.
	if (empty($pelanggan) || empty($email) || empty($password)) {
		// Nama lengkap, email atau password masih kosong.
		die ('Nama lengkap atau email atau password masih kosong !');
	}
	// Email Validation
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		die ('Email is not valid!');
	}
	// Character Length Check
	if (strlen($password) < 5) {
		die ('Password must be 5 characters long!');
	}

	// Mengecek apakah email ada yang sama di tabel sopir
	if ($stmt = $con->prepare('SELECT `id_sopir`, `email` FROM `sopir` WHERE `email` = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the email exists in the database.
		if ($stmt->num_rows > 0) {
			// Email sudah ada
			$message = "Email sudah ada, silahkan input email lain!";
			echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "'.$message.'",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
			return false;
		}
	}

	// Mengecek apakah email ada yang sama di tabel admin
	if ($stmt = $con->prepare('SELECT `id_admin`, `email` FROM `admin` WHERE `email` = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the email exists in the database.
		if ($stmt->num_rows > 0) {
			// Email sudah ada
			$message = "Email sudah ada, silahkan input email lain!";
			echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "'.$message.'",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
			return false;
		}
	}

	// Mengecek apakah email ada yang sama.
	if ($stmt = $con->prepare('SELECT `id_pelanggan`, `email` FROM `pelanggan` WHERE `email` = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the email exists in the database.
		if ($stmt->num_rows > 0) {
			// Username sudah ada
			$message = "Email sudah ada, silahkan input email lain!";
			echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "'.$message.'",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
			return false;
		} else {
			// Username belum ada, masukkan email ke database	
			if ($stmt = $con->prepare("INSERT INTO `pelanggan` 
										(`pelanggan`, `email`, `password`, `tmp_lahir`, `tgl_lahir`, `alamat`, `hp`)
										VALUES (?, ?, ?, ?, ?, ?, ?)")) {
				$pwd 	= password_hash($password, PASSWORD_DEFAULT);
				$stmt->bind_param('sssssss', $pelanggan, $email, $pwd, $tmp_lahir, $tgl_lahir, $alamat, $hp);
				$stmt->execute();

				$message = "Anda berhasil menambahkan pelanggan baru!";
				echo '<script type="text/javascript">							
							Swal.fire({
								title: "Sukses!",
								text: "'.$message.'",
								type: "success",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href = "pelanggan.php";
							});
						</script>';
			} else {
				// Something is wrong with the sql statement.
				$message = "Gagal menambahkan pelanggan baru!";
				echo '<script type="text/javascript">							
							Swal.fire({
								title: "Error!",
								text: "'.$message.'",
								type: "error",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.history.back();
							});
						</script>';
			}
		}
		$stmt->close();
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal menambahkan pelanggan baru!";
		echo '<script type="text/javascript">							
					Swal.fire({
						title: "Error!",
						text: "'.$message.'",
						type: "error",
						timer: 2000,
						showConfirmButton: false
					}).then(function(result) { 
						window.history.back();
					});
				</script>';
	}
	$con->close();
}
?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<!-- Form Elements -->
				<div class="col-lg-12 mb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="h6 text-uppercase mb-0">Tambah Pelanggan</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nama Lengkap</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="fullname" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Tempat Lahir</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="tmp_lahir" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Tanggal Lahir</label>
									<div class="col-md-4">
										<input type="date" class="form-control" name="tgl_lahir" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Email</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="email" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Password</label>
									<div class="col-md-4">
										<input type="password" class="form-control" name="password" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">No HP</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="hp" required>
										<input type="hidden" class="form-control" name="level" value="pelanggan">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Alamat</label>
									<div class="col-md-8">
										<input type="text" class="form-control" name="alamat">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" class="btn btn-primary" name="addPelanggan">Save</button>
										<a href="pelanggan.php" class="btn btn-secondary">Cancel</a>
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