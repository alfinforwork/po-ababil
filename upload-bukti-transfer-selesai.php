<?php
require_once('./connect.php');
$id = $_GET['id'];
$data = $con->query("UPDATE pemesanan SET pemesanan.status='sudah dibayar' where kd_pemesanan='$id' ");
header("Location:upload-bukti-transfer.php?id=$id");
