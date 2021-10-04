<div class="row">
    <div class="form-group col-md-3">
        <label for="formControlRange">Auto Refresh Data</label>
        <input type="range" min="1" max="10" step="1" class="form-control-range" id="m_refresh" oninput="this.nextElementSibling.value = this.value+' menit';minute_refresh=this.value;">
        <output>1 menit</output>
        <span class='float-right'>Refresh in : <span id="cd_refresh"></span></span>
    </div>
</div>
<div class="row" id="suara_temp">

</div>
<script>
    var minute_refresh = 1;
    refresh_temp();

    function refresh_temp() {
        $(".loader").removeClass('hidden');
        $.post("<?php echo base_url('panitia/verif_u/' . $event); ?>", function(data) {
            data = JSON.parse(data);
            $(".loader").addClass('hidden');
            $("#suara_temp").fadeOut();
            $("#suara_temp").html(data['html']);
            $("#suara_temp").fadeIn();
        });
        cd_refresh(minute_refresh + ":00");
        $("#m_refresh").val(minute_refresh);
        setTimeout(refresh_temp, 1000 * 60 * minute_refresh);
    }

    function cd_refresh(minute_str) {
        var interval = setInterval(function() {
            var timer = minute_str.split(":");
            var minutes = parseInt(timer[0], 10);
            var seconds = parseInt(timer[1], 10);
            --seconds;
            minutes = (seconds < 0) ? --minutes : minutes;
            if (minutes < 0) clearInterval(interval);
            seconds = (seconds < 0) ? 59 : seconds;
            seconds = (seconds < 10) ? '0' + seconds : seconds;
            $('#cd_refresh').html(minutes + ':' + seconds);
            minute_str = minutes + ':' + seconds;
        }, 1000);
    }
    function view_img(url){
        Swal.fire({
            imageUrl: url,
            imageWidth: 900,
            width:900,
        });
    }
    function validate(npm, valid) {
        var val = valid == 1 ? "Valid!" : "Tidak Valid!";
        Swal.fire({
            title: 'Apakah anda yakin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ' + val
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loader").removeClass('hidden');
                $.post("<?php echo base_url('panitia/verify/' . $event) ?>", {
                    npm: npm,
                    valid: valid
                }, function(data2) {
                    data2 = JSON.parse(data2);
                    $(".loader").addClass('hidden');
                    alert_change(data2['type'], data2['msg'], data2['timer']);
                    if (data2['timer'])
                        $("#temp_" + npm).fadeOut();
                });
            }
        });
    }
</script>