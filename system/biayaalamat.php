<?php
require_once('header.php');
// require_once('./../connect.php');

?>
<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
        <section class="py-5">
            <div class="row">
                <div class="col-lg-12 mb-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-uppercase mb-0">Biaya alamat</h6>
                        </div>
                        <div class="card-body">
                            <div style=" display: flex;justify-content: space-between;">
                                <a href="tambah-biayaalamat.php" class="btn btn-primary">Tambah biaya</a>
                                <a href="alamat.php" class="btn btn-primary">alamat</a>
                            </div>
                            <hr>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Alamat dari</th>
                                            <th>Alamat ke</th>
                                            <th>biaya</th>
                                            <th style="width:15%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = $con->query(
                                            "SELECT
                                                id_biaya,
                                                alamatdari.nama_lokasi AS alamat_dari,
                                                alamatke.nama_lokasi AS alamat_ke,
                                                biaya.biaya
                                            from biaya
                                            join alamat as alamatdari on biaya.id_lokasi_dari = alamatdari.id_alamat
                                            join alamat as alamatke on biaya.id_lokasi_ke = alamatke.id_alamat
                                            WHERE biaya.remove='1' and alamatdari.remove='1' and alamatke.remove='1'
                                            "
                                        );
                                        $nomor = 1;
                                        while ($key = $query->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="text-center"><?= $nomor++ ?></td>
                                                <td><?= $key['alamat_dari'] ?></td>
                                                <td><?= $key['alamat_ke'] ?></td>
                                                <td><?= $key['biaya'] ?></td>
                                                <td class="text-center">
                                                    <a href="ubah-biayaalamat.php?id=<?= $key['id_biaya'] ?>">Ubah</a> |
                                                    <a href="javascript:void(0)" onclick="myklik('<?= $key['id_biaya'] ?>')"> Hapus</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function myklik(id) {
            var konfirmasi = confirm("Apakah anda yakin ingin menghapus data ini?");
            if (konfirmasi) {
                window.location.href = 'hapus-biayaalamat.php?id=' + id;
            }
        }
        $(document).ready(function() {
            $('#example').DataTable();

        });
    </script>
    <?php
    require_once('footer.php');
    ?>