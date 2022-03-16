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
    <title>Ganti Password</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url('css/dashlite.min.css?ver=2.4.0'); ?>">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url('css/theme.css?ver=2.4.0'); ?>">
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
</head>


<body class="nk-body bg-main npc-default  ">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <div class="nk-header nk-header-fixed nav-main">
                    <div class="container-fluid">
                        <div class="nk-header-wrap">

                            <div class="nk-header-brand ">
                                <a href="<?= base_url("user/event") ?>" class="logo-link">
                                    <img class="logo-light logo-img" src="<?= base_url("img/pemira22.png") ?>" srcset="<?= base_url("img/pemira22.png") ?> 2x" alt="logo">
                                    <img class="logo-dark logo-img" src="<?= base_url("img/pemira22.png") ?>" srcset="<?= base_url("img/pemira22.png") ?> 2x" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->

                            <div class="nk-header-tools">
                                <ul class="nk-quick-nav">
                                    <li class="dropdown user-dropdown">
                                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                                            <div class="user-toggle">
                                                <div class="user-avatar sm">
                                                    <em class="icon ni ni-user-alt"></em>
                                                </div>
                                                <div class="user-info d-none d-xl-block">
                                                    <div class="user-name dropdown-indicator text-white"><?php if (isset($_SESSION['nama_user'])) {
                                                                                                                echo $_SESSION['nama_user'];
                                                                                                            } ?></div>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                                <div class="user-card">

                                                    <div class="user-info">
                                                        <span class="lead-text text-main"><?php if (isset($_SESSION['nama_user'])) {
                                                                                                echo $_SESSION['nama_user'];
                                                                                            } ?></span>
                                                        <span class="sub-text text-submain"><?php if (isset($_SESSION['npm'])) {
                                                                                                echo $_SESSION['npm'];
                                                                                            } ?>@student.upnjatim.ac.id</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="dropdown-inner">
                                                <ul class="link-list">
                                                    <?php if ($_SESSION['is_panitia']) : ?>
                                                        <li><a href="<?php echo base_url('panitia/event'); ?>"><em class="icon ni ni-user-alt"></em><span>Panel Panitia</span></a></li>
                                                    <?php endif; ?>
                                                    <li><a href="<?php echo base_url('user/changepass_v'); ?>"><em class="icon ni ni-update"></em><span>Ubah Password</span></a></li>

                                                    <li><a href="<?php echo base_url('user/logout'); ?>"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>

                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- .nk-header-wrap -->
                    </div><!-- .container-fliud -->
                </div>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body container">

                                <div class="card card-bordered ">
                                    <div class="card-inner card-inner-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">
                                                    <span class="text-main">Ubah Password</span>

                                                </h4>
                                                <div class="nk-block-des">
                                                    <?php if (isset($validation)) : ?>
                                                        <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                                                    <?php endif; ?>
                                                    <?php if (session()->getFlashdata('msg')) : ?>
                                                        <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <form id="ganti_pass">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="old_pass">Password Lama</label>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="old_pass">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg" id="old_pass" name="old_pass" placeholder="Masukkan Password Lama">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="new_pass">Password Baru</label>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_pass">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg" id="new_pass" name="new_pass" placeholder="Masukkan Password Baru">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="confirm_new_pass">Konfirmasi Password Baru</label>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirm_new_pass">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg" id="confirm_new_pass" name="confirm_new_pass" placeholder="Masukkan Ulang Password Baru">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-lg btn-main btn-block" type="button" onclick="ganti_pass()">Ubah Password</button>
                                                <a href="<?= base_url("user/event") ?>" class="btn btn-lg btn-primary text-white btn-block">Kembali ke Menu Utama</a>
                                            </div>
                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->

                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?= base_url('js/bundle.js?ver=2.4.0') ?>"></script>
    <script src="<?= base_url('js/scripts.js?ver=2.4.0') ?>"></script>
    <script>
        function alert_change(type, text, timer = true) {
            if (timer) {
                Swal.fire({
                    title: "",
                    timer: 3000,
                    text: text,
                    icon: type
                });
            } else {
                Swal.fire({
                    title: "",
                    text: text,
                    icon: type
                });
            }
        }

        function ganti_pass() {
            $(".loader").removeClass('hidden');
            var form = $("#ganti_pass")
            var formData = new FormData(form[0]);
            console.log(formData);
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('user/changepass') ?>',
                data: formData,
                dataType: "JSON",
                processData: false,
                contentType: false,
                success: function(data) {
                    $(".loader").addClass('hidden');
                    if (data['type'] == 'success') {
                        alert_change(data['type'], data['msg']);
                        setTimeout(function() {
                            window.location.href = "<?php echo base_url('user/event'); ?>";
                        }, 3000);
                    } else {
                        alert_change(data['type'], data['msg']);
                    }
                }
            });
        }
    </script>
    <style>
        body {
            position: relative;
        }

        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 60px;
            height: 60px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -30px;
            margin-top: -30px;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .hidden {
            display: none;
        }
    </style>
    <div class="loader hidden"></div>
</body>

</html>