<?php
require_once('../../../connect.php');
session_start();


// echo $_SESSION['email'];
$query = $con->query("select * from pelanggan where email='$_SESSION[email]' ");

$data = $query->fetch_assoc();


$query = $con->prepare(
    "SELECT 
    chat_detail.id_chat_detail,
	chat.username,
	chat.is_baca_user,
    chat_detail.chat,
	chat_detail.id_chat_from,
    chat_detail.id_chat_to,
    chat_detail.created_at 
    from chat_detail
    RIGHT JOIN chat ON chat_detail.id_chat_from = chat.username
    where
    chat_detail.id_chat_from = '$data[pelanggan]' or chat_detail.id_chat_to = '$data[pelanggan]'
    order by (chat_detail.created_at) DESC
    "
);

$query->execute();
$d = $query->get_result();

$datachat = array();
foreach ($d as $k) {
    $datachat[] = $k;
}

$stmt = $con->query("SELECT count(username) as jumlah from chat where username='$data[pelanggan]' ");
$tes = $stmt->fetch_assoc();
// echo $tes['jumlah'];
if ($tes['jumlah'] == 0) {
    $now = date("Y-m-d H:i:s");
    $stmt = $con->prepare("INSERT into chat(username,created_at) values('$data[pelanggan]', '$now') ");
    $stmt->execute();
}
echo json_encode($datachat);
