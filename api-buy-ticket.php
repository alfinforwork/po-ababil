<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

require_once('./connect.php');
$id = @$_GET['id'];
$query = $con->query("SELECT * from biaya join alamat on biaya.id_lokasi_ke = alamat.id_alamat where id_lokasi_dari = '$id' and biaya.remove=1 ");
$data = [];
while ($key = $query->fetch_assoc()) {
    $data[] = $key;
}
echo json_encode($data);
