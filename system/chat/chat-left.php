<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../../connect.php');
$query = $con->prepare('SELECT chat.*,pelanggan.is_online FROM chat join pelanggan on chat.username=pelanggan.pelanggan where username <> "admin" GROUP BY username');
$query->execute();
$d = $query->get_result();
foreach ($d as $k) {
    $data[] = $k;
}

echo json_encode($data);
