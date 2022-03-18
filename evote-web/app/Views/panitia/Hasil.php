<div class="card w-100">
    <div class="card-header">
        <div class="card-title w-100">
            <h5 style="text-align: center;">Analisa Hasil Event</h5>
        </div>
        <div class="card-body">
            <table class="table table-stripped w-100">
                <tr>
                    <td>Jumlah Daftar Pemilih </td>
                    <td>: <?php echo $jml_dp; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Pemilih yang menggunakan suaranya</td>
                    <td>: <?php echo $jml_valid + $jml_invalid; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Pemilih yang tidak menggunakan suaranya</td>
                    <td>: <?php echo $jml_dp - ($jml_valid + $jml_invalid); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<style>
    .foto-calon {
        height: 500px;
        object-fit: cover;
        object-position: top;
    }
</style>
<?php foreach ($data_pem as $key => $data_pemilihan) : ?>
    <div class="card w-100">
        <div class="card-header">
            <div class="card-title w-100">
                <h5 style="text-align: center;"><?php echo $data_pemilihan['nama']; ?></h5>
            </div>
        </div>
        <div class="card-body row">
            <?php
            $jml_sah = 0;
            foreach ($data_pemilihan['data_calon'] as $value) {
                $jml_sah += $value['jumlah'];
            }
            ?>
            <table class="table table-stripped w-100">
                <tr>
                    <td>Jumlah Suara Sah</td>
                    <td>: <?php echo $jml_sah; ?></td>
                </tr>
                <tr>
                    <td>Jumlah Suara Tidak Sah</td>
                    <td>: <?php echo $jml_valid - $jml_sah + $jml_invalid; ?></td>
                </tr>
            </table>
            <?php foreach ($data_pemilihan['data_calon'] as $key2 => $data_calon) : ?>
                <div class="col-md-3 col-6 col-sm-6">
                    <div class="card h-100">
                        <img class="foto-calon card-img-top img-fluid" src="https://lh3.googleusercontent.com/d/<?php echo $data_calon['foto_calon']; ?>" alt="Card image" style="width:100%">
                        <div class="card-body d-flex flex-column">
                            <div class="mt-auto">
                                <h6 class="card-title w-100" style="text-align: center;"><?php echo $data_calon['nama_ketua'] . "<br>" . $data_calon['nama_wakil']; ?></h6>

                                <table class="table">
                                    <tr>
                                        <td>Jumlah</td>
                                        <td>: <?php echo  $data_calon['jumlah']; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Persentase</td>
                                        <?php if ($jml_sah == 0) : ?>
                                            <td>: 0%</td>
                                        <?php else : ?>
                                            <td>: <?php echo  round($data_calon['jumlah'] / $jml_sah * 100, 2); ?>%</td>
                                        <?php endif ?>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>