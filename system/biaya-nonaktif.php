<?php
if ($_GET['id']) {

    require_once('../connect.php');
    @$id = $_GET['id'];
    if ($con->query("UPDATE biaya set active='0' where id_biaya='$id'")) {
        echo "<script>alert('Data berhasil dinonaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
    } else {
        echo "<script>alert('Data gagal dinonaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
    }
} else {
    header('Location:biayaalamat.php');
}
