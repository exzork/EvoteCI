<table class="table table-datatable bg-light" id="event_table">
    <thead>
        <tr>
            <th>Kode Event</th>
            <th>Nama Event</th>
            <th>Deskripsi</th>
            <th>Foto Event</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($event_data as $event) { ?>
            <tr>
                <td><?php echo $event['kode_event']; ?></td>
                <td><?php echo $event['nama_event']; ?></td>
                <td><?php echo $event['deskripsi']; ?></td>
                <td><img width="200" class="img-fluid" src="https://lh3.googleusercontent.com/d/<?php echo $event['foto_event']; ?>" alt=""> </td>
                <td><?php echo $event['waktu_mulai']; ?></td>
                <td><?php echo $event['waktu_selesai']; ?></td>
                <td>
                    <a href="<?php echo base_url('panitia/pemilih/' . $event['kode_event']); ?>" class="btn btn-warning mt-2">Daftar Pemilih</a>
                    <?php if ($event['verif'] == 0 && $event['status'] == 3) : ?>
                        <a href="<?php echo base_url('panitia/verif_v/' . $event['kode_event']); ?>" class="btn btn-primary mt-2">Verifikasi</a>
                    <?php endif ?>
                    <?php if ($event['verif'] == 1 && $event['status'] == 3) : ?>
                        <a href="<?php echo base_url('panitia/hasil/' . $event['kode_event']); ?>" class="btn btn-primary mt-2">Hasil</a>
                    <?php endif ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 0" colspan="7">
                    <div><button class="btn bg-light form-control" onclick="$('#tbl_pem<?php echo $event['kode_event']; ?>').slideToggle('slow');$(this).children().toggleClass('fa-flip-vertical'); "><i class="fas fa-chevron-down"></i></button></div>
                    <div id="tbl_pem<?php echo $event['kode_event']; ?>" style="display: none">
                        <table class="table table-datatable bg-light">
                            <thead>
                                <tr>
                                    <th>Pemilihan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($event['pemilihan'] as $pemilihan) :
                                ?>
                                    <?php if ($event['status'] == 2) : ?>
                                        <tr>
                                            <td><?php echo $pemilihan['nama']; ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="<?php echo base_url('panitia/calon/' . $event['kode_event'] . "/" . $pemilihan['id']); ?>">Daftar Calon</a>
                                                <button class="btn btn-danger" onclick="remove_pemilihan('<?php echo $event['kode_event']; ?>','<?php echo $pemilihan['id']; ?>')"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php else : ?>
                                        <tr>
                                            <td><?php echo $pemilihan['nama']; ?></td>
                                            <td>
                                                <a class="btn btn-primary" href="<?php echo base_url('panitia/calon/' . $event['kode_event'] . "/" . $pemilihan['id']); ?>">Daftar Calon</a>
                                            </td>
                                        </tr>
                                    <?php endif;
                                endforeach;
                                if ($event['status'] == 2) :
                                    ?>
                                    <tr>
                                        <td colspan="2"><button class="btn btn-success form-control" onclick="$('#add_pemilihan_modal').modal('show');$('#add_pemilihan_event').val('<?php echo $event['kode_event']; ?>');">&plus;</button></td>
                                    </tr>
                                <?php endif ?>
                            </tbody>
                        </table>
                    </div>
                </td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
                <td style="display: none;"></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<div class="modal" id="add_pemilihan_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Tambah Pemilihan</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="add_pemilihan">
                    <div class="row mt-2">
                        <div class="col-md-3">Pemilihan</div>
                        <div class="col-md-9"><input type="text" class="form-control" placeholder="Nama Pemilihan" name="add_pemilihan"></div>
                        <input type="hidden" name="event" id="add_pemilihan_event">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="add_pemilihan();">Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>