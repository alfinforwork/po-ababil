
<?php
require_once('../connect.php');
$latitude      = $_POST['latitude'];
$longitude      = $_POST['longitude'];
$id            = $_POST['id'];

$stmt = $con->prepare('SELECT id_sopir FROM lokasi WHERE id_sopir = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
   $stmt = $con->prepare('UPDATE lokasi SET latitude=?, longitude=? WHERE id_sopir=?');
   $stmt->bind_param('ssi', $latitude, $longitude, $id);
   $stmt->execute();
   echo json_encode($_POST);
} else {
   $stmt = $con->prepare('INSERT INTO lokasi (id_sopir, latitude, longitude) VALUES (?, ?, ?)');
   $stmt->bind_param('iss', $id, $latitude, $longitude);
   $stmt->execute();
   echo json_encode($_POST);
}

?>
