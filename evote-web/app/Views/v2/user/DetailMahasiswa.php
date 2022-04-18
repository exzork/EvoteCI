<!DOCTYPE html>
<html lang="zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pemilihan Kahima, Wakahima, dan BLJ Informatika UPN Veteran Jawa Timur">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('img/logox.ico') ?>">
    <!-- Page Title  -->
    <title>Detail Mahasiswa | E-Vote</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url('css/dashlite.min.css?ver=2.4.1'); ?>">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url('css/theme.css?ver=2.4.1'); ?>">
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
</head>

<body class="nk-body bg-main npc-general pg-auth">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- wrap @s -->
            <div class="nk-wrap nk-wrap-nosidebar">
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                        <div class="brand-logo pb-4 text-center">
                            <a href="<?= base_url() ?>" class="logo-link">
                                <img style="max-width:80px" src="<?= base_url("img/pemira22.png") ?>" srcset="<?= base_url("img/pemira22.png") ?>" alt="logo-dark">
                                <img style="max-width:80px" src="<?= base_url("img/pemiraff.png") ?>" srcset="<?= base_url("img/pemiraff.png") ?>" alt="logo-dark">
                            </a>
                        </div>
                        <div id="masukPanel" class="card card-bordered ">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title">
                                            <span class="text-main">Data Mahasiswa</span>
                                        </h4>

                                        <small>Harap Masukkan data dengan detail sebagai berikut:</small>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">NPM</label>
                                    </div>
                                    <input type="text" value="<?= $npm ?>" readonly class="form-control form-control-lg" id="npm" name="npm" placeholder=" Masukkan NPM">
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label class="form-label" for="default-01">Nama</label>
                                    </div>
                                    <input type="text" readonly class="form-control form-control-lg" id="name" name="npm" placeholder=" Masukkan NPM">
                                </div>

                                <div class="form-group">
                                    <p>Silahkan Mendaftar ulang dengan menggunakan data diatas, untuk lebih amanya silahkan copy paste</p>
                                    <a href="<?= base_url() ?>" class="btn btn-lg btn-main btn-block"><i class="icon ni ni-home mr-2"></i>Kembali ke halaman utama</a>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <!-- wrap @e -->
            </div>

            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>


    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?= base_url('js/bundle.js?ver=2.4.0') ?>"></script>
    <script src="<?= base_url('js/scripts.js?ver=2.4.0') ?>"></script>
    <script>
        $(document).ready(function() {
            $('#name').val("Loading..")
            $('#npm').val("Loading..")
            $.ajax({
                url: "https://api-mahasiswapemira.herokuapp.com/mahasiswa/<?= $npm ?>",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#name').val(data.mahasiswa[0].nama);
                    $('#npm').val("<?= $npm ?>")
                },
                error: function(e) {
                    $("#name").val("Data tidak ditemukan")
                    $("#npm").val("Data tidak ditemukan")
                }
            });
        });
    </script>
</body>

</html>