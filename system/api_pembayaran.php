<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST = json_decode(file_get_contents("php://input"), true);
    $order_id = $_POST['order_id'];
    $pdf_url = $_POST['pdf_url'];
    $id = $_GET['id'];
    $query = $con->query("UPDATE pemesanan SET id_pembayaran='$order_id',url_panduan_pembayaran='$pdf_url' WHERE kd_pemesanan= '$id' ");
    if ($query) {
        echo json_encode(['status' => true, 'message' => 'Berhasil']);
    } else {
        echo json_encode(['status' => true, 'message' => 'Berhasil']);
    }
}
