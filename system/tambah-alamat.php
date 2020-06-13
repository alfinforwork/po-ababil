<?php

require_once('header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alamat  = $_POST['alamat'];
    if ($alamat == '' or $alamat == ' ') {
        echo "<script>alert('Masukkan data dengan benar');</script>";
    } else {
        $con->query("insert into alamat(nama_lokasi) values('$alamat')");
        echo "<script>alert('Data berhasil ditambahkan');</script>";
        echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
    }
}
?>

<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
        <section class="py-5">
            <div class="row">
                <!-- Form Elements -->
                <div class="col-lg-12 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="h6 text-uppercase mb-0">Tambah alamat</h3>
                        </div>
                        <div class="card-body">
                            <form class="form-horizontal" method="POST">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="alamat">Alamat</label>
                                    <div class="col-md-3">
                                        <input type="text" name="alamat" class="form-control" id="alamat" required>
                                    </div>
                                </div>

                                <div class="line"></div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <button type="submit" name="addMobil" class="btn btn-primary">Save</button>
                                        <a href="alamat.php" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
    include_once('footer.php');
    ?>