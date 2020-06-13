	<?php
		session_start();
		include_once('header.php');

		if(isset($_POST['kirim'])){
			if ($stmt = $con->prepare('INSERT INTO pesan (nama, email, hp, pesan) VALUES (?, ?, ?, ?)')) {
				$nama	= $_POST['nama'];
				$email	= $_POST['email'];
				$hp		= $_POST['hp'];
				$pesan	= $_POST['pesan'];

				$stmt->bind_param('ssss', $nama, $email, $hp, $pesan);
				$stmt->execute();
				$stmt->close();
				$message = "Pesan berhasil dikirim!";
				echo '<script type="text/javascript">
							Swal.fire({
								title: "Sukses!",
								text: "'.$message.'",
								type: "success",
								timer: 2000,
								showConfirmButton: false
							}).then(function(result) { 
								window.location.href = "contact.php";
							});
						</script>';
			} else {
				// Something is wrong with the sql statement.
				$message = "Pesan gagal dikirim!";
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
   ?>

	<!-- contact -->
	<section class="ab-info-main py-5" id="contact">
		<div class="container py-xl-5 py-lg-3">
			<div class="title-section text-center mb-md-5 mb-4">
				<h3 class="w3ls-title mb-3">Contact <span>Us</span></h3>
				<p class="titile-para-text mx-auto">
					Bila ada pertanyaan silahkan hubungi kami.
				</p>
			</div>
			<div class="row contact-agileinfo pt-lg-4">				
				<!-- contact form -->
				<div class="col-lg-7 contact-right mt-lg-0 mt-5">
					<?php						
						if(!empty($_SESSION['email'])){
							$email = $_SESSION['email'];
							$stmt = $con->prepare('SELECT pelanggan, hp FROM pelanggan WHERE email = ? LIMIT 1');
							$stmt->bind_param('s', $email);
							$stmt->execute();
							$stmt->store_result();
							if ($stmt->num_rows > 0) {
								$stmt->bind_result($pelanggan, $hp);
								$stmt->fetch();
							} else {
								$email 		= "";
								$pelanggan 	= "";
								$hp 		= "";
							}
						} else {
							$email		= "";
							$pelanggan 	= "";
							$hp 		= "";
						}						
					?>

					<form action="#" method="post">
						<div class="row">
							<div class="col-lg-6 form-group pr-lg-2">
								<input type="text" class="form-control" name="nama" placeholder="Name" 
								value="<?=$pelanggan?>" required="">
							</div>
							<div class="col-lg-6 form-group pl-lg-2">
								<input type="email" class="form-control" name="email" placeholder="Email" 
								value="<?=$email?>" required="">
							</div>
						</div>
						<div class="form-group">
							<input type="text" class="form-control" name="hp" placeholder="Phone" 
							value="<?=$hp?>" required="">
						</div>
						<div class="form-group">
							<textarea name="pesan" class="form-control" placeholder="Message" required=""></textarea>
						</div>
						<button type="submit" name="kirim" class="btn submit-contact-main">Submit</button>
					</form>
				</div>
				

				<!-- contact form -->
				<!-- contact address -->
				<div class="col-md-5 address">
					<h3 class="footer-title mb-4 pb-lg-2">Our Address</h3>
					<div class="row address-info-w3ls">
						<div class="col-3 address-left">
							<img src="images/c2.png" alt="" class="img-fluid">
						</div>
						<div class="col-9 address-right mt-2">
							<h5 class="address mb-2">Address</h5>
							<p> Jl. Raya Jetaklengkong Wonopringgo, Pekalongan</p>
						</div>
					</div>
					<div class="row address-info-w3ls my-2">
						<div class="col-3 address-left">
							<img src="images/c3.png" alt="" class="img-fluid">
						</div>
						<div class="col-9 address-right mt-2">
							<h5 class="address mb-2">Email</h5>
							<p>
								<a href="mailto:ababil.trans@gmail.com"> ababil.trans@gmail.com</a>
							</p>
						</div>
					</div>
					<div class="row address-info-w3ls">
						<div class="col-3 address-left">
							<img src="images/c1.png" alt="" class="img-fluid">
						</div>
						<div class="col-9 address-right mt-2">
							<h5 class="address mb-2">Phone</h5>
							<p>+62 856 4749 5224</p>
						</div>
					</div>
				</div>
				<!-- //contact address -->
			</div>
		</div>
	</section>
	<!-- contact -->
	
    <?php
        include_once('footer.php');
    ?>