<div>
    <button onclick="$('#add_user_modal').modal('show');" class="btn btn-success form-group">Tambah User</button>
    <table class="table table-bordered table-datatable" id="table_user">
        <thead>
            <tr>
                <th>NPM</th>
                <th>Nama</th>
                <th>Email</th>
                <th style="width:10%!important;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data_user as $user) { ?>
                <tr>
                    <td><?php echo $user['npm']; ?></td>
                    <td><?php echo $user['nama_user']; ?></td>
                    <td><?php echo $user['email_user']; ?></td>
                    <td><button class="btn btn-danger" onclick="delete_user(`<?php echo $user['npm']; ?>`);"><i class="fas fa-trash"></i></button></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="modal" id="add_user_modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1>Tambah User</h1>
            </div>
            <div class="modal-body">
                <form action="#" id="add_user">
                    <div class="row mt-2">
                        <div class="col-md-3">NPM</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="add_npm_user" name="add_npm_user">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Nama</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="add_nama_user" name="add_nama_user">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-3">Email</div>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="add_email_user" name="add_email_user">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="add_user();">Tambahkan</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="$('.modal').modal('hide');">Close</button>
            </div>
        </div>
    </div>
</div>