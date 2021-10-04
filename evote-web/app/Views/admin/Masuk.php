<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke Panel Admin</title>
    <script src="<?php echo base_url('js/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <link rel="stylesheet" href="<?php echo base_url('css/bootstrap.min.css'); ?>">
</head>
<body>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-6">
                <h1>Masuk</h1>
                <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-danger"><?=session()->getFlashdata('msg')?></div>
                <?php endif;?>
                <form action="<?php echo base_url('admin/masuk');?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password">
                    </div>
                    <button type="submit" class="btn btn-primary">Masuk</button>
                </form>
            </div>
        </div>
    </div>
</body> 
</html> 