<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">Edit Event</div>
        <div class="modal-body">
            <form action="#" id="edit_event" enctype="multipart/form-data">
                <div class="row mt-2">
                    <div class="col-md-3">Nama Event</div>
                    <div class="col-md-9"><input type="text" class="form-control" value="<?php echo $event_data['nama_event'];  ?>" name="edit_nama_event" id="edit_nama_event"></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Deskripsi</div>
                    <div class="col-md-9"><textarea name="edit_deskripsi_event" id="edit_deskripsi_event" class="form-control"><?php echo $event_data['deskripsi'];  ?></textarea></div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Foto</div>
                    <div class="col-md-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="edit_foto_event" id="edit_foto_event">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Mulai</div>
                    <div class="col-md-9">
                        <div class="form-group">
                            <div class='input-group date' id='edit_mulai_event'>
                                <input type='text' class="form-control" name="edit_mulai_event" value="<?php echo $event_data['waktu_mulai']; ?>" />
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
                            <div class='input-group date' id='edit_selesai_event'>
                                <input type='text' class="form-control" name="edit_selesai_event" value="<?php echo $event_data['waktu_selesai']; ?>" />
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
            <button type="button" id="btnedit_event" class="btn btn-success" onclick="edit_event_save('<?php echo $event_data['kode_event'];  ?>');">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
        </div>
    </div>
</div>