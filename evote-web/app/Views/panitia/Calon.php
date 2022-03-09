<link rel="stylesheet" type="text/css" href="<?= base_url('simeditor/trumbowyg.min.css') ?>" />
<table class="table table-bordered table-datatable" id="calon_table">
    <thead>
        <tr>
            <th>Kode Calon</th>
            <th>Nama Ketua dan NPM</th>
            <th>Nama Wakil dan NPM</th>
            <th>Foto Calon</th>
            <th>Pesan</th>
            <th>Ditambahkan Oleh</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($calon_data as $calon) { ?>
            <tr>
                <td><?php echo $calon['kode_calon']; ?></td>
                <td><?php echo $calon['nama_ketua']; ?><br><?php echo $calon['npm_ketua']; ?></td>
                <td><?php echo $calon['nama_wakil']; ?><br><?php echo $calon['npm_wakil']; ?></td>
                <td><img class="img-fluid" referrerpolicy="no-referrer" src="https://lh3.googleusercontent.com/d/<?php echo $calon['foto_calon']; ?>" alt=""> </td>
                <td><?php echo $calon['pesan']; ?></td>
                <td><?php echo $calon['nama_panitia']; ?></td>
                <td>
                    <button class="btn btn-warning" onclick="edit_calon('<?php echo $calon['kode_calon']; ?>');"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" onclick="remove_calon('<?php echo $calon['kode_calon']; ?>');"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-success my-1" onclick="show_add_calon()">Tambah Calon</button>
<div class="modal" id="add_calon_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Tambah Calon</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="add_calon">
                    <div class="row mt-2">
                        <div class="col-md-3">Ketua</div>
                        <div class="col-md-9 input-group">
                            <input type="text" class="form-control" placeholder="NPM" name="add_ketua_calon" oninput="check_ketua($(this).val());">
                            <input type="text" class="form-control" placeholder="Nama" id="add_ketua_calon" required disabled>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Wakil</div>
                        <div class="col-md-9 input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" name="use_wakil" id="use_wakil" checked>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="NPM" name="add_wakil_calon" oninput="check_wakil($(this).val());">
                            <input type="text" class="form-control" placeholder="Nama" id="add_wakil_calon" disabled>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Foto</div>
                        <div class="col-md-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="add_foto_calon" id="add_foto_calon">
                                <label class="custom-file-label" for="add_foto_calon">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">Pesan</div>
                        <div class="col-md-12">
                            <textarea name="add_pesan_calon" id="add_pesan_calon" class="form-control" rows="15"></textarea>

                        </div>
                    </div>
                    <input type="hidden" name="add_event_calon" value="<?php echo $event; ?>">
                    <input type="hidden" name="add_pem_calon" value="<?php echo $pem; ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="submit_add_calon" onclick="add_calon();">Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="edit_calon_modal"></div>