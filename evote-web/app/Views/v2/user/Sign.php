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
    <title>Login | E-Vote</title>
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
                                            <span class="text-main">Masuk</span>
                                            <a href="#" class="form-icon form-icon-right show-youtube">
                                                <em class="icon ni ni-question"></em>
                                            </a>
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
                                <form action="<?php echo base_url('user/masuk'); ?>" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="default-01">NPM</label>
                                        </div>
                                        <input type="number" class="form-control form-control-lg" id="default-01" name="npm" placeholder=" Masukkan NPM">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">Password</label>
                                            <a class="link link-primary link-sm text-main" id="lupaPw">Forgot Password ?</a>
                                        </div>
                                        <div class="form-control-wrap">
                                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                            </a>
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Masukkan Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-main btn-block">Sign in</button>
                                    </div>
                                </form>

                                <div class="text-center pt-3 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <div class="form-note-s2 font-weight-bold  text-center pt-2"> Belum punya akun? <a id="daftar">Buat Akun</a>
                                </div>

                            </div>
                        </div>
                        <div id="daftarPanel" class="card card-bordered mt-0 " style="display: none">
                            <div class="card-inner card-inner-lg">
                                <div class="nk-block-head">
                                    <div class="nk-block-head-content">
                                        <h4 class="nk-block-title text-main">
                                            Daftar
                                            <a href="#" class="form-icon form-icon-right show-youtube">
                                                <em class="icon ni ni-question"></em>
                                            </a>
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
                                <form action="<?php echo base_url('user/daftar'); ?>" method="post">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="nama">Nama</label>
                                        </div>
                                        <input type="text" class="form-control form-control-lg" id="nama" name="nama" placeholder="Masukkan Nama Lengkap">
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="npm">NPM</label>

                                        </div>
                                        <div class="form-control-wrap">

                                            <input type="number" class="form-control form-control-lg" id="npm_daftar" name="npm" placeholder="Masukkan NPM">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-lg btn-main btn-block">Sign up</button>
                                    </div>
                                </form>

                                <div class="text-center pt-3 pb-3">
                                    <h6 class="overline-title overline-title-sap"><span>OR</span></h6>
                                </div>
                                <div class="form-note-s2 font-weight-bold  text-center pt-2"> Sudah punya akun ? <a id="masuk">Login</a>
                                </div>

                            </div>
                        </div>
                        <div class="alert alert-fill alert-primary alert-icon alert-main mt-1" style="background-color:#ffd150">
                            <em class="icon ni ni-alert-circle"></em> <strong>Pemberitahuan!</strong><br> Yang belum mendaftar akun Pemira 2022 per tanggal 19 Maret 2022 pukul 15.00 WIB, silakan cek email UPN masing-masing (jika tidak ada coba cek di <b>SPAM</b>) untuk melihat password Pemira 2022 nya. Bila terkendala saat login bisa menghubungi CP: <a href="https://wa.me/62881026653711">0881026653711</a>, Jika tidak menerima email klik <br><button onclick="$('#resendEmailModal').modal('show');" class="btn btn-success mt-1">Disini</button>
                        </div>
                    </div>

                </div>
                <!-- wrap @e -->
            </div>

            <!-- content @e -->
        </div>
        <!-- main @e -->
    </div>
    <div class="modal" id="forgetModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lupa password ?</h4>
                </div>
                <div class="modal-body">
                    <label for="npmForgetSend">Masukkan NPM</label>
                    <input class="form-control" type="text" maxlength="11" id="npmForgetSend">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-main" id="sendForgetPassword">Kirim ulang.</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="resendEmailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kirim ulang password</h4>
                </div>
                <div class="modal-body">
                    <label for="npmResendEmail">Masukkan NPM</label>
                    <input class="form-control" type="text" maxlength="11" id="npmResendEmail">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-main" id="resendPassword">Kirim ulang.</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">

                    <div class="d-flex flex-column align-items-center">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="" id="video" allowscriptaccess="always" allow="autoplay"></iframe>
                        </div>
                        <a href="https://www.youtube.com/watch?v=<?= $youtube ?>" target="_blank" class="btn btn-main mt-2">Buka di tab baru</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="<?= base_url('js/bundle.js?ver=2.4.0') ?>"></script>
    <script src="<?= base_url('js/scripts.js?ver=2.4.0') ?>"></script>
    <script>
        $(document).ready(function() {
            $('form').submit(function() {
                $(this).find("button").attr('disabled', true);
            });
            var $videoSrc = "<?= $youtube ?>";
            $("#video").addClass("d-none")
            $(".show-youtube").on("click", function(e) {
                e.preventDefault();
                $("#video").removeClass("d-none")
                $("#video").attr('src', "https://www.youtube.com/embed/" + $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
                $('#youtubeModal').modal('show');
            })

            $('#youtubeModal').on('shown.bs.modal', function(e) {
                $("#video").removeClass("d-none")
                $("#video").attr('src', "https://www.youtube.com/embed/" + $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
            })

            $('#youtubeModal').on('hide.bs.modal', function(e) {
                $("#video").addClass("d-none")
                $("#video").attr('src', $videoSrc);
            })

            $("#lupaPw").on("click", function(e) {
                e.preventDefault();
                $("#forgetModal").modal("show");
            })
            if ($("#resend_email").length > 0) {
                let timer2 = $("#resend_email").html().match(/\((.*)\)/)[1];
                let interval = setInterval(function() {
                    let timer = timer2.split(':');
                    //by parsing integer, I avoid all extra string processing
                    let minutes = parseInt(timer[0], 10);
                    let seconds = parseInt(timer[1], 10);
                    --seconds;
                    minutes = (seconds < 0) ? --minutes : minutes;

                    seconds = (seconds < 0) ? 59 : seconds;
                    seconds = (seconds < 10) ? '0' + seconds : seconds;
                    //minutes = (minutes < 10) ?  minutes : minutes;
                    if (minutes <= 0 && seconds <= 0) {
                        $("#resend_email").removeClass('disabled');
                        $('#resend_email').html('Kirim Ulang');
                        clearInterval(interval);
                    } else {
                        $('#resend_email').html('Kirim Ulang (' + minutes + ':' + seconds + ')');
                        timer2 = minutes + ':' + seconds;
                    }
                }, 1000);
            }
            $('#masukPanel').slideDown("slow");
            $('#daftarPanel').hide();
            $('#masuk').click(function(e) {
                e.preventDefault();
                $('#masukPanel').slideDown("slow");
                $('#daftarPanel').slideUp("slow");
            });
            $('#daftar').click(function(e) {
                e.preventDefault();
                $('#masukPanel').slideUp("slow");
                $('#daftarPanel').slideDown("slow");
            });
            $("#sendForgetPassword").on('click', function(e) {
                $(this).attr("disabled", true);
                window.location = '<?php echo base_url('user/forgot') ?>/' + $('#npmForgetSend').val() + '@student.upnjatim.ac.id';
            })

            $("#resendPassword").on('click', function(e) {
                $(this).attr("disabled", true);
                window.location = '<?php echo base_url('user/resend/') ?>/' + $('#npmResendEmail').val() + '@student.upnjatim.ac.id';
            })
        });
    </script>
</body>

</html>