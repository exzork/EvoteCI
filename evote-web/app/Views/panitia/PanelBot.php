</div>
</div>
</div>
</div>
</div>
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
<script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
<script src="<?php echo base_url('js/moment.js'); ?>"></script>
<script src="<?php echo base_url('js/id.js'); ?>"></script>
<script src="<?php echo base_url('js/bootstrap-datetimepicker.js'); ?>"></script>
<script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<style>
    table {
        table-layout: fixed;
        word-wrap: break-word;
        overflow-x: scroll;
    }

    table th,
    table td {
        overflow: hidden;
    }

    table.dataTable {
        border-collapse: collapse;
    }

    table.dataTable thead th,
    table.dataTable tfoot td,
    table.dataTable.no-footer {
        border-bottom: none;
    }

    .verif-photo {
        height: 200px !important;
    }

    .verif-ktm {
        height: 150px !important;
    }
</style>
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
    //sweet alert
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
    //datatable
    $('.table-datatable').DataTable({
        "autoWidth": false,
        "scrollX": true,
        "ordering": false
    });
    //calon
    function check_ketua(npm = "0") {
        if (npm == "") npm = "0";
        $.get("<?php echo base_url('panitia/get_user'); ?>/" + npm, function(data) {
            data = JSON.parse(data);
            if (data.length > 0) {
                $("#add_ketua_calon").val(data[0]['nama_user']);
                $("#edit_ketua_calon").val(data[0]['nama_user']);
            } else {
                $("#add_ketua_calon").val("");
            }
        });
    }

    function check_wakil(npm) {
        if (npm == "") npm = "0";
        $.get("<?php echo base_url('panitia/get_user'); ?>/" + npm, function(data) {
            data = JSON.parse(data);
            if (data.length > 0) {
                $("#add_wakil_calon").val(data[0]['nama_user']);
                $("#edit_wakil_calon").val(data[0]['nama_user']);
            } else {
                $("#add_wakil_calon").val("");
                $("#edit_wakil_calon").val("");
            }
        });
    }

    function add_calon() {
        var form = $("#add_calon").closest("form");
        $("#submit_add_calon").addClass("disabled");
        var formData = new FormData(form[0]);
        let npmWakil = formData.get("add_wakil_calon");
        let useWakil = formData.get("use_wakil");
        if (useWakil) {
            if (npmWakil == "") {
                alert_change("error", "NPM wakil tidak boleh kosong");
                $("#submit_add_calon").removeClass("disabled");
                return;
            }
        }
        $(".loader").removeClass('hidden');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('panitia/add_calon'); ?>',
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(data) {
                $("#submit_add_calon").removeClass("disabled");
                $(".loader").addClass('hidden');
                $(".modal").modal('hide');
                alert_change(data['type'], data['msg']);
                $(".loader").removeClass('hidden');
                $.get("<?php echo base_url('panitia/get_calon'); ?>/" + data['event'] + "/" + data['pem'], function(data) {
                    $("#main-content").html(data);
                    $(".loader").addClass('hidden');
                    $('.table-datatable').DataTable({
                        "autoWidth": false,
                        "scrollX": true,
                        "ordering": false
                    });
                });
            }
        });
    }

    function edit_calon(kode) {
        $(".loader").removeClass('hidden');
        $.get("<?php echo base_url('panitia/edit_calon_v'); ?>/" + kode, function(data) {
            $(".loader").addClass('hidden');
            $("#edit_calon_modal").html(data);
            $("#edit_calon_modal").modal('show');
        });
    }

    function edit_save_calon(kode) {
        var form = $("#edit_calon").closest("form");
        var formData = new FormData(form[0]);
        $("#submit_edit_calon").addClass("disabled");
        $(".loader").removeClass('hidden');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('panitia/edit_calon'); ?>/' + kode,
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(data) {
                $("#submit_edit_calon").removeClass("disabled");
                $(".modal").modal('hide');
                alert_change(data['type'], data['msg']);
                $(".loader").addClass('hidden');
                $.get("<?php echo base_url('panitia/get_calon'); ?>/" + data['event'] + "/" + data['pem'], function(data) {
                    $("#main-content").html(data);
                    $('.table-datatable').DataTable({
                        "autoWidth": false,
                        "scrollX": true,
                        "ordering": false
                    });
                });
            }
        });
    }

    function remove_calon(kode) {
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loader").removeClass('hidden');
                $.get("<?php echo base_url('panitia/delete_calon'); ?>/" + kode, function(data) {
                    $(".loader").addClass('hidden');
                    data = JSON.parse(data);
                    alert_change(data['type'], data['msg']);
                    $.get("<?php echo base_url('panitia/get_calon'); ?>/" + data['event'] + "/" + data['pem'], function(data) {
                        $("#main-content").html(data);
                        $('.table').DataTable({
                            "autoWidth": false,
                            "scrollX": true,
                            "ordering": false
                        });
                    });
                });
            }
        })
    }
    //pemilih
    function add_pemilih(kode) {
        var data_npm = $('#add_pemilih').val();
        $(".loader").removeClass('hidden');
        $.post('<?php echo base_url('panitia/add_pemilih') ?>', {
            npm: data_npm,
            event: kode
        }, function(data) {
            $(".loader").addClass('hidden');
            data = JSON.parse(data);
            alert_change(data['type'], data['msg']);
            $.get("<?php echo base_url('panitia/get_pemilih'); ?>/" + kode, function(data2) {
                $("#main-content").html(data2);
                $('.table').DataTable({
                    "autoWidth": false,
                    "scrollX": true,
                    "ordering": false
                });
            });
        })
    }

    function remove_pemilih(npm, event) {
        $(".loader").removeClass('hidden');
        $.post("<?php echo base_url('panitia/delete_pemilih') ?>/" + event, {
            npm: npm
        }, function(data) {
            $(".loader").addClass('hidden');
            data = JSON.parse(data);
            alert_change(data['type'], data['msg']);
            $.get("<?php echo base_url('panitia/get_pemilih'); ?>/" + event, function(data2) {
                $("#main-content").html(data2);
                $('.table').DataTable({
                    "autoWidth": false,
                    "scrollX": true,
                    "ordering": false
                });
            });
        });
    }

    //Pemilihan
    function add_pemilihan() {
        var form = $("#add_pemilihan").closest("form");
        var formData = new FormData(form[0]);
        $(".loader").removeClass('hidden');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('panitia/add_pemilihan'); ?>',
            data: formData,
            dataType: "JSON",
            processData: false,
            contentType: false,
            success: function(data) {
                $(".loader").addClass('hidden');
                $(".modal").modal('hide');
                alert_change(data['type'], data['msg']);
                $.get("<?php echo base_url('panitia/get_event'); ?>", function(data) {
                    $("#main-content").html(data);
                    $(".loader").addClass('hidden');
                });
            }
        });
    }

    function remove_pemilihan(kode, pem) {
        Swal.fire({
            title: 'Warning!',
            text: "Apakah anda yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loader").removeClass('hidden');
                $.post("<?php echo base_url('panitia/remove_pemilihan') ?>", {
                    event: kode,
                    pem: pem
                }, function(data) {
                    data = JSON.parse(data);
                    alert_change(data['type'], data['msg']);
                    $(".loader").addClass('hidden');
                    $.get("<?php echo base_url('panitia/get_event'); ?>", function(data) {
                        $("#main-content").html(data);
                    });
                });
            }
        });
    }
</script>
</body>

</html>