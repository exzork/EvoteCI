<?php
foreach ($data_temp as $key => $value) {
?>
    <div class="col-md-2" id="temp_<?php echo $value['npm']; ?>">
        <div class="card h-100">
            <img class="verif-photo" onclick="view_img($(this).attr('src'));"  src="https://lh3.googleusercontent.com/d/<?php echo $value['foto_rekap']; ?>" alt="Card image" style="width:100%">
            <img class="verif-ktm" onclick="view_img($(this).attr('src'));" src="https://lh3.googleusercontent.com/d/<?php echo $value['foto_ktm']; ?>" alt="Card image" style="width:100%">
            <div class="card-body d-flex flex-column">
                <div class="mt-auto">
                    <div class="w-100 text-center">
                        <h5><?php echo $value['npm']; ?></h5>
                    </div>
                    <div class="btn-group mt-auto btn-block">
                        <button class="btn btn-success w-50" onclick="validate(<?php echo $value['npm']; ?>,1)">Valid</button>
                        <button class="btn btn-danger w-50" onclick="validate(<?php echo $value['npm']; ?>,0)">Tidak Valid</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>