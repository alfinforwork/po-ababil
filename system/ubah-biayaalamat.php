<?php

require_once('../connect.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $biaya = $_POST['biaya'];
    $sql = "UPDATE biaya set biaya='$biaya' where id_biaya='$_GET[id]' ";
    if ($con->query($sql)) {
        echo "<script>alert('Data berhasil diubah');</script>";
        echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
    } else {
        echo "<script>alert('Data gagal diubah');</script>";
    }
}

require_once('header.php');
?>

<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
        <section class="py-5">
            <div class="row">
                <!-- Form Elements -->
                <div class="col-lg mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="h6 text-uppercase mb-0">Ubah biaya alamat</h3>
                        </div>
                        <div class="card-body ">
                            <form class="form-horizontal" method="POST">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="biaya">Biaya</label>
                                    <div class="col-md">
                                        <?php
                                        $query = $con->query("SELECT * from biaya where id_biaya='$_GET[id]'");
                                        $data = $query->fetch_assoc();
                                        ?>
                                        <input type="text" name="biaya" class="form-control" id="biaya" placeholder="Rp. 100,000" value="<?= $data['biaya'] ?>" required>
                                    </div>
                                </div>

                                <div class="line"></div>
                                <div class="form-group row">
                                    <div class="col-md-9 ml-auto">
                                        <button type="submit" name="addMobil" class="btn btn-primary">Save</button>
                                        <a href="biayaalamat.php" class="btn btn-secondary">Cancel</a>
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