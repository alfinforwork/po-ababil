<?php
include 'connect.php';
$waktu = $_GET['waktu'];
$tanggal = $_GET['tanggal'];

$stmt = $con->prepare("SELECT no_kursi from pemesanan where tgl_berangkat='$tanggal' and waktu='$waktu' ");
// $stmt->bind_param('ss',$waktu,$tanggal);
$stmt->execute();
$d = $stmt->get_result();
$data = array();
foreach ($d as $k) {
    $data[] = $k;
}

echo json_encode($data);