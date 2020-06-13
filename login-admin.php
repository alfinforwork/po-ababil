	<?php
    session_start();

    // If the user is logged in redirect to the dashboard page...
    if (isset($_SESSION['loggedin'])) {
        header('Location: system/index.php');
        exit();
    }

    require_once('header.php');
    require_once('connect.php');

    if (isset($_POST['login'])) {
        // Now we check if the data from the login form was submitted, isset() will check if the data exists.
        if (!isset($_POST['email'], $_POST['password'])) {
            // Could not get the data that should have been sent.
            die('Please fill both the email and password field!');
        }

        if ($_POST['level'] == 'pelanggan') {
            $stmt = $con->prepare('SELECT `id_pelanggan`, `password` FROM `pelanggan` WHERE `email` = ?');
        } else if ($_POST['level'] == 'sopir') {
            $stmt = $con->prepare('SELECT `id_sopir`, `password` FROM `sopir` WHERE `email` = ?');
        } else {
            $stmt = $con->prepare('SELECT `id_admin`, `password` FROM `admin` WHERE `email` = ?');
        }

        if ($stmt) {
            // Bind parameters (s = string, i = int, b = blob, etc), in our case the email is a string so we use "s"
            $stmt->bind_param('s', $_POST['email']);
            $stmt->execute();
            // Store the result so we can check if the account exists in the database.
            $stmt->store_result();
        }

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $password);
            $stmt->fetch();

            // Account exists, now we verify the password.
            // Note: remember to use password_hash in your registration file to store the hashed passwords.
            if (password_verify($_POST['password'], $password)) {
                // Verification success! User has loggedin!
                // Create sessions so we know the user is logged in, they basically act like cookies but remember the data on the server.
                session_regenerate_id();
                $_SESSION['loggedin']   = TRUE;
                $_SESSION['email']      = $_POST['email'];
                $_SESSION['level']        = $_POST['level'];
                $_SESSION['id']         = $id;
                $query = $con->prepare("UPDATE pelanggan set is_online=1 where email='$_POST[email]' ");
                $query->execute();
                header('Location: system/index.php');
            } else {
                //echo 'Incorrect password!';
                $message = "Password salah !";
                echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "' . $message . '",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
                return false;
            }
        } else {
            $message = "Email salah !";
            echo '<script type="text/javascript">							
						Swal.fire({
							title: "Peringatan!",
							text: "' . $message . '",
							type: "warning",
							timer: 2000,
							showConfirmButton: false
						}).then(function(result) { 
							window.history.back();
						});
					</script>';
            return false;
        }
        $stmt->close();
    }
    ?>

	<!-- login -->
	<div class="login-contect py-5">
	    <div class="container py-xl-5 py-3">
	        <div class="login-body">
	            <div class="login p-4 mx-auto">
	                <h5 class="text-center mb-4">Admin Login</h5>
	                <form method="POST">
	                    <div class="form-group">
	                        <label>Email</label>
	                        <input type="text" class="form-control" name="email" required>
	                    </div>
	                    <div class="form-group">
	                        <label class="mb-2">Password</label>
	                        <input type="password" class="form-control" name="password" required>
	                    </div>
	                    <input type="hidden" name="level" id="level" value="admin">
	                    <button type="submit" name="login" class="btn submit mb-4">Login</button>
	                </form>
	            </div>
	        </div>
	    </div>
	</div>
	<!-- //login -->

	<?php
    include_once('footer.php');
    ?>