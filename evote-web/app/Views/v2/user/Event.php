<!DOCTYPE html>
<html lang="zxx" class="js">

<head>

    <meta charset="utf-8">
    <meta name="author" content="Softnio">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Pemilihan Kahima, Wakahima, dan BLJ Informatika UPN Veteran Jawa Timur">
    <!-- Fav Icon  -->
    <link rel="shortcut icon" href="<?= base_url('img/favicon.ico') ?>">
    <!-- Page Title  -->
    <title>E-Vote</title>
    <!-- StyleSheets  -->
    <link rel="stylesheet" href="<?php echo base_url('css/dashlite.min.css?ver=2.4.1'); ?>">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url('css/theme.css?ver=2.4.1'); ?>">
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
                                    <img class="logo-img" src="<?= base_url("img/logox.png") ?>" srcset="<?= base_url("img/logox.png") ?>" alt="">
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
                                <?php foreach ($event_data as $key => $event) { ?>
                                    <div class="card">
                                        <div class="card-inner card-inner-xl ">
                                            <article class="entry ">
                                                <h3 class="text-main text-center"><?php echo $event['nama_event']; ?></h3>
                                                <div class="w-100 text-center">
                                                    <img src="https://lh3.googleusercontent.com/d/<?php echo $event['foto_event']; ?>" class="img-event" alt="">
                                                </div>
                                                <div class="mt-0 desc_lomba text-main px-1"><?= $event['deskripsi']; ?></div>
                                                <?php
                                                $classBtn = "btn-main";
                                                $linkPiih = base_url("/user/pilih_v/" . $event['kode_event']);
                                                if ($event['pilih'] == 1) {
                                                    $classBtn = "btn-success";
                                                    $linkPiih = "#";
                                                }
                                                switch ($event['status']) {
                                                    case 1:
                                                        echo "<a class='btn btn-lg " . $classBtn . " mt-auto btn-block' href='" . $linkPiih . "'>Pilih";
                                                        echo $event['pilih'] == 1 ? "(Sudah Memilih)" : "";
                                                        echo "</a>";
                                                        break;
                                                    case 2:
                                                        echo "<button class='btn btn-lg btn-main mt-auto btn-block'>" . $event['waktu_mulai'] . "</button>";
                                                        break;
                                                    case 3:
                                                        echo "<button class='btn btn-lg btn-success mt-auto btn-block'>Pemilihan telah selesai</button>";
                                                        break;
                                                }
                                                ?>
                                            </article>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php if (count($event_data) == 0) : ?>
                                    <div class="container">
                                        <div class="h-100">
                                            <div class="row">
                                                <div class="w-100 card">
                                                    <div class="card-header">
                                                        <div class="title w-100 text-center">
                                                            <h4>Tidak ada event.</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body d-flex flex-column text-center">
                                                        <div class="card-text">Video Cara Memilih</div>
                                                        <div>TBA</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
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