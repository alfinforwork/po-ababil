<?php
if ($_GET['id']) {

    require_once('../connect.php');
    @$id = $_GET['id'];
    if ($con->query("UPDATE alamat set active='1' where id_alamat='$id'")) {
        echo "<script>alert('Data berhasil diaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'alamat.php'; </script>";
    } else {
        echo "<script>alert('Data gagal diaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'alamat.php'; </script>";
    }
} else {
    header('Location:alamat.php');
}
