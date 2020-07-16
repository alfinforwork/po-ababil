<?php
require_once('header.php');
// require_once('../connect.php');

$id = $_GET['id'];
$sid = $_SESSION['id'];
if ($_SESSION['level'] == 'pelanggan') {
	if ($id != $sid) {
		echo '<script>			
			window.location.href = "detail-pelanggan.php?id=' . $sid . '";
		</script>';
	}
}

if (isset($_POST['updatePelanggan'])) {
	$pelanggan 	= $_POST['pelanggan'];
	$password 	= $_POST['password'];
	$tmp_lahir	= $_POST['tmp_lahir'];
	$tgl_lahir	= $_POST['tgl_lahir'];
	$alamat		= $_POST['alamat'];
	$hp 		= $_POST['hp'];

	$nama_avatar = $_FILES["avatar"]["name"];
	$data_avatar = $_FILES['avatar']['tmp_name'];


	// Mengecek apakah ada masukkan pelanggan dan email
	if (!isset($pelanggan)) {
		// Menampilkan pesan tidak boleh kosong.
		die('Silahkan isi nama lengkap dan email !');
	}
	// Memastikan tidak ada input yang kosong.
	if (empty($pelanggan)) {
		// Nama lengkap atau email masih kosong.
		die('Nama lengkap atau email masih kosong !');
	}
	if (move_uploaded_file($data_avatar, "./../avatar/$nama_avatar")) {
		$stmt = $con->prepare('UPDATE pelanggan SET avatar=? WHERE id_pelanggan=?');
		$stmt->bind_param('si', $nama_avatar, $id);
		$stmt->execute();
	}


	if (empty($password)) {
		$stmt = $con->prepare('UPDATE pelanggan SET pelanggan=?, tmp_lahir=?, tgl_lahir=?, alamat=?, hp=? WHERE id_pelanggan=?');
		$stmt->bind_param('sssssi', $pelanggan, $tmp_lahir, $tgl_lahir, $alamat, $hp, $id);
	} else {
		// Character Length Check
		if (strlen($password) < 5) {
			die('Password must be 5 characters long!');
		}

		$stmt = $con->prepare('UPDATE pelanggan SET pelanggan=?, password=?, tmp_lahir=?, tgl_lahir=?, alamat=?, hp=? WHERE id_pelanggan=?');
		$pwd = password_hash($password, PASSWORD_DEFAULT);
		$stmt->bind_param('sssssssi', $pelanggan, $pwd, $tmp_lahir, $tgl_lahir, $alamat, $hp, $id);
	}

	if ($stmt) {
		$stmt->execute();
		$message = "Berhasil mengubah data pelanggan !";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Sukses!",
							text: "' . $message . '",
							type: "success",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "pelanggan.php";
						});
					</script>';
		return false;
	} else {
		// Something is wrong with the sql statement.
		$message = "Gagal edit data !";
		echo '<script type="text/javascript">							
						Swal.fire({
							title: "Gagal!",
							text: "' . $message . '",
							type: "error",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.location.href = "pelanggan.php";
						});
					</script>';
		return false;
	}

	$stmt->close();
	$con->close();
}

$stmt = $con->prepare('SELECT id_pelanggan,pelanggan,email,password,tmp_lahir,tgl_lahir,alamat,hp FROM pelanggan WHERE id_pelanggan = ? LIMIT 1');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $pelanggan, $email, $password, $tmp_lahir, $tgl_lahir, $alamat, $hp);
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
							<h3 class="h6 text-uppercase mb-0">Detail Pelanggan</h3>
						</div>
						<div class="card-body">
							<form class="form-horizontal" method="POST" enctype="multipart/form-data">
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Nama Lengkap</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="pelanggan" value="<?= $pelanggan; ?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Tempat Lahir</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="tmp_lahir" value="<?= $tmp_lahir; ?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Tanggal Lahir</label>
									<div class="col-md-4">
										<input type="date" class="form-control" name="tgl_lahir" value="<?= $tgl_lahir; ?>" required>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Email</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="email" value="<?= $email; ?>" disabled="">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Password</label>
									<div class="col-md-4">
										<input type="password" class="form-control" name="password" value="">
										<small class="form-text text-muted ml-3">Biarkan kosong jika tidak ingin diubah.</small>
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">No HP</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="hp" value="<?= $hp; ?>" required>
										<input type="hidden" class="form-control" name="level" value="pelanggan">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Alamat</label>
									<div class="col-md-8">
										<input type="text" class="form-control" name="alamat" value="<?= $alamat; ?>">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<label class="col-md-3 form-control-label">Foto</label>
									<div class="col-md-8">
										<input type="file" class="form-control" name="avatar" accept="image/gif, image/jpeg, image/png">
									</div>
								</div>
								<div class="line"></div>
								<div class="form-group row">
									<div class="col-md-9 ml-auto">
										<button type="submit" class="btn btn-primary" name="updatePelanggan">Edit</button>
										<a href="pelanggan.php" class="btn btn-secondary">Back</a>
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