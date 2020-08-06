<?php
if ($_GET['id']) {

    require_once('../connect.php');
    @$id = $_GET['id'];
    if ($con->query("UPDATE alamat set active='0' where id_alamat='$id'")) {
        echo "<script>alert('Data berhasil dinonaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'alamat.php'; </script>";
    } else {
        echo "<script>alert('Data gagal dinonaktifkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'alamat.php'; </script>";
    }
} else {
    header('Location:alamat.php');
}
