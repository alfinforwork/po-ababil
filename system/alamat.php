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
                            <h6 class="text-uppercase mb-0">Alamat</h6>
                        </div>
                        <div class="card-body">
                            <a href="tambah-alamat.php" class="btn btn-primary">Tambah alamat</a>
                            <hr>
                            <div class="table-responsive">
                                <table id="example" class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                            <th style="width: 20%;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $query = $con->query(
                                            "SELECT
                                            *
                                            from alamat
                                            where remove='1'
                                            "
                                        );
                                        $nomor = 1;
                                        while ($key = $query->fetch_assoc()) { ?>
                                            <tr>
                                                <td class="text-center"><?= $nomor++ ?></td>
                                                <td><?= $key['nama_lokasi'] ?></td>
                                                <td class="text-center"><?= $key['active'] ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-danger">Non Aktif</span>' ?></td>
                                                <td class="text-center">
                                                    <!-- <a href="ubah-biayaalamat.php?id=<?= $key['id_alamat'] ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a> -->
                                                    <?php if ($key['active']) { ?>
                                                        <a href="javascript:void(0)" onclick="mykliknonaktif('<?= $key['id_alamat'] ?>')">Non aktifkan</a>
                                                    <?php } else { ?>
                                                        <a href="javascript:void(0)" onclick="myklikaktif('<?= $key['id_alamat'] ?>')">Aktifkan</a>
                                                    <?php } ?> |
                                                    <a href="javascript:void(0)" onclick="myklik('<?= $key['id_alamat'] ?>')">Hapus</a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <a href="biayaalamat.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        function myklikaktif(id) {
            var konfirmasi = confirm("Apakah anda yakin ingin mengaktifkan data ini?");
            if (konfirmasi) {
                window.location.href = 'alamat-aktif.php?id=' + id;
            }
        }

        function mykliknonaktif(id) {
            var konfirmasi = confirm("Apakah anda yakin ingin me nonaktifkan data ini?");
            if (konfirmasi) {
                window.location.href = 'alamat-nonaktif.php?id=' + id;
            }
        }

        function myklik(id) {
            var konfirmasi = confirm("Apakah anda yakin ingin menghapus data ini?");
            if (konfirmasi) {
                window.location.href = 'hapus-alamat.php?id=' + id;
            }
        }
        $(document).ready(function() {
            $('#example').DataTable();

        });
    </script>
    <?php
    require_once('footer.php');
    ?>