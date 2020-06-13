<?php

require_once('../connect.php');
@$id = $_GET['id'];
if ($con->query("update biaya set remove=0 where id_biaya='$id'")) {
    echo "<script>alert('Data berhasil dihapus');</script>";
    echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
} else {
    echo "<script>alert('Data gagal dihapus');</script>";
    echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
}
