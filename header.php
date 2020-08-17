<?php
require_once('./connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Ababil Travel</title>
	<!-- Meta tag Keywords -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="UTF-8" />
	<meta name="keywords" content="Ababil Travel" />
	<script>
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!--// Meta tag Keywords -->

	<!-- Custom-Files -->
	<link rel="stylesheet" href="css/bootstrap.css">
	<!-- Bootstrap-Core-CSS -->
	<link href="css/css_slider.css" type="text/css" rel="stylesheet" media="all">
	<!-- css slider -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<!-- Style-CSS -->
	<!-- <link href="css/font-awesome.min.css" rel="stylesheet"> -->
	<!-- Font-Awesome-Icons-CSS -->
	<!-- //Custom-Files -->
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
	<script src="system/vendor/jquery/jquery.js"></script>
</head>

<body>

	<!-- navigation -->
	<div class="main-top py-1" id="home">
		<div class="container">
			<div class="nav-content">
				<!-- logo -->
				<h1>
					<a id="logo" class="logo" href="index.php">
						<img src="images/logo.jpeg" width="78" alt="" class="img-fluid">
					</a>
				</h1>
				<!-- //logo -->
				<!-- nav -->
				<div class="nav_web-dealingsls">
					<nav>
						<label for="drop" class="toggle">Menu</label>
						<input type="checkbox" id="drop" />
						<ul class="menu">
							<li><a href="index.php">Home</a></li>
							<li><a href="tracking.php">Tracking</a></li>
							<li><a href="buy-ticket.php">Buy Ticket</a></li>
							<li>
								<a href="contact.php">Contact Us</a>
							</li>
							<li>
								<a href="login.php">
									&emsp;<span class="fa fa-sign-in mr-2"></span>
									<?= empty($_SESSION['email'])?'Login':$_SESSION['email'] ?>
									&emsp;
								</a>
							</li>
						</ul>
					</nav>
				</div>
				<!-- //nav -->
			</div>
		</div>
	</div>
	<!-- //navigation -->