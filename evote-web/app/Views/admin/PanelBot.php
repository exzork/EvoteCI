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
                    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
                    <script type="text/javascript" src="<?= base_url('simeditor/trumbowyg.min.js') ?>"></script>
                    <script src="<?php echo base_url('js/bootstrap.bundle.min.js'); ?>"></script>
                    <script src="<?php echo base_url('js/moment.js'); ?>"></script>
                    <script src="<?php echo base_url('js/id.js'); ?>"></script>
                    <script src="<?php echo base_url('js/bootstrap-datetimepicker.js'); ?>"></script>
                    <script src="<?php echo base_url('js/adminlte.js'); ?>"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
                    <script>
                        $.trumbowyg.svgPath = "/simeditor/icons.svg"
                        $('#add_deskripsi_event').trumbowyg();

                        function show_modal_event() {
                            $('#add_event_modal').modal('show');
                            $('#add_deskripsi_event').trumbowyg();
                        }
                    </script>
                    <style>
                        table {
                            table-layout: fixed;
                            word-wrap: break-word;
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

                        .datepicker,
                        .table-datatable-condensed {
                            width: auto;
                        }
                    </style>
                    <script>
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
                            "scrollX": true
                        });
                        //event

                        function ajaxt_error() {
                            alert_change('error', 'Terjadi kesalahan, coba lagi nanti');
                            if (!$(".loader").hasClass('hidden')) {
                                $(".loader").addClass('hidden');
                            }
                        }


                        function add_event() {
                            var form = $("#add_event").closest("form");
                            var formData = new FormData(form[0]);
                            $(".loader").removeClass('hidden');
                            $("#btnadd_event").attr("disabled", true);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('admin/add_event'); ?>',
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $("#btnadd_event").attr("disabled", false);
                                    $(".loader").addClass('hidden');
                                    $("#add_event_modal").modal('hide');
                                    alert_change(data['type'], data['msg']);
                                    $.get("<?php echo base_url('admin/get_event'); ?>", function(data) {
                                        $("#main-content").html(data);
                                        dp();
                                    });
                                },
                                error: function() {
                                    $("#btnadd_event").attr("disabled", false);
                                    $(".loader").addClass('hidden');
                                    $("#add_event_modal").modal('hide');
                                    ajaxt_error();
                                }
                            });
                        }

                        function edit_event(kode) {
                            $(".loader").removeClass('hidden');
                            $.get('<?php echo base_url('admin/edit_event_v'); ?>/' + kode, function(data) {
                                $("#edit_event_modal").html(data);
                                try {
                                    $('#edit_deskripsi_event').trumbowyg();
                                } catch (e) {

                                }
                                $(".loader").addClass('hidden');
                                $("#edit_event_modal").modal('show');
                                $("#edit_mulai_event").datetimepicker({
                                    icons: {
                                        time: 'fas fa-clock-o',
                                        date: 'fas fa-calendar',
                                        up: 'fas fa-chevron-up',
                                        down: 'fas fa-chevron-down',
                                        previous: 'fas fa-chevron-left',
                                        next: 'fas fa-chevron-right',
                                        today: 'fas fa-check',
                                        clear: 'fas fa-trash',
                                        close: 'fas fa-times'
                                    },
                                    sideBySide: true,
                                });
                                $("#edit_selesai_event").datetimepicker({
                                    icons: {
                                        time: 'fas fa-clock-o',
                                        date: 'fas fa-calendar',
                                        up: 'fas fa-chevron-up',
                                        down: 'fas fa-chevron-down',
                                        previous: 'fas fa-chevron-left',
                                        next: 'fas fa-chevron-right',
                                        today: 'fas fa-check',
                                        clear: 'fas fa-trash',
                                        close: 'fas fa-times'
                                    },
                                    sideBySide: true,
                                });
                            });
                        }

                        function edit_event_save(kode) {
                            var form = $("#edit_event").closest("form");
                            var formData = new FormData(form[0]);
                            $(".loader").removeClass('hidden');
                            $("#btnedit_event").attr("disabled", true);
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('admin/edit_event'); ?>/' + kode,
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $(".loader").addClass('hidden');
                                    $("#btnedit_event").attr("disabled", false);
                                    $("#edit_event_modal").modal('hide');
                                    alert_change(data['type'], data['msg']);
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/get_event'); ?>", function(data) {
                                        $("#main-content").html(data);
                                        $(".loader").addClass('hidden');
                                        $(".table-datatable").DataTable({
                                            "autoWidth": false,
                                            "scrollX": true
                                        });
                                        dp();
                                    });
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    $(".loader").addClass('hidden');
                                    $("#btnedit_event").attr("disabled", false);
                                    $("#edit_event_modal").modal('hide');
                                    ajaxt_error();
                                }
                            });
                        }

                        function remove_event(kode) {
                            Swal.fire({
                                title: 'Apakah anda yakin?',
                                text: "Semua data panitia, calon, dan rekap pemilihan juga akan terhapus!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Hapus!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/delete_event'); ?>/" + kode, function(data) {
                                        data = JSON.parse(data);
                                        $(".loader").addClass('hidden');
                                        alert_change(data['type'], data['msg']);
                                        $(".loader").removeClass('hidden');
                                        $.get("<?php echo base_url('admin/get_event'); ?>", function(data) {
                                            $(".loader").addClass('hidden');
                                            $("#main-content").html(data);
                                            $(".table-datatable").DataTable({
                                                "autoWidth": false,
                                                "scrollX": true
                                            });
                                            dp();
                                        });
                                    });
                                }
                            })
                        }
                        $(".custom-file-input").on("change", function() {
                            var fileName = $(this).val().split("\\").pop();
                            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                        });
                        dp();

                        function dp() {
                            $("#add_mulai_event").datetimepicker({
                                icons: {
                                    time: 'fas fa-clock-o',
                                    date: 'fas fa-calendar',
                                    up: 'fas fa-chevron-up',
                                    down: 'fas fa-chevron-down',
                                    previous: 'fas fa-chevron-left',
                                    next: 'fas fa-chevron-right',
                                    today: 'fas fa-check',
                                    clear: 'fas fa-trash',
                                    close: 'fas fa-times'
                                },
                                sideBySide: true,
                            });
                            $("#add_selesai_event").datetimepicker({
                                icons: {
                                    time: 'fas fa-clock-o',
                                    date: 'fas fa-calendar',
                                    up: 'fas fa-chevron-up',
                                    down: 'fas fa-chevron-down',
                                    previous: 'fas fa-chevron-left',
                                    next: 'fas fa-chevron-right',
                                    today: 'fas fa-check',
                                    clear: 'fas fa-trash',
                                    close: 'fas fa-times'
                                },
                                sideBySide: true,
                            });
                        }
                        //panitia
                        function get_user(npm) {
                            $.get("<?php echo base_url('admin/get_user'); ?>/" + npm, function(data) {
                                data = JSON.parse(data);
                                if (data.length > 0) {
                                    $("#add_nama_panitia").val(data[0]['nama_user']);
                                    $("#edit_nama_panitia").val(data[0]['nama_user']);
                                } else {
                                    $("#add_nama_panitia").val("");
                                    $("#edit_nama_panitia").val("");
                                }
                            });
                        }

                        function add_panitia() {
                            var form = $("#add_panitia").closest("form");
                            var formData = new FormData(form[0]);
                            $(".loader").removeClass('hidden');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('admin/add_panitia'); ?>',
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    alert_change(data['type'], data['msg']);
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/get_panitia'); ?>/" + data['event'], function(data) {
                                        $("#main-content").html(data);
                                        $(".loader").addClass('hidden');
                                        $('.table-datatable-datatable').DataTable({
                                            "autoWidth": false,
                                            "scrollX": true
                                        });
                                    });
                                },
                                error: function() {
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    ajaxt_error();
                                }
                            });
                        }

                        function edit_panitia(kode) {
                            $(".loader").removeClass('hidden');
                            $.get("<?php echo base_url('admin/get_panitia_edit'); ?>/" + kode, function(data) {
                                data = JSON.parse(data);
                                $(".loader").addClass('hidden');
                                $("#edit_kode_panitia").val(data['kode_panitia']);
                                $("#edit_npm_panitia").val(data['npm_panitia']);
                                $("#edit_nama_panitia").val(data['nama_user']);
                                $("#edit_jabatan_panitia").val(data['jabatan']);
                                $("#edit_panitia_modal").modal("show");
                            });
                        }

                        function edit_panitia_save() {
                            var form = $("#edit_panitia").closest("form");
                            var formData = new FormData(form[0]);
                            $(".loader").removeClass('hidden');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('admin/edit_panitia'); ?>',
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    alert_change(data['type'], data['msg']);
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/get_panitia'); ?>/" + data['event'], function(data) {
                                        $("#main-content").html(data);
                                        $(".loader").addClass('hidden');
                                        $('.table-datatable').DataTable({
                                            "autoWidth": false,
                                            "scrollX": true
                                        });
                                    });
                                },
                                error: function() {
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    ajaxt_error();
                                }
                            });
                        }

                        function remove_panitia(kode) {
                            Swal.fire({
                                title: 'Apakah anda yakin?',
                                text: "Semua data calon yang ditambahkan panitia ini juga akan terhapus!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Hapus!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/delete_panitia'); ?>/" + kode, function(data) {
                                        data = JSON.parse(data);
                                        $(".loader").addClass('hidden');
                                        alert_change(data['type'], data['msg']);
                                        $(".loader").removeClass('hidden');
                                        $.get("<?php echo base_url('admin/get_panitia'); ?>/" + data['event'], function(data) {
                                            $("#main-content").html(data);
                                            $(".loader").addClass('hidden');
                                            $('.table-datatable').DataTable({
                                                "autoWidth": false,
                                                "scrollX": true
                                            });
                                        });
                                    });
                                }
                            })
                        }
                        //user
                        function add_user() {
                            var form = $("#add_user").closest("form");
                            var formData = new FormData(form[0]);
                            $(".loader").removeClass('hidden');
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url('admin/add_user'); ?>',
                                data: formData,
                                dataType: 'JSON',
                                processData: false,
                                contentType: false,
                                success: function(data) {
                                    console.log(data);
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    alert_change(data['type'], data['msg']);
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/list_user'); ?>", function(data) {
                                        $("#main-content").html(data);
                                        $(".loader").addClass('hidden');
                                        $('.table-datatable').DataTable({
                                            "autoWidth": false,
                                            "scrollX": true
                                        });
                                    });
                                },
                                error: function(data) {
                                    $(".loader").addClass('hidden');
                                    $(".modal").modal('hide');
                                    ajaxt_error();
                                }
                            });
                        }

                        function delete_user(npm) {
                            Swal.fire({
                                title: 'Warning!',
                                text: "Apakah anda yakin?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Ya, Hapus!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $(".loader").removeClass('hidden');
                                    $.get("<?php echo base_url('admin/delete_user'); ?>/" + npm, function(data) {
                                        data = JSON.parse(data);
                                        $(".loader").addClass('hidden');
                                        alert_change(data['type'], data['msg']);
                                        $(".loader").removeClass('hidden');
                                        $.get("<?php echo base_url('admin/list_user'); ?>", function(data) {
                                            $("#main-content").html(data);
                                            $(".loader").addClass('hidden');
                                            $('.table-datatable').DataTable({
                                                "autoWidth": false,
                                                "scrollX": true
                                            });
                                        });
                                    });
                                }
                            })
                        }
                    </script>
                    </body>

                    </html>