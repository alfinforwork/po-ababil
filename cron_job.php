<?php
require_once('./connect.php');
require_once('./vendor/autoload.php');


$midtransconfig = new \Midtrans\Config;
// $midtransconfig = new \Veritrans_Config;

// Set your Merchant Server Key
$midtransconfig::$serverKey = 'SB-Mid-server-270TWDakPQ0jjPb9OKRI92WS';
// $midtransconfig::$serverKey = 'Mid-server-gpPmFzoqdJ5sqzRJ_Z8j_r_t';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
$midtransconfig::$isProduction = false;
// $midtransconfig::$isProduction = true;
// Set sanitization on (default)
$midtransconfig::$isSanitized = true;
// Set 3DS transaction for credit card to true
$midtransconfig::$is3ds = true;


$query = $con->query('SELECT * FROM pemesanan where id_pembayaran IS NOT NULL AND id_pembayaran <> "" ');
$nomor = 0;
while ($data = $query->fetch_object()) {
    $datanotif = \Midtrans\Transaction::status($data->id_pembayaran);
    if ($datanotif->transaction_status == "expire" || $datanotif->transaction_status == "deny" || $datanotif->transaction_status == "cancel" || $datanotif->transaction_status == "refund" || $datanotif->transaction_status == "chargeback" || $datanotif->transaction_status == "failure") {
        $con->query("DELETE from pemesanan where kd_pemesanan='$data->kd_pemesanan' ");

        echo $data->id_pelanggan;
        echo "<pre>";
        print_r($datanotif);
        echo "</pre>";
        $nomor++;
    }
}
echo $nomor;
