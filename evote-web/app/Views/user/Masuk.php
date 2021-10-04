<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Evote IF</title>
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
</head>

<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <h1>Masuk</h1>
                <?php if (session()->getFlashdata('msg')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                <?php endif; ?>
                <form action="<? echo base_url('user/masuk');?>" method="post">
                    <div class="mb-3">
                        <label for="npm" class="form-label">NPM</label>
                        <input type="text" name="npm" class="form-control" id="nama">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="npm">
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                    <span>Belum memiliki akun? <a href="<?php echo base_url('user/daftar_v'); ?>">Daftar</a></span>
                </form>
            </div>
        </div>
    </div>
</body>

</html>