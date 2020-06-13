<?php

// require_once('../connect.php');
require_once('header.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alamat_dari = $_POST['alamat_dari'];
    $alamat_ke = $_POST['alamat_ke'];
    $biaya = $_POST['biaya'];
    $query = $con->query("select * from biaya where id_lokasi_dari='$alamat_dari' and id_lokasi_ke='$alamat_ke'");
    $data = [];
    while ($key = $query->fetch_assoc()) {
        $data[] = $key;
    }
    if (count($data) <> 0) {
        echo "<script>alert('Data sudah ada');</script>";
    } else {
        if ($alamat_dari == '' or $alamat_dari == 0 or $alamat_ke == '' or $alamat_ke == 0 or $biaya == '' or $biaya == 0) {
            echo "<script>alert('Masukkan data dengan benar');</script>";
        } else {
            $query = $con->query("insert into biaya(id_lokasi_dari,id_lokasi_ke,biaya) values($alamat_dari,$alamat_ke,$biaya)");
            echo "<script>alert('Data berhasil ditambahkan');</script>";
            echo "<script type='text/javascript'>window.location.href = 'biayaalamat.php'; </script>";
        }
    }
}

$root  = "http://" . $_SERVER['HTTP_HOST'];
$root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
?>

<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
        <section class="py-5">
            <div class="row">
                <!-- Form Elements -->
                <div class="col-lg mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="h6 text-uppercase mb-0">Tambah biaya alamat</h3>
                        </div>
                        <div class="card-body row">
                            <div class="col-md">
                                <form class="form-horizontal" method="POST">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="alamat_dari">Alamat dari</label>
                                        <div class="col-md">
                                            <select name="alamat_dari" class="form-control" id="alamat_dari" required>
                                                <option value=""> Pilih alamat dari </option>
                                                <?php $query = $con->query("select * from alamat where remove='1'");
                                                while ($key = $query->fetch_assoc()) { ?>
                                                    <option value="<?= $key['id_alamat'] ?>"><?= $key['nama_lokasi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="alamat_ke">Alamat ke</label>
                                        <div class="col-md">
                                            <select name="alamat_ke" class="form-control" id="alamat_ke" required>
                                                <option value="0"> Pilih alamat ke </option>
                                                <?php $query = $con->query("select * from alamat");
                                                while ($key = $query->fetch_assoc()) { ?>
                                                    <option value="<?= $key['id_alamat'] ?>"><?= $key['nama_lokasi'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="line"></div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="biaya">Biaya</label>
                                        <div class="col-md">
                                            <input type="number" name="biaya" class="form-control" id="biaya" placeholder="Rp. 0000" required>
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
                            <div class="col-md-3 pt-3 border bg-gray-300 rounded">
                                Alamat ada yang sudah ada
                                <ul id="al">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="js/axios.min.js"></script>
    <script>
        $('#alamat_dari').change(function() {
            var id = $(this).val();
            var html = '';
            axios.get("<?= $root ?>api-lokasi.php?id=" + id).then(function(response) {
                response.data.map(function(value) {
                    console.log(value);
                    html += "<li style='color:rgb(255,0,0)'>" + value.nama_lokasi + '</li>';
                })
                $('#al').html(html);
            });
        });
        $('#alamat_ke').change(function() {
            let alamat_dari = $('#alamat_dari').val();
            let alamat_ke = $(this).val();

            axios.get("<?= $root ?>api-lokasi.php?id=" + alamat_dari).then(function(response) {
                response.data.map(function(value) {
                    console.log(value);
                    if (alamat_ke != '') {
                        if (value.id_lokasi_ke == alamat_ke) {
                            $('#alamat_ke').val('0');
                            alert("data sudah ada");
                        }
                    }
                })
            });
        });
    </script>
    <?php
    include_once('footer.php');
    ?>