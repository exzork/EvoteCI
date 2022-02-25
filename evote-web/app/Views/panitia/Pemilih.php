<div class="row h-100">
    <div class="col-md-6">
        <button onclick="deleteAllPemilih()" class="btn btn-danger btn-block mb-1">Hapus semua pemilih</button>
        <table class="table table-bordered table-datatable" id="pemilih_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NPM</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $x = 0;
                foreach ($data_pemilih as $pemilih) {
                    $x++; ?>
                    <tr>
                        <td><?php echo $x; ?></td>
                        <td><?php echo $pemilih['npm']; ?></td>
                        <td>
                            <button class="btn btn-danger" onclick="remove_pemilih(`<?php echo $pemilih['npm'] . '`,`' . $kode_event; ?>`);"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
    <div class="col-md-6">
        <span>Tambah NPM Ke Pemilih(NPM dipisahkan dengan newline/baris baru)</span>
        <textarea name="add_pemilih" id="add_pemilih" class="form-control" style="height: calc(100% - 70px);"></textarea>
        <button class="btn btn-success form-control" onclick="add_pemilih('<?php echo $kode_event; ?>')">Tambahkan</button>
    </div>
</div>
<div class="container">
    <button class="mt-2 btn btn-primary w-100" onclick="registerDPT()">Daftarkan DPT yang belum mendaftar.</button>
</div>
<script>
    var data_pemilih = <?php echo json_encode($data_pemilih); ?>;

    function deleteAllPemilih() {
        Swal.fire({
            title: "Apakah anda yakin untuk menghapus semua pemilih?",
            text: "Semua pemilih akan dihapus",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Hapus semua pemilih"
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo base_url('panitia/271201delete_all_pemilih2601/' . $kode_event); ?>",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        Swal.fire({
                            title: "Berhasil",
                            text: "Semua pemilih berhasil dihapus",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: "Gagal",
                            text: "Terjadi kesalahan",
                            icon: "error",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    }
                });
            }
        });
    }
    //console.log(pemilih);
    function registerDPT() {
        var done = 0;
        var total = data_pemilih.length;
        Swal.fire({
            title: "Mendaftarkan DPT",
            html: "<span id='currentDone'>0</span>/<span id='total'>" + total + "</span><br><span id='statusDone'></span>",
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function() {
                swal.disableButtons();
                const content = Swal.getContent()
                var time = 10000;
                data_pemilih.forEach(function(pemilih) {
                    setTimeout(function() {
                        $.get('<?php echo base_url('panitia/send_pemilih'); ?>/' + pemilih['npm'], function(resp) {
                            if (resp == "0") {
                                total--;
                                content.querySelector('#total').textContent = total.toString();
                                content.querySelector('#statusDone').textContent = pemilih['npm'] + " Lewati, Sudah Mendaftar";
                                if (done == total) {
                                    swal.enableButtons();
                                    content.querySelector('#statusDone').textContent = "Semua DPT telah didaftarkan";
                                }
                            } else if (resp == "1") {
                                done++;
                                content.querySelector('#currentDone').textContent = done.toString();
                                content.querySelector('#statusDone').textContent = pemilih['npm'] + " Berhasil";
                                if (done == total) {
                                    swal.enableButtons();
                                    content.querySelector('#statusDone').textContent = "Semua DPT telah didaftarkan";
                                }
                            } else {
                                resp = JSON.parse(resp);
                                alert_change(resp['type'], resp['msg'], false);
                            }
                        });
                    }, time);
                    time = +10000;
                })

            },
        });

        /*data_pemilih.forEach(function (pemilih){
            setTimeout(function (){

            },100)
        });*/

    }
</script>