<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once('./connect.php');
$id_sopir = @$_GET['id_sopir'];
$id_mobil = @$_GET['id_mobil'];
$query = $con->query("SELECT * from lokasi where id_sopir='$id_sopir' and id_mobil='$id_mobil' limit 1 ");

echo json_encode($query->fetch_object());
