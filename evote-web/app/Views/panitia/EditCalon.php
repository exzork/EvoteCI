<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h1>Edit Calon</h1>
        </div>
        <div class="modal-body">
            <form action="#" id="edit_calon">
                <div class="row mt-2">
                    <div class="col-md-3">Ketua</div>
                    <div class="col-md-9 input-group">
                        <input type="text" class="form-control" placeholder="NPM" name="edit_ketua_calon" oninput="check_ketua($(this).val());" value="<?php echo $data_calon[0]['npm_ketua']; ?>">
                        <input type="text" class="form-control" placeholder="Nama" id="edit_ketua_calon" required disabled value="<?php echo $data_calon[0]['nama_ketua']; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Wakil</div>
                    <div class="col-md-9 input-group">
                        <input type="text" class="form-control" placeholder="NPM" name="edit_wakil_calon" oninput="check_wakil($(this).val());" value="<?php echo $data_calon[0]['npm_wakil']; ?>">
                        <input type="text" class="form-control" placeholder="Nama" id="edit_wakil_calon" disabled value="<?php echo $data_calon[0]['nama_wakil']; ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Foto</div>
                    <div class="col-md-9">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="edit_foto_calon" id="edit_foto_calon">
                            <label class="custom-file-label" for="add_foto_calon">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-3">Pesan</div>
                    <div class="col-md-9"><textarea name="edit_pesan_calon" id="edit_pesan_calon" class="form-control" rows="15" ><?php echo $data_calon[0]['pesan']; ?></textarea></div>
                </div>
                <input type="hidden" name="edit_event_calon" value="<?php echo $data_calon[0]['event']; ?>">
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" onclick="edit_save_calon('<?php echo $data_calon[0]['kode_calon']; ?>');">Simpan</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
        </div>
    </div>
</div>