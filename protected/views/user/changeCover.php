<script type="text/javascript">
    $(document).ready(function() {
        var form = $('#file_upload');
        form.change(function(event) {
            var formdata = new FormData($('#file_upload')[0]);
            $.ajax({
                beforeSend: function() {
                    $('#loading').html('<img src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif">');
                },
                type: "POST",
                url: '<?php echo Yii::app()->createUrl('user/changecover') ?>',
                data: formdata,
                success: function(data) {
                    $('#loading').html('');
                    var json = data;
                    var result = $.parseJSON(json);
                    // document.cookie = 'link='+result.message;
                    $('#cover_container').show();
                    $("#cover_container").attr("src", result.message);

                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
    });
</script>
<div class="custom_file_upload info1">

    <form class="file_upload" id ="file_upload"  action="<?php echo Yii::app()->createUrl('user/changecover') ?>" method="POST" enctype="multipart/form-data">
        <input type="file" id="file_upload_cover" name="file_upload_cover" class="">
    </form>  
</div>