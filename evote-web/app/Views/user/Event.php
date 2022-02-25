<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="icon" href="<?php echo base_url('img/favicon.ico'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo base_url('css/all.min.css'); ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap-datetimepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/menu.css'); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
</head>

<body>
    <header class="floating-header">
        <?php foreach ($event_data as $key => $event) { ?>
            <div class="container">
                <div class="h-100">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <img src="https://lh3.googleusercontent.com/d/<?php echo $event['foto_event']; ?>" alt="" class="card-img img-rounded">
                        </div>
                        <div class="col-md-8 card">
                            <div class="card-header"><?php echo $event['nama_event']; ?></div>
                            <div class="card-body d-flex flex-column">
                                <div><?php echo $event['deskripsi']; ?></div>
                                <?php
                                switch ($event['status']) {
                                    case 1:
                                        echo "<a class='btn btn-primary mt-auto btn-block' href='" . base_url("/user/pilih_v/" . $event['kode_event']) . "'>Pilih";
                                        echo $event['pilih'] == 1 ? "(Sudah Memilih)" : "";
                                        echo "</a>";
                                        break;
                                    case 2:
                                        echo "<button class='btn btn-secondary mt-auto btn-block'>" . $event['waktu_mulai'] . "</button>";
                                        break;
                                    case 3:
                                        echo "<button class='btn btn-success mt-auto btn-block'>Pemilihan telah selesai</button>";
                                        break;
                                }
                                ?>
                            </div>
                        </div>
                    </div>
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
                                    <h2>Tidak ada event.</h2>
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
        <div class="floating-menu-btn">
            <div class="floating-menu-toggle-wrap">
                <div class="floating-menu-toggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </div>
        </div>
        <div class="main-navigation-wrap">
            <nav class="main-navigation" data-back-btn-text="Back">
                <ul class="menu">
                    <li class="delay-0"><a href="<?php echo base_url('user/changepass_v'); ?>">Ganti Password</a></li>
                    <?php if ($_SESSION['is_panitia']) : ?>
                        <li class="delay-1">
                            <a href="<?php echo base_url('panitia/event'); ?>">Panel Panitia</a>
                        </li>
                        <li class="delay-2">
                            <a href="<?php echo base_url('user/logout'); ?>">Keluar</a>
                        </li>
                    <?php else : ?>
                        <li class="delay-1">
                            <a href="<?php echo base_url('user/logout'); ?>">Keluar</a>
                        </li>
                    <?php endif ?>
                </ul><!-- .menu -->
            </nav><!-- .main-navigation -->
        </div><!-- .main-navigation-wrap -->
    </header>
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/menu.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/moment.js'); ?>"></script>
    <script src="<?php echo base_url('js/id.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap-datetimepicker.js'); ?>"></script>
    <script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</body>

</html>