<?php
include_once('./header.php');
// require_once('../connect.php');
?>


<div class="page-holder w-100 d-flex flex-wrap">
    <div class="container-fluid px-xl-5">
        <section class="py-5">
            <div class="row">
                <div class="col-lg-12 mb-12">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-uppercase mb-0">Tiket</h6>
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-4" style="display: flex;flex-direction: column;height: 350px;overflow: auto" id="chat-left">

                                </div>
                                <div class="col-md-8">
                                    <h4 class="text-center">Chat from <span id="nama-user"></span></h4>

                                    <form action="" id="chat-form">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="hidden" name="chat-from" id="chat-from">
                                                <input type="text" name="chat-edit" id="chat-edit" class="form-control" required>
                                                <div class="input-group-append">
                                                    <!-- <span class="input-group-text" id="basic-addon2">@example.com</span> -->
                                                    <button type="submit" class="btn btn-primary">Kirim</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="chat-right" style="max-height: 300px;overflow: auto">

                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
    include_once('./footer.php');

    $root  = "https://" . $_SERVER['HTTP_HOST'];
    if ($_SESSION['level'] <> 'admin') {
        echo "<script>window.location.replace('" . $root . str_replace('system/' . basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']) . 'logout.php' . "');</script>";
    }
    $root .= str_replace(basename($_SERVER['SCRIPT_NAME']), "", $_SERVER['SCRIPT_NAME']);
    ?>

    <script>
        var Username = null;
        $(document).ready(function() {
            // Chat Left
            setInterval(() => {
                load_chat_left();
            }, 500);

            // Nama User
            setInterval(() => {
                if (Username == null) {
                    $('#nama-user').html('none');
                } else {
                    $('#nama-user').html(Username);
                }
            }, 500);

            // Show Chat
            setInterval(() => {
                var html = '';
                $.ajax({
                    type: "post",
                    url: "<?= $root . 'chat/show-chat.php' ?>",
                    data: {
                        username: Username
                    },
                    dataType: "json",
                    success: function(res) {
                        console.log(Username);
                        $.each(res, function(indexInArray, valueOfElement) {
                            html +=
                                '<div style="display: flex;flex-direction: column " class="border-bottom p-2">' +
                                '<div style="flex: 1;display: flex;flex-direction: row ">' +
                                '<div style="width: 20%"><span class="badge badge-primary">Username</span></div>' +
                                '<div style="width: 80%">' + valueOfElement.username + '<button type="button" class="btn btn-sm btn-danger float-right" onclick="delete_chat(' + valueOfElement.id_chat_detail + ')">Hapus</button></div>' +
                                '</div>' +
                                '<div style="flex: 1;display: flex;flex-direction: row ">' +
                                '<div style="width: 20%"><span class="badge badge-secondary">Chat</span></div>' +
                                '<div style="width: 80%">' + valueOfElement.chat + '</div>' +
                                '</div>' +
                                '</div>';
                        });
                        $('#chat-right').html(html);
                        $('#chat-from').val(Username);
                    },
                    error(JQueryXHR, status, errorThrown) {
                        $('#chat-right').html('');
                    }
                });
            }, 500);


            // Send Chat
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                var data = $(this).serialize();
                if (Username == '' || Username == null) {
                    alert("Pilih chat dahulu");
                } else {
                    $.ajax({
                        type: "post",
                        url: "<?= $root . 'chat/send-chat.php' ?>",
                        data: data,
                        dataType: "json",
                        success: function(res) {}
                    });

                    $('#chat-edit').val('');
                }
            })
        });

        function load_chat(x) {
            Username = x;
        };

        function load_chat_left() {
            $.get("<?= $root . 'chat/chat-left.php' ?>", function(res) {
                var html = '';
                res.forEach(valueOfElement => {
                    var newBadge = (valueOfElement.is_baca_admin == 1) ? '<span class="badge badge-danger float-right">New</span>' : '';
                    var uname = "'" + valueOfElement.username + "'";
                    var online = valueOfElement.is_online == 1 ? '<span class="badge badge-green float-right">Online</span>' : '<span class="badge badge-light float-right">Offline</span>';
                    html +=
                        '<a href="#" onclick="load_chat(' + uname + ' )" class="nav-link bg-gray-100 bg-hover-dark border-bottom" style="display: flex;flex-direction: column;height: 70px;padding: 5px 20px">' +
                        '<div style = "flex: 1;display: flex;flex-direction: row " >' +
                        '<div style = "width: 30%"> <span class = "badge badge-primary"> Username </span>' +
                        '</div>' +
                        '<div style = "width: 70%">' + valueOfElement.username + online + ' </div>' +
                        '</div>' +
                        '<div style = "flex: 1;display: flex;flex-direction: row ">' +
                        '<div style = "width: 30%" ><span class = "badge badge-warning" > Tanggal </span></div>' +
                        '<div style = "width: 70%;height: 10px" >' + valueOfElement.created_at + newBadge + '</div>' +
                        '</div>' +
                        '</a>';
                });
                $('#chat-left').html(html);
            }, 'json');
        };

        function delete_chat(id) {
            var konfirmasi = confirm("Apakah anda ingin menghapus pesan ini ?");
            if (konfirmasi) {
                $.post('<?= $root . 'chat/delete-chat.php' ?>', {
                    id_chat_detail: id
                }, function(data) {
                    alert("Berhasil dihapus");
                });
            }
        }
    </script>