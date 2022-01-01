<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemilihan</title>
    <link rel="icon" href="https://lh3.googleusercontent.com/d/17-um7KYZG3GUala7hr8cg1xpdpNWXRT5">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?php echo base_url('css/all.min.css'); ?>">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap-datetimepicker.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('css/adminlte.min.css'); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link id="skin-default" rel="stylesheet" href="<?php echo base_url('css/theme.css?ver=2.4.0'); ?>">
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/moment.js'); ?>"></script>
    <script src="<?php echo base_url('js/id.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap-datetimepicker.js'); ?>"></script>
    <script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
</head>

<body class="m-0 p-0 bg-main">
    <div id="content">
        <?php if ($rekap == 0) : ?>
            <div class=" bg-main h-100 panel-pemilihan" id="content">
                <div class="card ">
                    <div class="card-header nav-main text-white">
                        <div class="card-title w-100">
                            <h5 style="text-align: center;" id="judul_pem"><?php echo $judul_event . " - " . $judul_pem ?></h5>
                        </div>
                    </div>
                    <div class="card-body container-fluid bg-main">
                        <div class="row mt-3">
                            <?php foreach ($data_calon as $key => $calon) : ?>
                                <div class="col-md-3 col-12 col-sm-4 mt-2">
                                    <div class="card h-100">
                                        <img class="card-img-top img-fluid" id="img_<?php echo $calon['kode_calon']; ?>" src="https://lh3.googleusercontent.com/d/<?php echo $calon['foto_calon']; ?>" alt="Card image" style="width:100%">
                                        <div class="card-body d-flex flex-column">
                                            <div class="mt-auto">
                                                <h5 class="card-title text-main font-weight-bold" id="nama_<?php echo $calon['kode_calon']; ?>"><?php echo $calon['nama_ketua'] . "<br>" . $calon['nama_wakil'];
                                                                                                                                                if ($calon['nama_wakil']) echo "<br>"; ?></h5>
                                                <br><br>
                                                <button href="#" class="btn mb-2 btn-success mt-auto btn-block" onclick="pesan('<?php echo $calon['kode_calon']; ?>')">Visi Misi
                                                </button>
                                                <button href="#" class="btn mt-2 btn-primary mt-auto btn-block" onclick="pilih('<?php echo $calon['kode_calon']; ?>')">Pilih Calon
                                                    Ini
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hidden" id="pesan_<?php echo $calon['kode_calon']; ?>">
                                    <span class="text-left"><?php echo $calon['pesan']; ?></span>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <button class="btn btn-main mt-2 btn-next btn-block" onclick="next('<?php echo $judul_pem; ?>')">Next
                        </button>
                    </div>
                </div>
            </div>
            <script>
                function pesan(kode) {
                    var txt_calon = $("#pesan_" + kode).html();
                    var img_url = $("#img_" + kode).attr('src');
                    var title = $("#nama_" + kode).html();
                    Swal.fire({
                        width: 600,
                        title: "Visi & Misi",
                        imageUrl: img_url,
                        imageWidth: 400,
                        html: txt_calon
                    })
                }

                function pilih(kode) {
                    var nama_calon = $("#nama_" + kode).html();
                    var judul_pem = $("#judul_pem").html();
                    Swal.fire({
                        title: '',
                        html: 'Apakah anda yakin memilih <br><b>' + nama_calon + '</b> untuk <br><b>' + judul_pem + '</b> ?',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Pilih',
                        cancelButtonText: 'Batalkan'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".loader").removeClass('hidden');
                            $.post("<?php echo base_url('user/pilih'); ?>", {
                                calon: kode,
                                pem: <?php echo $pem; ?>
                            }, function(resp) {
                                $(".loader").addClass('hidden');
                                resp = JSON.parse(resp);
                                Swal.fire({
                                    icon: resp['type'],
                                    text: resp['msg'],
                                    timer: 2000,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                });
                                setTimeout(function() {
                                    $("#content").fadeOut();
                                    $(".loader").removeClass('hidden');
                                    $.get(resp['url'], function(resp2) {
                                        $("#content").html(resp2);
                                        $(".loader").addClass('hidden');
                                        $("#content").fadeIn();
                                    });
                                }, 2000);
                            });
                        }
                    });
                };

                function next(text) {
                    Swal.fire({
                        title: "Peringatan",
                        html: "<b>Apakah anda yakin?<br>Anda tidak memilih pada pemilihan " + text + "</b>",
                        icon: 'warning',
                        confirmButtonText: 'Ya, Next',
                        cancelButtonText: 'Batalkan',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(".loader").removeClass('hidden');
                            $.post("<?php echo base_url('user/pilih'); ?>", {
                                calon: '<?php echo $event; ?>',
                                pem: <?php echo $pem; ?>
                            }, function(resp) {
                                $(".loader").addClass('hidden');
                                resp = JSON.parse(resp);
                                Swal.fire({
                                    icon: resp['type'],
                                    text: resp['msg'],
                                    timer: 2000,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false
                                });
                                setTimeout(function() {
                                    $("#content").fadeOut();
                                    $(".loader").removeClass('hidden');
                                    $.get(resp['url'], function(resp2) {
                                        $("#content").html(resp2);
                                        $(".loader").addClass('hidden');
                                        $("#content").fadeIn();
                                    });
                                }, 2000);
                            });
                        }
                    });
                };
            </script>
        <?php endif ?>
    </div>
    <?php if ($rekap == 0) : ?>
        <div class="card col-md-4 col-sm-12 mx-auto hidden text-main mt-1" id="card_bukti">
        <?php endif ?>
        <?php if ($rekap == 1) : ?>
            <div class="card col-md-4  col-sm-12 mx-auto text-main mt-1" id="card_bukti">
            <?php endif ?>
            <div class="card-header">
                <div class="card-title w-100">
                    <h3 class="text-center ">Bukti Penggunaan Suara</h3>
                </div>
            </div>
            <div class="card-body">
                <form action="#" id="form_pilih">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title w-100">
                                <h3><b>Foto Diri</b></h3>
                            </div>
                            <div class="card-text"><b>
                                    - Foto diri dengan memegang KTM bagi angkatan 2016-2019<br>
                                    - Foto Selfie saja bagi angkatan 2020<br>
                                    - Foto diri dengan memegang Transkrip bagi yang KTMnya hilang
                                </b>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="camera">
                                <video id="video" class="img-fluid">Video stream not available.</video>
                                <canvas id="canvas" class="img-fluid"></canvas>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button id="startbutton" class="btn btn-main form-control" onclick="$('#submit_btn').removeAttr('disabled')">Take photo
                            </button>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title w-100">
                                <h3><b>File Foto KTM</b></h3>
                            </div>
                            <div class="card-text"><b>
                                    - Foto KTM (Bagi angkatan 2016 - 2019)<br>
                                    - Screenshot Transkrip (Bagi angkatan 2020)<br>
                                    - Screenshot Transkrip (Bagi yang KTMnya hilang)
                                </b>
                            </div>
                        </div>
                        <div class="card-body">
                            <input type="file" class="form-control" name="pilih_ktm" accept="image/*" id="pilih_ktm">
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary" id="submit_btn" onclick="save_pilih()" disabled>Submit</button>
            </div>
            </div>
            <script>
                function alert_change(type, text) {
                    Swal.fire({
                        title: "",
                        timer: 3000,
                        text: text,
                        icon: type
                    })
                }

                function save_pilih() {
                    fetch(data_photo)
                        .then(res => res.blob())
                        .then(blob => {
                            const file = new File([blob], "capture.png", {
                                type: 'image/jpeg'
                            });
                            var form = $("#form_pilih").closest("form");
                            var formData = new FormData(form[0]);
                            formData.append("image", file);
                            formData.append("pem", 0);
                            formData.append("calon", "<?php echo $event; ?>");

                            $(".loader").removeClass('hidden');
                            $.ajax({
                                type: 'POST',
                                enctype: 'multipart/form-data',
                                url: '<?php echo base_url('user/pilih'); ?>',
                                data: formData,
                                dataType: "JSON",
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $(".loader").addClass('hidden');
                                    if (data['type'] == "fatal") {
                                        data['type'] = "error";
                                        alert_change(data['type'], data['msg']);
                                        $(".modal").modal('hide');
                                    } else {
                                        $(".modal").modal('hide');
                                        alert_change(data['type'], data['msg']);
                                        setTimeout(function() {
                                            window.location.href = "<?php echo base_url('user/event'); ?>";
                                        }, 3000);
                                    }
                                }
                            });
                        });
                }

                (function() {
                    var width = 1920;
                    var height = 0;
                    var streaming = false;
                    var video = null;
                    var canvas = null;
                    var photo = null;
                    var startbutton = null;

                    function startup() {
                        video = document.getElementById('video');
                        canvas = document.getElementById('canvas');
                        photo = document.getElementById('photo');
                        startbutton = document.getElementById('startbutton');
                        navigator.mediaDevices.getUserMedia({
                                video: true,
                                audio: false
                            })
                            .then(function(stream) {
                                video.srcObject = stream;
                                video.play();
                            })
                            .catch(function(err) {
                                if (err.name == "NotAllowedError") {
                                    Swal.fire({
                                        title: "Mohon Izinkan Akses Kamera.",
                                        html: `<iframe class="img-fluid" src="https://www.youtube-nocookie.com/embed/1PYIf5CCAKY" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`,
                                        icon: 'error',
                                        confirmButtonText: 'Ok, Refresh',
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        showCancelButton: false,
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = window.location.href;
                                        }
                                    });
                                }
                            });

                        video.addEventListener('canplay', function(ev) {
                            if (!streaming) {
                                height = video.videoHeight / (video.videoWidth / width);
                                if (isNaN(height)) {
                                    height = width / (4 / 3);
                                }

                                video.setAttribute('width', width);
                                video.setAttribute('height', height);
                                canvas.setAttribute('width', width);
                                canvas.setAttribute('height', height);
                                streaming = true;
                            }
                        }, false);

                        startbutton.addEventListener('click', function(ev) {
                            takepicture();
                            ev.preventDefault();
                        }, false);

                        clearphoto();
                    }

                    function clearphoto() {
                        var context = canvas.getContext('2d');
                        context.fillStyle = "#AAA";
                        context.fillRect(0, 0, canvas.width, canvas.height);

                        //var data = canvas.toDataURL('image/jpeg');
                        data_photo = canvas.toDataURL('image/jpeg');
                        //photo.setAttribute('value', data);
                    }

                    function takepicture() {
                        var context = canvas.getContext('2d');
                        if (width && height) {
                            canvas.width = width;
                            canvas.height = height;
                            context.drawImage(video, 0, 0, width, height);

                            //var data = canvas.toDataURL('image/jpeg');
                            data_photo = canvas.toDataURL('image/jpeg');
                            //photo.setAttribute('value', data);
                        } else {
                            clearphoto();
                        }
                    }

                    window.addEventListener('load', startup, false);
                })();
            </script>
            <style>
                body {
                    position: relative;
                }

                .text-responsive {
                    font-size: calc(100% + 1vw + 1vh);
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