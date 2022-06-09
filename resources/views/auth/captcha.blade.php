<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <div class="captcha">
            <span>{!! captcha_img() !!}</span>
            <button type="button" class="btn btn-danger" class="reload" id="reload">
                &#x21bb;
            </button>
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-md-6 offset-md-4">
        <input id="captcha" type="text" class="form-control" placeholder="Enter Captcha" name="captcha">
    </div>
</div>

<script type="text/javascript">
    $('#reload').click(function () {
        $.ajax({
            type: 'GET',
            url: 'reload-captcha',
            success: function (data) {
                $(".captcha span").html(data.captcha);
            }
        });
    });
</script>