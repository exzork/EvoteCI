<?php if (session()->getFlashdata('rekap')) : ?>
    <script>
        $("#card_bukti").fadeIn();
    </script>
<?php else : ?>
    <div class="container-fluid" id="content">
        <div class="card">
            <div class="card-header">
                <div class="card-title w-100">
                    <h3 style="text-align: center;" id="judul_pem"><?php echo $judul_event . " - " . $judul_pem ?></h3>
                </div>
            </div>
            <div class="card-body">
                <div class="row mt-3">
                    <?php foreach ($data_calon as $key => $calon) : ?>
                        <div class="col-md-3 col-12 col-sm-4 mt-2">
                            <div class="card h-100">
                                <img class="card-img-top img-fluid" id="img_<?php echo $calon['kode_calon']; ?>" src="https://lh3.googleusercontent.com/d/<?php echo $calon['foto_calon']; ?>" alt="Card image" style="width:100%">
                                <div class="card-body d-flex flex-column">
                                    <div class="mt-auto">
                                        <h5 class="card-title" id="nama_<?php echo $calon['kode_calon']; ?>"><?php echo $calon['nama_ketua'] . "<br>" . $calon['nama_wakil'];if($calon['nama_wakil'])echo "<br>"; ?></h5>
                                        <br><br>
                                        <button href="#" class="btn mb-2 btn-success mt-auto btn-block" onclick="pesan('<?php echo $calon['kode_calon']; ?>')">Visi Misi</button>
                                        <button href="#" class="btn mt-2 btn-primary mt-auto btn-block" onclick="pilih('<?php echo $calon['kode_calon']; ?>')">Pilih Calon Ini</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden" id="pesan_<?php echo $calon['kode_calon']; ?>">
                            <span class="text-left"><?php echo $calon['pesan']; ?></span>
                        </div>
                    <?php endforeach; ?>
                    <button class="btn btn-secondary w-100 mt-2" onclick="next('<?php echo $judul_pem;?>')">Next</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function pesan(kode) {
            var txt_calon = $("#pesan_" + kode).html();
            var img_url = $("#img_" + kode).attr('src');
            var title = $("#nama_" + kode).html();
            Swal.fire({
                width:600,
                title: "Visi & Misi",
                imageUrl: img_url,
                imageWidth: 400,
                html: txt_calon
            })
        }

        function pilih(kode) {
            var nama_calon = $("#nama_"+kode).html();
            var judul_pem=$("#judul_pem").html();
            Swal.fire({
                title: '',
                html: 'Apakah anda yakin memilih <br><b>'+nama_calon+'</b> untuk <br><b>'+judul_pem+'</b> ?',
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
        function next(text){
            Swal.fire({
                title:"Peringatan",
                html:"<b>Apakah anda yakin?<br>Anda tidak memilih pada pemilihan "+text+"</b>",
                icon:'warning',
                confirmButtonText: 'Ya, Next',
                cancelButtonText: 'Batalkan',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result)=>{
                if (result.isConfirmed) {
                    $(".loader").removeClass('hidden');
                    $.post("<?php echo base_url('user/pilih'); ?>", {
                        calon: '<?php echo $event;?>',
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
<?php
endif; ?>