<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password</title>
    <link rel="icon" href="<?php echo base_url('img/logox.ico'); ?>">
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <h1>Ganti Password</h1>
                <form id="ganti_pass" action="#" oninput="result.value=(new_pass.value==confirm_new_pass.value)?'':'Password Baru tidak sama!'">
                    <div class="mb-3">
                        <label for="old_pass" class="form-label">Password Lama</label>
                        <input type="password" name="old_pass" class="form-control input_pass" id="old_pass">
                    </div>
                    <div class="mb-3">
                        <label for="new_pass" class="form-label">Password Baru</label>
                        <input type="password" name="new_pass" class="form-control input_pass" id="new_pass">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_new_pass" class="form-label">Ulangi Password Baru</label>
                        <input type="password" name="confirm_new_pass" class="form-control input_pass" id="confirm_new_pass">
                    </div>
                    <div class="mb-3">
                        <output name="result"></output>
                    </div>
                </form>
                <button type="button" onclick="ganti_pass()" class="btn btn-primary">Ganti</button>
            </div>
        </div>
    </div>
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
            var form = $("#ganti_pass").closest("form");
            var formData = new FormData(form[0]);
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