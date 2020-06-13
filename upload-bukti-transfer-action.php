<?php
include "connect.php";
$id = $_POST['id_pemesanan'];
$stmt = $con->query("DELETE from pemesanan where kd_pemesanan = '$id' ");
// $stmt->execute;
