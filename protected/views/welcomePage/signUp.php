
<script type="text/javascript">
    $(document).ready(function() {
        var form = $('#signupform');
        form.submit(function(event) {
            $('#res').html('');
            var data = form.serialize();
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createUrl('welcomePage/signup') ?>',
                data: data,
                success: function(data) {
                    var json = data;
                    var result = $.parseJSON(json);
                    //       $('#res').html(result.message);
                    if (result.success) {
                        var item = $('<div class="g-form-row-field">' +
                                '<div id="success" class="g-alert type_success">' +
                                '<div class="g-alert-body">' +
                                '<p><b>' + result.message + '</b></p>' +
                                '</div>' +
                                '</div>' +
                                '</div>');
                        var hide = $('#alert').css('display');
                        if (hide == 'none') {
                            $('#alert').html(item).slideDown('slow');
                        } else {
                            $('#alert').slideUp(function(){
                                $('#alert').html(item).slideDown('slow');
                            });
                        }

                    }
                    else {

                        var item = $('<div class="g-form-row-field">' +
                                '<div id="error" class="g-alert type_error">' +
                                '<div class="g-alert-body" style="text-align: center">' +
                                '<p><b>' + result.message + '</b></p>' +
                                '</div>' +
                                '</div>' +
                                '</div>');

                        var hide = $('#alert').css('display');
                        if (hide == 'none') {
                            $('#alert').html(item).slideDown('slow');
                        } else {
                            $('#alert').slideUp(function(){
                                $('#alert').html(item).slideDown('slow');
                            });
                        }
                    }
                }
            });
            event.preventDefault();
            event.stopPropagation();
            return false;
        });
    });
</script>

<div id="signuparea" class="w-tabs-section-title">
    <span class="w-tabs-section-title-text fix-g-form" style="margin: 0 0 0 5px; padding: 0">Chưa có Tài Khoản? Đăng Ký!</span>
</div>
<div class="w-tabs-section-content" style="display: none;">
    <div class="w-tabs-section-content-h">
        <div class="wpb_text_column ">
            <div class="wpb_wrapper">
                <form class="g-form" action="<?php echo Yii::app()->createUrl('welcomePage/signup') ?>" method="POST" id="signupform">
                    <input type="hidden" name="action" value="contact">
                    <div class="g-form-group">
                        <div class="g-form-group-rows">
                            <div class="g-form-row">
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <input type="text" name="contact_name" id="contact_name" value="" placeholder="Tên của bạn *">
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <input type="text" name="contact_email" id="contact_email" value="" placeholder="Email của bạn *">
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-field">
                                    <div class="g-input">
                                        <input type="password" name="Password" id="Password" value="" placeholder="Mật Khẩu *">
                                    </div>
                                </div>
                            </div>
                            <div class="g-form-row">
                                <div class="g-form-row-field">
                                    <!--                                    <div class="g-alert type_success with_close" style="position: absolute; z-index: 2; width: 89%">
                                                                            <div class="g-alert-close"> ✕ </div>
                                                                            <div class="g-alert-body">
                                                                                <p><b>Success Message</b>. Your Text Goes Here.</p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="g-alert type_error with_close" style="position: absolute; z-index: 2; width: 89%">
                                                                            <div class="g-alert-close"> ✕ </div>
                                                                            <div class="g-alert-body">
                                                                                <p><b>Success Message</b>. Your Text Goes Here.</p>
                                                                            </div>
                                                                        </div>-->
                                    <button class="g-btn type_primary" type="submit" name="Submit" value="Submit" style="width: 100%">
                                        <i class="icon-pencil"></i>
                                        Đăng Ký
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
