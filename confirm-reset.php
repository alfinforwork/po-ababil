	<?php

		require_once('header.php');
		require_once('connect.php');

		if (isset($_POST['change'])){
			$new		= $_POST['newpassword'];
			$confirm	= $_POST['confirmpassword'];
			$email	= $_POST['email'];

			// Now we check if the data from the login form was submitted, isset() will check if the data exists.
			if (!isset($new, $confirm, $email)) {
				// Could not get the data that should have been sent.
				die ('Please fill both the new and confirm new password and email field!');
			}

			if ($stmt = $con->prepare('SELECT `id_pelanggan`, `email` FROM pelanggan WHERE `email` = ?')) {
				$stmt->bind_param('s', $email);
				$stmt->execute();
				$stmt->store_result();

				if ($stmt->num_rows > 0) {
					// Character Length Check
					if (strlen($new) < 5) {
						die ('Password must be 5 characters long!');
					}

					if ($new != $confirm) {
						die ('Confirm password not the same !');
					}

					$stmt = $con->prepare('UPDATE pelanggan SET `password`=? WHERE `email`=?');
					$pwd 	= password_hash($new, PASSWORD_DEFAULT);
					$stmt->bind_param('ss', $pwd, $email);
					$stmt->execute();
					$message = "Berhasil mengubah password !";
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
						return false;
				} else {
					$message = "Error reset password!";
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
						return false;
					
				}
			} else {
				$message = "Email tidak terdaftar !";
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
						return false;
			}
			$stmt->close();
			$con->close();
		}

		if (!empty($_GET['key'])){
			$key = $_GET['key'];
			if ($stmt = $con->prepare('SELECT `id_reset`, `email`, `key`, `expired` FROM password_reset WHERE `key` = ?')) {
				$stmt->bind_param('s', $key);
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result($id, $email, $key, $expDate);
				$stmt->fetch();

				// Key exists
				if ($stmt->num_rows > 0) {					
					$expFormat 	= mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y"));
					$curDate 	= date("Y-m-d H:i:s", $expFormat);
					if ($expDate < $curDate) {
						$message = "link expired";
						echo "<script type='text/javascript'>
									alert('$message');
									window.location.href = 'reset.php';
								</script>";
					} else {
						echo '
						<div class="login-contect py-5">
							<div class="container py-xl-5 py-3">
								<div class="login-body">
									<div class="login p-4 mx-auto">
										<h5 class="text-center mb-4">Change Password</h5>
										<form method="POST">
											<div class="form-group">
												<label>New Password</label>
												<input type="password" class="form-control" name="newpassword" required>
											</div>
											<div class="form-group">
												<label class="mb-2">Confirm New Password</label>
												<input type="password" class="form-control" name="confirmpassword" required>
												<input type="hidden" class="form-control" name="email" value="'.$email.'">
											</div>
											<button type="submit" name="change" class="btn submit mb-4">Change</button>
										</form>
									</div>
								</div>
							</div>
						</div>';
					}
				} else {
					$message = "Link tidak ditemukan !";
					echo "<script type='text/javascript'>
								alert('$message');
								window.location.href = 'login.php';
							</script>";
				}
			}
			$stmt->close();
			$con->close();
		}
	?>

	<?php
		include_once('footer.php');
	?>