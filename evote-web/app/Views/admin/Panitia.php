<table class="table table-bordered">
    <thead>
        <tr>
            <th>NPM</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($panitia_data as $panitia){?>
            <tr>
                <td><?php echo $panitia->npm;?></td>
                <td><?php echo $panitia->nama_user;?></td>
                <td><?php echo $panitia->jabatan;?></td>
                <td><button class="btn btn-warning" onclick="edit_panitia('<?php echo $panitia->kode_panitia;?>');"><i class="fas fa-edit"></i></button> <button class="btn btn-danger" onclick="remove_panitia('<?php echo $panitia->kode_panitia;?>');"><i class="fas fa-trash"></i></button></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-success" onclick="$('#add_panitia_modal').modal('show');">Tambah Panitia</button>
<div class="modal" id="add_panitia_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Tambah Panitia</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="add_panitia">
                    <div class="row mt-2">
                        <div class="col-md-3">NPM</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" oninput="get_user($(this).val());" id="add_npm_panitia" name="add_npm_panitia">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Nama</div>
                        <div class="col-md-9">
                            <input type="text" disabled class="form-control" id="add_nama_panitia" name="add_nama_panitia">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Jabatan</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="add_jabatan_panitia" name="add_jabatan_panitia">
                        </div>
                    </div>
                    <input type="hidden" name="add_event_panitia" value="<?php echo $event;?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="add_panitia();">Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="edit_panitia_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Edit Panitia</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="edit_panitia">
                    <div class="row mt-2">
                        <div class="col-md-3">NPM</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" oninput="get_user($(this).val());" id="edit_npm_panitia" name="edit_npm_panitia">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Nama</div>
                        <div class="col-md-9">
                            <input type="text" disabled class="form-control" id="edit_nama_panitia" name="edit_nama_panitia">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Jabatan</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="edit_jabatan_panitia" name="edit_jabatan_panitia">
                        </div>
                    </div>
                    <input type="hidden" name="edit_kode_panitia" id="edit_kode_panitia" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="edit_panitia_save();">Simpan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>