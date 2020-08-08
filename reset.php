	<?php

	require_once('header.php');
	require_once('connect.php');

	//Import PHPMailer classes into the global namespace
	require_once('vendor/autoload.php');

	use PHPMailer\PHPMailer\PHPMailer;

	if (isset($_POST['reset'])) {
		// Now we check if the data from the reset form was submitted, isset() will check if the data exists.
		$email = $_POST['email'];

		if (empty($email)) {
			// Could not get the data that should have been sent.
			die('Please fill both the email field!');
		}

		if ($stmt = $con->prepare('SELECT id_pelanggan, email FROM pelanggan WHERE email = ?')) {
			$stmt->bind_param('s', $email);
			$stmt->execute();
			$stmt->store_result();

			// Account exists
			if ($stmt->num_rows > 0) {
				$expFormat 	= mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
				$expDate 	= date("Y-m-d H:i:s", $expFormat);
				$key 			= password_hash($email, PASSWORD_DEFAULT);

				if ($stmt = $con->prepare("INSERT INTO password_reset (`email`, `key`, `expired`) VALUES (?, ?, ?)")) {
					$stmt->bind_param('sss', $email, $key, $expDate);
					$stmt->execute();

					// ==================================================================

					//Create a new PHPMailer instance
					$mail = new PHPMailer;

					//Tell PHPMailer to use SMTP
					$mail->isSMTP();

					//Enable SMTP debugging
					// 0 = off (for production use)
					// 1 = client messages
					// 2 = client and server messages
					$mail->SMTPDebug = 2;

					//Set the hostname of the mail server
					$mail->Host = 'smtp.mail.yahoo.com';
					// use
					// $mail->Host = gethostbyname('smtp.gmail.com');
					// if your network does not support SMTP over IPv6

					//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
					$mail->Port = 465;

					//Set the encryption system to use - ssl (deprecated) or tls
					$mail->SMTPSecure = 'ssl';

					//Whether to use SMTP authentication
					$mail->SMTPAuth = true;

					//Username to use for SMTP authentication - use full email address for gmail
					$mail->Username = "csababil@yahoo.com";

					//Password to use for SMTP authentication
					$mail->Password = "bojongbogo2013";

					//Set who the message is to be sent from
					$mail->setFrom('csababil@yahoo.com', 'Admin PO Ababil Travel');

					//Set who the message is to be sent to
					$mail->addAddress($email, 'Pelanggan');

					//Set the subject line
					$mail->Subject = 'Reset Password Ababil Travel';


					//Read an HTML message body from an external file, convert referenced images to embedded,
					//convert HTML into a basic plain-text alternative body						
					$mail->Body = 'Silahkan klik link berikut untuk reset password : 
http://localhost/po-ababil/confirm-reset.php?key=' . $key . '

Link ini belaku sampai : ' . $expDate;

					//Replace the plain text body with one created manually
					$mail->AltBody = '';

					//Attach an image file
					//$mail->addAttachment('sppd.sql.enc');

					//send the message, check for errors
					if (!$mail->send()) {
						echo "Mailer Error: " . $mail->ErrorInfo;
					} else {
						$message = "Link reset password sudah dikirim ke email !";
						echo '<script type="text/javascript">							
									Swal.fire({
										title: "Sukses!",
										text: "' . $message . '",
										type: "success",
										timer: 2000,
										showConfirmButton: false
									}).then(function(result) { 
										window.location.href = "index.php";
									});
								</script>';
					}

					//Section 2: IMAP
					//IMAP commands requires the PHP IMAP Extension, found at: https://php.net/manual/en/imap.setup.php
					//Function to call which uses the PHP imap_*() functions to save messages: https://php.net/manual/en/book.imap.php
					//You can use imap_getmailboxes($imapStream, '/imap/ssl', '*' ) to get a list of available folders or labels, this can
					//be useful if you are trying to get this working on a non-Gmail IMAP server.
					function save_mail($mail)
					{
						//You can change 'Sent Mail' to any other folder or tag
						$path = "{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail";

						//Tell your server to open an IMAP connection using the same username and password as you used for SMTP
						$imapStream = imap_open($path, $mail->Username, $mail->Password);

						$result = imap_append($imapStream, $path, $mail->getSentMIMEMessage());
						imap_close($imapStream);

						return $result;
					}

					// ==================================================================


				} else {
					// Something is wrong with the sql statement.
					$message = "Error reset password!";
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
			} else {
				$message = "Email tidak terdaftar !";
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
		$stmt->close();
		$con->close();
	}
	?>

	<!-- login -->
	<div class="login-contect py-5">
		<div class="container py-xl-5 py-3">
			<div class="login-body">
				<div class="login p-4 mx-auto">
					<h5 class="text-center mb-4">Reset Password</h5>
					<form method="POST">
						<div class="form-group">
							<label>Email</label>
							<input type="text" class="form-control" name="email" required>
						</div>
						<button type="submit" name="reset" class="btn submit mb-4">Reset</button>
						<p class="forgot-w3ls text-center mb-3">
							<a href="login.php" class="text-da">Back to Login Form</a>
						</p>
						<p class="account-w3ls text-center text-da">
							Don't have an account?
							<a href="register.php">Create one now</a>
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