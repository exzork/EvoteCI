<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar ke Evote IF</title>
    <link rel="icon" href="<?php echo base_url('img/favicon.ico'); ?>">
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-scrollTo/2.1.3/jquery.scrollTo.min.js"></script>
</head>

<body>
    <div class="container">

        <section id="formHolder">

            <div class="row">
                <div class="col-sm-6 brand">
                    <a href="#" class="logo">EvoteIF</a>
                    <div class="heading">
                        <h1>EvoteIF</h1>
                    </div>
                </div>

                <div class="col-sm-6 form">
                    <div class="login form-peice ">
                        <form class="login-form" action="<?php echo base_url('user/masuk'); ?>" method="post">
                            <?php if (isset($validation)) : ?>
                                <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="loginNpm">NPM</label>
                                <input type="text" name="npm" id="loginNpm" required>
                            </div>
                            <div class="form-group">
                                <label for="loginPassword">Password</label>
                                <input type="password" name="password" id="loginPassword" required>
                            </div>
                            <div class="CTA">
                                <input type="submit" value="Masuk">
                                <a href="#" class="switch">Saya belum memiliki akun.</a>
                            </div>
                        </form>
                    </div>
                    <div class="signup form-peice switched">
                        <form class="signup-form" id="form_signup" action="<?php echo base_url('user/daftar'); ?>" method="post">
                            <?php if (isset($validation)) : ?>
                                <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                            <?php endif; ?>
                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" name="nama" id="name" class="name">
                                <span class="error"></span>
                            </div>
                            <div class="form-group">
                                <label for="signupNpm">NPM</label>
                                <input type="text" name="npm" id="sigupNpm" class="name">
                                <span class="error"></span>
                            </div>

                            <div class="CTA">
                                <input type="submit" onclick="$('#form_signup').submit()" value="Daftar" id="submit">
                                <a href="#" class="switch">Saya sudah memiliki akun.</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>


        <footer>

            <div class="alert alert-success mt-3" id="alertDiv">
                <strong>Pemberitahuan!</strong> Yang belum mendaftar akun evote per tanggal 28 Februari 2021 pukul 22.00 WIB, silakan cek email UPN masing-masing (jika tidak ada coba cek di <b>SPAM</b>) untuk melihat password evote nya. Bila terkendala saat login bisa menghubungi CP: 081233806275, Jika tidak menerima email klik <button onclick="$('#resendEmailModal').modal('show');" class="btn btn-success">Disini</button>
            </div>
            <p>
                <iframe width="480" height="270" src="https://www.youtube.com/embed/QsW1J2dgne4" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </p>
            <p>Terjadi masalah? Hubungi <a href="https://linktr.ee/YanuarFitroni" target="_blank">disini</a></p>
            <p>
                Evote IF &copy2021 - <a href="mailto:muhammadeko.if@gmail.com">Muhammad Eko Prasetyo</a>
            </p>
        </footer>

    </div>
    <div class="modal" id="resendEmailModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Kirim ulang password</h4>
                </div>
                <div class="modal-body">
                    <label for="npmResendEmail">Masukkan NPM</label>
                    <input type="text" maxlength="11" id="npmResendEmail">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="window.location='<?php echo base_url('user/resend/') ?>/'+$('#npmResendEmail').val()+'@student.upnjatim.ac.id';">Kirim ulang.</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        /*global $, document, window, setTimeout, navigator, console, location*/
        $(document).ready(function() {
            $(window).scrollTo($("#alertDiv"));
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
            'use strict';

            var usernameError = true,
                emailError = true,
                passwordError = true,
                passConfirm = true;

            // Detect browser for css purpose
            if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                $('.form form label').addClass('fontSwitch');
            }

            // Label effect
            $('input').focus(function() {

                $(this).siblings('label').addClass('active');
            });

            // Form validation
            $('input').blur(function() {
                // label effect
                if ($(this).val().length > 0) {
                    $(this).siblings('label').addClass('active');
                } else {
                    $(this).siblings('label').removeClass('active');
                }
            });


            // form switch
            $('a.switch').click(function(e) {
                $(this).toggleClass('active');
                e.preventDefault();

                if ($('a.switch').hasClass('active')) {
                    $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
                } else {
                    $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
                }
            });


            // Reload page
            $('a.profile').on('click', function() {
                location.reload(true);
            });


        });
    </script>
    <style>
        body {
            font-family: "Montserrat", sans-serif;
            background: #f7edd5;
        }

        .disabled {
            pointer-events: none;
            cursor: default;
        }

        .container {
            max-width: 900px;
        }

        a {
            display: inline-block;
            text-decoration: none;
        }

        input {
            outline: none !important;
        }

        h1 {
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 40px;
            font-weight: 700;
        }

        section#formHolder {
            padding: 50px 0;
        }

        .brand {
            padding: 20px;
            background: url(https://goo.gl/A0ynht);
            background-size: cover;
            background-position: center center;
            color: #fff;
            min-height: 540px;
            position: relative;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
            transition: all 0.6s cubic-bezier(1, -0.375, 0.285, 0.995);
            z-index: 1;
        }

        .brand.active {
            width: 100%;
        }

        .brand::before {
            content: '';
            display: block;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            background: #333;
            z-index: -1;
        }

        .brand a.logo {
            color: #f95959;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            line-height: 1em;
        }

        .brand a.logo span {
            font-size: 30px;
            color: #fff;
            transform: translateX(-5px);
            display: inline-block;
        }

        .brand .heading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            transition: all 0.6s;
        }

        .brand .heading.active {
            top: 100px;
            left: 100px;
            transform: translate(0);
        }

        .brand .heading h2 {
            font-size: 70px;
            font-weight: 700;
            text-transform: uppercase;
            margin-bottom: 0;
        }

        .brand .heading p {
            font-size: 15px;
            font-weight: 300;
            text-transform: uppercase;
            letter-spacing: 2px;
            white-space: 4px;
            font-family: "Raleway", sans-serif;
        }

        .brand .success-msg {
            width: 100%;
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin-top: 60px;
        }

        .brand .success-msg p {
            font-size: 25px;
            font-weight: 400;
            font-family: "Raleway", sans-serif;
        }

        .brand .success-msg a {
            font-size: 12px;
            text-transform: uppercase;
            padding: 8px 30px;
            background: #f95959;
            text-decoration: none;
            color: #fff;
            border-radius: 30px;
        }

        .brand .success-msg p,
        .brand .success-msg a {
            transition: all 0.9s;
            transform: translateY(20px);
            opacity: 0;
        }

        .brand .success-msg p.active,
        .brand .success-msg a.active {
            transform: translateY(0);
            opacity: 1;
        }

        .form {
            position: relative;
        }

        .form .form-peice {
            background: #fff;
            min-height: 480px;
            margin-top: 30px;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.2);
            color: #bbbbbb;
            padding: 30px 0 60px;
            transition: all 0.9s cubic-bezier(1, -0.375, 0.285, 0.995);
            position: absolute;
            top: 0;
            left: -30%;
            width: 130%;
            overflow: hidden;
        }

        .form .form-peice.switched {
            transform: translateX(-100%);
            width: 100%;
            left: 0;
        }

        .form form {
            padding: 0 40px;
            margin: 0;
            width: 70%;
            position: absolute;
            top: 50%;
            left: 60%;
            transform: translate(-50%, -50%);
        }

        .form form .form-group {
            margin-bottom: 5px;
            position: relative;
        }

        .form form .form-group.hasError input {
            border-color: #f95959 !important;
        }

        .form form .form-group.hasError label {
            color: #f95959 !important;
        }

        .form form label {
            font-size: 12px;
            font-weight: 400;
            text-transform: uppercase;
            font-family: "Montserrat", sans-serif;
            transform: translateY(40px);
            transition: all 0.4s;
            cursor: text;
            z-index: -1;
        }

        .form form label.active {
            transform: translateY(10px);
            font-size: 10px;
        }

        .form form label.fontSwitch {
            font-family: "Raleway", sans-serif !important;
            font-weight: 600;
        }

        .form form input:not([type=submit]) {
            background: none;
            outline: none;
            border: none;
            display: block;
            padding: 10px 0;
            width: 100%;
            border-bottom: 1px solid #eee;
            color: #444;
            font-size: 15px;
            font-family: "Montserrat", sans-serif;
            z-index: 1;
        }

        .form form input:not([type=submit]).hasError {
            border-color: #f95959;
        }

        .form form span.error {
            color: #f95959;
            font-family: "Montserrat", sans-serif;
            font-size: 12px;
            position: absolute;
            bottom: -20px;
            right: 0;
            display: none;
        }

        .form form input[type=password] {
            color: #f95959;
        }

        .form form .CTA {
            margin-top: 30px;
        }

        .form form .CTA input {
            font-size: 12px;
            text-transform: uppercase;
            padding: 5px 30px;
            background: #f95959;
            color: #fff;
            border-radius: 30px;
            margin-right: 20px;
            border: none;
            font-family: "Montserrat", sans-serif;
        }

        .form form .CTA a.switch {
            font-size: 13px;
            font-weight: 400;
            font-family: "Montserrat", sans-serif;
            color: #333;
            text-decoration: underline;
            transition: all 0.3s;
        }

        .form form .CTA a.switch:hover {
            color: #f95959;
        }

        footer {
            text-align: center;
        }

        footer p {
            color: #777;
        }

        footer p a,
        footer p a:focus {
            color: #b8b09f;
            transition: all .3s;
            text-decoration: none !important;
        }

        footer p a:hover,
        footer p a:focus:hover {
            color: #f95959;
        }

        @media (max-width: 768px) {
            .container {
                overflow: hidden;
            }

            section#formHolder {
                padding: 0;
            }

            section#formHolder div.brand {
                min-height: 200px !important;
            }

            section#formHolder div.brand.active {
                min-height: 100vh !important;
            }

            section#formHolder div.brand .heading.active {
                top: 200px;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            section#formHolder div.brand .success-msg p {
                font-size: 16px;
            }

            section#formHolder div.brand .success-msg a {
                padding: 5px 30px;
                font-size: 10px;
            }

            section#formHolder .form {
                width: 80vw;
                min-height: 500px;
                margin-left: 10vw;
            }

            section#formHolder .form .form-peice {
                margin: 0;
                top: 0;
                left: 0;
                width: 100% !important;
                transition: all .5s ease-in-out;
            }

            section#formHolder .form .form-peice.switched {
                transform: translateY(-100%);
                width: 100%;
                left: 0;
            }

            section#formHolder .form .form-peice>form {
                width: 100% !important;
                padding: 60px;
                left: 50%;
            }
        }

        @media (max-width: 480px) {
            section#formHolder .form {
                width: 100vw;
                margin-left: 0;
            }

            h2 {
                font-size: 50px !important;
            }
        }
    </style>
</body>

</html>