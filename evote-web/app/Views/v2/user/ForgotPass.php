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
                                    <img class="logo-img" src="<?= base_url("img/logox.png") ?>" srcset="<?= base_url("img/logox.png") ?>" alt="logo-dark">
                                </a>
                            </div><!-- .nk-header-brand -->


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

                                        <form id="ganti_pass" method="post">
                                            <input type="hidden" name="token_data" value="<?= $token ?>>" />
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
                                                <button class="btn btn-lg btn-main btn-block" type="submit">Ubah Password</button>
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

</body>

</html>