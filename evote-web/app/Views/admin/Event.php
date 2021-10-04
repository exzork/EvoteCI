<table class="table table-bordered table-datatable" id="event_table">
    <thead>
        <tr>
            <th>Kode Event</th>
            <th>Nama Event</th>
            <th>Deskripsi</th>
            <th>Foto Event</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Jumlah Pemilih</th>
            <th>Ditambahkan Oleh</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($event_data as $event) { ?>
            <tr>
                <td><?php echo $event->kode_event; ?></td>
                <td><?php echo $event->nama_event; ?></td>
                <td><?php echo $event->deskripsi; ?></td>
                <td><img class="img-fluid" src="https://lh3.googleusercontent.com/d/<?php echo $event->foto_event; ?>" alt=""> </td>
                <td><?php echo $event->waktu_mulai; ?></td>
                <td><?php echo $event->waktu_selesai; ?></td>
                <td><?php echo $event->rek_count."/".$event->dp_count; ?></td>
                <td><?php echo $event->username_admin; ?></td>
                <td>
                    <button class="btn btn-warning mt-2" onclick="edit_event('<?php echo $event->kode_event; ?>');">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger mt-2" onclick="remove_event('<?php echo $event->kode_event; ?>');">
                        <i class="fas fa-trash"></i>
                    </button>
                    <a href="<?php echo base_url('admin/panitia/' . $event->kode_event); ?>" class="btn btn-primary mt-2">Daftar Panitia</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-success" onclick="$('#add_event_modal').modal('show');">Tambah Event</button>
<div class="modal" id="add_event_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Tambah Event</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="add_event" enctype="multipart/form-data">
                    <div class="row mt-2">
                        <div class="col-md-3">Nama Event</div>
                        <div class="col-md-9"><input type="text" class="form-control" name="add_nama_event" id="add_nama_event"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Deskripsi</div>
                        <div class="col-md-9"><textarea name="add_deskripsi_event" id="add_deskripsi_event" class="form-control" ></textarea></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Foto</div>
                        <div class="col-md-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="add_foto_event" id="add_foto_event">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Mulai</div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class='input-group date' id='add_mulai_event'>
                                    <input type='text' class="form-control" name="add_mulai_event" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Selesai</div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class='input-group date' id='add_selesai_event'>
                                    <input type='text' class="form-control" name="add_selesai_event" />
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="add_event();">Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="edit_event_modal"></div>