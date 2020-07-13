<?php
session_start();

// If the user is logged in redirect to the dashboard page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../login.php');
	exit();
} else {
	require_once('./../connect.php');
}
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>CPANEL | Ababil Travel</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="all,follow">
	<!-- Bootstrap CSS-->
	<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
	<!-- Font Awesome CSS-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<!-- Google fonts - Popppins for copy-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,800">
	<!-- orion icons-->
	<link rel="stylesheet" href="css/orionicons.css">
	<!-- theme stylesheet-->
	<link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
	<!-- Custom stylesheet - for your changes-->
	<link rel="stylesheet" href="css/custom.css">
	<!-- Favicon-->
	<!-- <link rel="shortcut icon" href="img/favicon.png"> -->
	<!-- Tweaks for older IEs-->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

	<script src="vendor/jquery/jquery.js"></script>

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.css" />

	<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/r-2.2.3/datatables.min.js"></script>

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>

</head>

<body>
	<!-- navbar-->
	<header class="header">
		<nav class="navbar navbar-expand-lg px-4 py-2 bg-white shadow">
			<a href="#" class="sidebar-toggler text-gray-500 mr-4 mr-lg-5 lead">
				<i class="fas fa-align-left"></i>
			</a>
			<a href="../index.php" target="_BLANK" class="navbar-brand font-weight-bold text-uppercase text-base">Ababil Travel</a>
			<ul class="ml-auto d-flex align-items-center list-unstyled mb-0">
				<?php if ($_SESSION['level'] == 'pelanggan') { ?>
					<li class="nav-itemdropdown ml-auto">
						<a href="#" id="user-chat" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Chat
							<span id="notif"></span>
						</a>
						<div aria-labelledby="user-chat" class="dropdown-menu w-25 mr-4" onclick="">
							<form action="" id="chat-form" class="p-2">

								<div class="form-group">
									<div class="input-group">
										<input type="text" name="chat-edit" id="chat-edit" class="form-control" required>
										<div class="input-group-append">
											<!-- <span class="input-group-text" id="basic-addon2">@example.com</span> -->
											<button type="submit" class="btn btn-primary">Kirim</button>
										</div>
									</div>
								</div>
								<div class="dropdown-divider"></div>
								<div class="container" style="height: 200px;overflow: auto">
									<div id="show-chat">



									</div>
								</div>

							</form>
							<span class="p-2 badge badge-dark" style="width: 90%;margin: 0% 5%">Chat</span>
						</div>
					</li>
				<?php } ?>
				<li class="nav-item dropdown ml-auto">
					<a id="userInfo" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">
						<?php
						$id = $_SESSION['id'];
						$stmt = $con->prepare('SELECT avatar FROM pelanggan WHERE id_pelanggan = ? LIMIT 1');
						$stmt->bind_param('i', $id);
						$stmt->execute();
						$stmt->store_result();
						$stmt->bind_result($avatar);
						$stmt->fetch();
						?>
						<img src="<?= !empty($avatar) ? "../avatar/$avatar" : 'img/avatar-6.jpg'  ?>" alt="Jason Doe" style="width: 2.5rem;height: 2.5rem;" class="img-fluid rounded-circle shadow">
					</a>
					<div aria-labelledby="userInfo" class="dropdown-menu">
						<a href="#" class="dropdown-item">
							<?php
							$id = $_SESSION['id'];
							if ($_SESSION['level'] == 'pelanggan') {
								$stmt = $con->prepare('SELECT email FROM pelanggan WHERE id_pelanggan = ? LIMIT 1');
							} else if ($_SESSION['level'] == 'sopir') {
								$stmt = $con->prepare('SELECT email FROM sopir WHERE id_sopir = ? LIMIT 1');
							} else {
								$stmt = $con->prepare('SELECT email FROM `admin` WHERE id_admin = ? LIMIT 1');
							}
							$stmt->bind_param('i', $id);
							$stmt->execute();
							$stmt->store_result();
							$stmt->bind_result($email);
							$stmt->fetch();
							?>
							<p class="d-block"><?= $email ?></p>
						</a>
						<div class="dropdown-divider"></div>
						<?php
						if ($_SESSION['level'] == 'pelanggan') {
							echo '<a href="detail-pelanggan.php?id=' . $id . '" class="dropdown-item">Profile</a>
								<div class="dropdown-divider"></div>';
						}
						?>
						<a href="../logout.php" class="dropdown-item">Logout</a>
					</div>
				</li>
			</ul>
		</nav>
	</header>
	<div class="d-flex align-items-stretch">
		<!-- SIDEBAR -->
		<div id="sidebar" class="sidebar py-3">
			<div class="text-gray-400 text-uppercase px-3 px-lg-4 py-4 font-weight-bold small headings-font-family">
				MENU UTAMA
			</div>
			<?php
			$uri = $_SERVER['REQUEST_URI'];
			?>
			<ul class="sidebar-menu list-unstyled">
				<li class="sidebar-list-item">
					<a href="index.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "index") == true) echo "active"; ?>">
						<i class="o-home-1 mr-3 text-gray icon"></i><span>Home</span>
					</a>
				</li>
				<li class="sidebar-list-item">
					<a href="tiket.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "tiket") == true) echo "active"; ?>">
						<i class="fas fa-receipt mr-3 text-gray icon"></i><span>Tiket</span>
					</a>
				</li>
				<?php
				if ($_SESSION['level'] == 'admin') { ?>
					<li class="sidebar-list-item">
						<a href="pelanggan.php" class="sidebar-link text-muted 
								<?php if (strpos($uri, "pelanggan") == true) echo "active" ?>">
							<i class=" fas fa-users mr-3 text-gray icon"></i><span>Pelanggan</span>
						</a>
					</li>

					<li class="sidebar-list-item">
						<a href="biayaalamat.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "biayaalamat") == true or strpos($uri, "alamat") == true) echo "active"; ?>">
							<i class="fas fa-address-book mr-3 text-gray icon"></i><span>Biaya</span>
						</a>
					</li>
				<?php } ?>
				<li class="sidebar-list-item">
					<a href="sopir.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "sopir") == true) echo "active"; ?>">
						<i class="fas fa-user-cog mr-3 text-gray icon"></i><span>Sopir</span>
					</a>
				</li>
				<li class="sidebar-list-item">
					<a href="mobil.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "mobil") == true) echo "active"; ?>">
						<i class="fas fa-bus mr-3 text-gray icon"></i><span>Mobil</span>
					</a>
				</li>
				<?php
				if ($_SESSION['level'] == 'sopir') {
					echo '
					<li class="sidebar-list-item">
						<a href="tracking.php" class="sidebar-link text-muted';
					if (strpos($uri, "tracking") == true) {
						echo 'active';
					}
					echo '">
							<i class="fas fa-street-view mr-3 text-gray icon"></i><span>Tracking</span>
						</a>
					</li>';
				}
				?>
				<li class="sidebar-list-item">
					<a href="jadwal.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "jadwal") == true) echo "active"; ?>">
						<i class="fas fa-clock mr-3 text-gray icon"></i><span>Jadwal</span>
					</a>
				</li>
				<li class="sidebar-list-item">
					<a href="rekening.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "rekening") == true) echo "active"; ?>">
						<i class="fas fa-credit-card mr-3 text-gray icon"></i><span>Rekening</span>
					</a>
				</li>
				<?php if ($_SESSION['level'] == 'admin') { ?>
					<li class="sidebar-list-item">
						<a href="../system/chat.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "chat") == true) echo "active"; ?>">
							<i class="fas fa-credit-card mr-3 text-gray icon"></i><span>Pesan</span>
						</a>
					</li>
				<?php } ?>
				<li class="sidebar-list-item">
					<a href="bantuan.php" class="sidebar-link text-muted 
						<?php if (strpos($uri, "bantuan") == true) echo "active"; ?>">
						<i class="fas fa-question-circle mr-3 text-gray icon"></i><span>Bantuan</span>
					</a>
				</li>
			</ul>
		</div>
		<!-- END SIDEBAR -->
		<?php
		$root  = "https://" . $_SERVER['HTTP_HOST'];
		$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
		?>

		<?php if ($_SESSION['level'] == 'pelanggan') { ?>
			<script>
				$(document).ready(function() {
					jQuery('.dropdown-toggle').on('click', function(e) {
						$(this).next().toggle();
					});
					jQuery('.dropdown-menu.keep-open').on('click', function(e) {
						e.stopPropagation();
					});

					if (1) {
						$('body').attr('tabindex', '0');
					} else {
						alertify.confirm().set({
							'reverseButtons': true
						});
						alertify.prompt().set({
							'reverseButtons': true
						});
					}

					// Show Chat
					setInterval(() => {
						var html = '';
						console.log('hello');
						$.ajax({
							type: "get",
							url: "<?= $root . 'chat/user/show-chat.php' ?>",
							dataType: "json",
							success: function(res) {

								$.each(res, function(indexInArray, valueOfElement) {
									if (valueOfElement.username != 'admin') {
										if (valueOfElement.is_baca_user == 1) {
											$('#notif').html('<span class="badge badge-danger" id="notif">New</span>');
											return false;

										} else {
											$('#notif').html('');

										}
									}
								});
								// 
								$.each(res, function(indexInArray, valueOfElement) {
									var username = valueOfElement.username == "admin" ? '<span class="badge badge-dark w-100">admin</span>' : '<span class="badge badge-info w-100">' + valueOfElement.username + '</span>';
									html +=
										'<div style="display: flex;flex-direction: column " class="border-bottom p-2">' +
										'<div style="flex: 1;display: flex;flex-direction: row ">' +
										'<div style="width: 20%"><span class="badge badge-primary">Nama</span></div>' +
										'<div style="width: 70%">' + username + '</div>';
									if (valueOfElement.username != "admin") {
										html += '<div style="width: 5%"><button type="button" class="badge badge-danger" onclick="delete_chat(' + valueOfElement.id_chat_detail + ')">Hapus</button></div>';

									}
									html += '</div>' +
										'<div style="flex: 1;display: flex;flex-direction: row ">' +
										'<div style="width: 20%"><span class="badge badge-secondary">Chat</span></div>' +
										'<div style="width: 80%">' + valueOfElement.chat + '</div>' +
										'</div>' +
										'</div>';
									console.log(valueOfElement);
								});
								$('#show-chat').html(html);
							}
						});
					}, 2000);

					// Send Chat
					$('#chat-form').on('submit', function(e) {
						e.preventDefault();
						var data = $(this).serialize();
						$.ajax({
							type: "post",
							url: "<?= $root . 'chat/user/send-chat.php' ?>",
							data: data,
							dataType: "json",
							success: function(res) {}
						});

						$('#chat-edit').val('');

					})
				});

				function delete_chat(id) {
					var konfirmasi = confirm("Apakah anda ingin menghapus pesan ini ?");
					if (konfirmasi) {
						$.post('<?= $root . 'chat/delete-chat.php' ?>', {
							id_chat_detail: id
						}, function(data) {
							alert("Berhasil dihapus");
						});
					}
				}
			</script>
		<?php } ?>