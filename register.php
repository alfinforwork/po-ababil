<?php
		include_once('header.php');
		require_once('connect.php');

		if (isset($_POST['register'])){
			$pelanggan 	= $_POST['fullname'];
			$email		= $_POST['email'];
			$password 	= $_POST['password'];
			$confirm 	= $_POST['confirmpassword'];
			$hp			= $_POST['hp'];

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
			if (is_numeric($pelanggan))
			{
					$message = "Maaf, nama tidak boleh angka!";
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
			// Email Validation
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$message = "Email yang diinputkan salah!";
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
			// Character Length Check
			if (strlen($password) < 5) {
				$message = "password kurang dari 5 karakter!";
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
			// Password Confirm Check
			if ($password != $confirm) {
				$message = "password konfirm salah!";
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
			//hp
			if (!is_numeric($hp))
			{
					$message = "Maaf, nomor harus pakai angka!";
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
			if (strlen($hp) > 13 ) {
				$message = "nomor yang dimasukan lebih dari 13!";
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

			// Mengecek apakah email ada yang sama di tabel sopir
			if ($stmt = $con->prepare('SELECT id_sopir, email FROM sopir WHERE email = ?')) {
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
			if ($stmt = $con->prepare('SELECT id_admin, email FROM admin WHERE email = ?')) {
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

			// Mengecek apakah email ada yang sama di tabel pelanggan
			if ($stmt = $con->prepare('SELECT id_pelanggan, email FROM pelanggan WHERE email = ?')) {
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
				} else {
					// Email belum ada, masukkan email ke database	
					if ($stmt = $con->prepare("INSERT INTO pelanggan 
												(`pelanggan`, `email`, `password`, `hp`)
												VALUES (?, ?, ?, ?)")) {
						$pwd 	= password_hash($password, PASSWORD_DEFAULT);
						$stmt->bind_param('ssss', $pelanggan, $email, $pwd, $hp);
						$stmt->execute();

						$message = "Pendaftaran berhasil !";
						echo '<script type="text/javascript">							
							Swal.fire({
								title: "Sukses!",
								text: "'.$message.'",
								type: "success",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href = "login.php";
							});
						</script>';
					} else {
						// Something is wrong with the sql statement.
						$message = "Pendaftaran gagal!";
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
					}
				}
				$stmt->close();
			} else {
				// Something is wrong with the sql statement.
				$message = "Pendaftaran gagal!";
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
			}
			$con->close();
		}
	?>

	<!-- login -->
	<div class="login-contect py-5">
		<div class="container py-xl-5 py-3">
			<div class="login-body">
				<div class="login p-4 mx-auto">
					<h5 class="text-center mb-4">Register Now</h5>
					<form method="POST">
						<div class="form-group">
							<label>Your Name</label>
							<input type="text" class="form-control" name="fullname" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" required>
						</div>
						<div class="form-group">
							<label class="mb-2">Password</label>
							<input type="password" class="form-control" name="password" required>
						</div>
						<div class="form-group">
							<label>Confirm Password</label>
							<input type="password" class="form-control" name="confirmpassword" required>
						</div>
						<div class="form-group">
							<label>No HP</label>
							<input type="text" class="form-control" name="hp" required>
						</div>
						<button type="submit" class="btn submit mb-4" name="register">Register</button>
						<p class="text-center">
							By clicking Register, I agree to your terms
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //login -->

	<?php
        include_once('footer.php');
    ?>	