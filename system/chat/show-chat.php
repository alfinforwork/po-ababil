<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @$username = @$_POST['username'];
} else {
    @$username = @$_GET['username'];
}
// echo $username;
$query = $con->prepare(
    "SELECT 
    chat_detail.id_chat_detail,
	chat.username,
    chat_detail.chat,
	chat_detail.id_chat_from,
    chat_detail.id_chat_to,
    chat_detail.created_at 
    from chat_detail
    RIGHT JOIN chat ON chat_detail.id_chat_from = chat.username
    where
    chat_detail.id_chat_from = '$username' or chat_detail.id_chat_to ='$username'
    order by (chat_detail.created_at) DESC
    "
);
$query->execute();
$d = $query->get_result();
$data = array();
foreach ($d as $k) {
    $data[] = $k;
}

echo json_encode($data);

// $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? AND status=?');
// $stmt->execute([$email, $status]);
// $user = $stmt->fetch();
// // or
// $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email AND status=:status');
// $stmt->execute(['email' => $email, 'status' => $status]);
// $user = $stmt->fetch();
