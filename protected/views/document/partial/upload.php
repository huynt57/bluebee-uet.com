<script>
    function checkuploadfunction() {
        alert("Bạn phải đăng nhập mới được upload, hãy bấm đăng nhập với facebook phía trên");
    }
</script>
<div class="<?php
if (Yii::app()->session["user_id"] != "")
    echo 'morph-button'
    ?> morph-button-modal morph-button-fixed" id="morph-upload">
    <button class="btn-2 btn-2a" type="button" onclick="<?php if (Yii::app()->session["user_id"] == "") echo 'checkuploadfunction();' ?>" ><i class="icon-cloud-upload"></i> Upload Tài liệu</button>

    <div class="morph-content" id="upload_area_morph" style="height: auto;">
        <div class="content-style-text">
            <span class="icon icon-close" id="close_form">✕</span>
            <h4 style="margin-bottom: 5px;">Hãy chọn một tài liệu mà bạn muốn đăng</h4>
            <script type="text/javascript">
    $(document).ready(function() {
        $('.ssa').change(function() {
            var file = this.files[0];
            var file_size = file.size / 1024;
            file_size = (Math.round(file_size * 100) / 100);
            $('.upload_button').hide();
            $('.file_name').html(' ' + file.name + ' ');
            $('.file_size').html(' - ' + file_size + 'KB');
            $('.info_file').show();
        });
        $('.cancel_file').click(function(event) {
            $('.info_file').hide();
            $('.upload_button').show();
        });
    });
            </script>
            <form method="POST" action="<?php echo Yii::app()->createUrl('document/upload') ?>" enctype="multipart/form-data" id="formscribd" data-type="iframe" data-success-event="upload-doc-success" data-load-event="upload-doc-load" data-send-event="upload-doc-send" style="height: auto">
                <p>Thông báo: Trang Web đang trong quá trình thử nghiệm đề nghị không đưa lên tài liệu quá 8MB</p>
                <label class="g-btn size_small type_primary upload_button">
                    <input class="ssa" type="file" multiple="multiple" name="file" style="display: none;" id="upload_input" />
                    <span>Chọn 1 tệp tin</span>
                </label>
                <div class="info_file" style="display: none">
                    <span class="info_file_content">
                        <span class="file_name"></span>
                        <span class="file_size"></span>
                        <span class="cancel_file" id="cancel_file">✕</span>
                    </span>
                    <span class="progress">
                        <span class="progress-inner"></span>
                    </span>
                </div>
                <input id="name_document" type="text" placeholder="Tên tài liệu" name="doc_name"/>
                <textarea id="description_document" placeholder="Mô tả" name="doc_description"></textarea>
                <select style="max-width: 200px; border-radius: 3px; background-color: white; margin: 5px 0;" name="subject_id">
                    <!--thêm môn học tại đây-->
                    <option value="">Môn học</option>
                    <?php foreach ($subject_info as $subject_info_detail) : ?>
                        <option value="<?php echo $subject_info_detail->subject_id ?>"><?php echo $subject_info_detail->subject_name ?></option>
<?php endforeach; ?>
                </select>
                <br/>
               
                <button class="g-btn size_small type_primary" type="button" onclick="__ajax(this.form)">Đăng tài liệu</button>
            </form>
            <div style="float:right; margin-top: -90px">
                <div style=" ">
                    <img id="loading-image-upload" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax-loader.gif" style="margin-left: 400px;"/>
                </div>
                <div style="display: none; background-color: red; box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); color: white; border-radius: 3px;" id="error_status">
                    <p class="clearfix" style="padding: 10px 10px 10px 10px" id="error_info">

                    </p>
                </div>
                <div style="display: none; background-color: green; box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); color: white; border-radius: 3px;" id="success_status">
                    <p class="clearfix" style="padding: 10px 10px 10px 10px" id="success_info">
                        Upload thành công
                    </p>
                </div>
            </div>
        </div>
    </div>


</div><!-- morph-button -->
<script type="text/javascript">
    $('#loading-image-upload').hide();
    $__$.on('form-upload-doc-load', function(obj) {

        $('#error_status').hide();
        $('#loading-image-upload').hide();
        $('#success_status').hide();
        $('#success_info').hide();
    });
    $__$.on('form-upload-doc-send', function(obj) {

        $('#error_status').hide();
        $('#loading-image-upload').show();
        $('#success_status').hide();
        $('#success_info').hide();
    });
    $__$.on('form-upload-doc-success', function(obj) {
        var result = obj;
        if (result.success === 0) {
            $('#error_status').show();
            $('#error_info').html(result.message);
        } else {

            $('#success_status').show().delay(3000).hide();
            $('#success_info').show().delay(3000).hide();
            $('#error_status').hide();
            $('#error_info').hide();
            $('#cancel_file').click();
            $('#formscribd')[0].reset();
            $('#close_form').click();
            $('#loading-image-upload').hide();
            $('#error_status').hide();
            $('#success_status').hide();
            $('#success_info').hide();
        }
    });
</script>
