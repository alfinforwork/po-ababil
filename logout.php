<?php
include "connect.php";
session_start();

$query = $con->prepare("UPDATE pelanggan set is_online=0 where email='$_SESSION[email]' ");
$query->execute();
session_destroy();


// Redirect to the login page:
header('Location: login.php');
