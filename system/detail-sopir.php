<?php
require_once('header.php');
// require_once('../connect.php');

$id 	= $_GET['id'];

if (isset($_POST['updateSopir'])){
	$sopir 		= $_POST['fullname'];
	$password 	= $_POST['password'];
	$alamat		= $_POST['alamat'];
	$hp 			= $_POST['hp'];

	// Mengecek apakah ada masukkan fullname dan email
	if (!isset($sopir)) {
		// Menampilkan pesan tidak boleh kosong.
		die ('Silahkan isi nama lengkap dan email !');
	}
	// Memastikan tidak ada input yang kosong.
	if (empty($sopir)) {
		// Nama lengkap atau email masih kosong.
		die ('Nama lengkap atau email masih kosong !');
	}

	if (empty($password)){
		$stmt = $con->prepare('UPDATE sopir SET sopir=?, alamat=?, hp=? WHERE id_sopir=?');
		$stmt->bind_param('sssi', $sopir, $alamat, $hp, $id);
	} else {
		// Character Length Check
		if (strlen($password) < 5) {
			die ('Password must be 5 characters long!');
		}
		

		$stmt = $con->prepare('UPDATE sopir SET sopir=?, password=?, alamat=?, hp=? WHERE id_sopir=?');
		$pwd = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bind_param('ssssi', $sopir, $pwd, $alamat, $hp, $id);
	}

	if ($stmt) {		
		$stmt->execute();
		$message = "Berhasil mengubah data sopir !";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "'.$message.'",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "sopir.php";
						});
					</script>';
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal mengubah data sopir!";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Gagal!",
							text: "'.$message.'",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "sopir.php";
						});
					</script>';
		return false;
	}

	$stmt->close();
	$con->close();
}

$stmt = $con->prepare('SELECT * FROM sopir WHERE id_sopir = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $sopir, $email, $password, $alamat, $hp);
$stmt->fetch();

?>

<div class="page-holder w-100 d-flex flex-wrap">
	<div class="container-fluid px-xl-5">
		<section class="py-5">
			<div class="row">
				<!-- Form Elements -->
				<div class="col-lg-12 mb-5">
					<div class="card">
						<div class="card-header">
							<h3 class="h6 text-uppercase mb-0">Detail Sopir</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nama Lengkap</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="fullname" value="<?=$sopir;?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Email</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="email" value="<?=$email;?>" disabled="">
									</div>
								</div>
								<div class="line"></div>
								<?php
									if ($_SESSION['level'] == 'admin' | $_SESSION['level'] == 'sopir'){
									echo '<div class="form-group row">
												<label class="col-md-3 form-control-label">Password</label>
												<div class="col-md-4">
													<input type="password" class="form-control" name="password" value="">
													<small class="form-text text-muted ml-3">Biarkan kosong jika tidak ingin diubah.</small>
												</div>
											</div>
											<div class="line"></div>';
									}
								?>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">No HP</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="hp" value="<?=$hp;?>" required>
										<input type="hidden" class="form-control" name="level" value="sopir">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Alamat</label>
									<div class="col-md-8">
										<input type="text" class="form-control" name="alamat" value="<?=$alamat;?>">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<?php
											$sid 	= $_SESSION['id'];
											if ($_SESSION['level'] == 'sopir'){
												if ($id == $sid){
													echo '<button type="submit" class="btn btn-primary" name="updateSopir">Edit</button>';
												}
											} else if ($_SESSION['level'] == 'admin'){
												echo '<button type="submit" class="btn btn-primary" name="updateSopir">Edit</button>';
											}
										?>
										<a href="sopir.php" class="btn btn-secondary">Back</a>
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