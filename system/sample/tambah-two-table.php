<?php
require_once('header.php');
require_once('../connect.php');

if (isset($_POST['addPelanggan'])){
	$username 	= $_POST['username'];
	$password 	= $_POST['password'];
	$pelanggan 	= $_POST['fullname'];
	$hp 			= $_POST['hp'];
	$email		= $_POST['email'];
	$level		= $_POST['level'];
	$alamat		= $_POST['alamat'];

	// Mengecek apakah ada masukkan fullname, username dan password
	if (!isset($pelanggan, $username, $password)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi nama lengkap, username dan password !');
	}
	// Memastikan tidak ada input yang kosong.
	if (empty($pelanggan) || empty($username) || empty($password)) {
		// Nama lengkap, username atau password masih kosong.
		die ('Nama lengkap atau username atau password masih kosong !');
	}
	// Email Validation
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		die ('Email is not valid!');
	}
	// Character Length Check
	if (strlen($password) < 5) {
		die ('Password must be 5 characters long!');
	}

	// Mengecek apakah username ada yang sama.
	if ($stmt = $con->prepare('SELECT id_user, username FROM users WHERE username = ?')) {
		// Bind parameters (s = string, i = int, b = blob, etc)
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$stmt->store_result();
		// Store the result so we can check if the nopol exists in the database.
		if ($stmt->num_rows > 0) {
			// Username sudah ada
			$message = "Username sudah ada, silahkan input username lain!";
			echo "<script type='text/javascript'>alert('$message');</script>";
		} else {
			// Username belum ada, masukkan username ke database
			$stmt1 	= $con->prepare("INSERT INTO users (username, password, level) VALUES (?, ?, ?)");
			$pwd 		= password_hash($password, PASSWORD_DEFAULT);
			$stmt1->bind_param('sss', $username, $pwd, $level);
			
			$con->begin_transaction();
			if ($stmt1->execute()) {
				$id_user = $con->insert_id;

				$stmt2 = $con->prepare("INSERT INTO pelanggan (pelanggan, alamat, hp, id_user) VALUES (?, ?, ?, ?)");
				$stmt2->bind_param("sssi", $pelanggan, $alamat, $hp, $id_user);
				
				$stmt2->execute();
				$con->commit();

				$message = "Anda berhasil menambahkan pelanggan baru!";
				echo "<script type='text/javascript'>
							alert('$message');
							window.location.href = 'pelanggan.php';
						</script>";
			} else {
				// Something is wrong with the sql statement.
				$message = "Could not prepare statement!";
				echo "<script type='text/javascript'>alert('$message');</script>";
			}
		}
		$stmt->close();
	} else {
		// Something is wrong with the sql statement.
		$message = "Could not prepare statement!";
		echo "<script type='text/javascript'>alert('$message');</script>";
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
									<label class="col-md-3 form-control-label">Username</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="username" required>
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
									<label class="col-md-3 form-control-label">Email</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="email" required>
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