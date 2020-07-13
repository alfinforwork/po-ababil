<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../connect.php');
$id = @$_GET['id'];
$query = $con->query(
    "SELECT id_biaya,id_lokasi_ke,nama_lokasi from biaya
    join alamat on biaya.id_lokasi_ke = alamat.id_alamat
    where alamat.remove=1 and biaya.remove=1 and biaya.id_lokasi_dari='$id' "
);
$data = [];
while ($key = $query->fetch_assoc()) {
    $data[] = $key;
}

echo json_encode($data);
