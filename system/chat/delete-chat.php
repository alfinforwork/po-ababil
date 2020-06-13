<?php
require_once('../../connect.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    @$id_chat_detail = @$_POST['id_chat_detail'];
} else {
    @$id_chat_detail = @$_GET['id_chat_detail'];
}
$stmt = $con->query("DELETE FROM chat_detail WHERE id_chat_detail='$id_chat_detail' ");
