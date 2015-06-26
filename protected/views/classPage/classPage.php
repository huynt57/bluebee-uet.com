<script type="text/javascript">
    $(document).ready(function() {
        $('#loading').hide();
    });
</script>

<?php foreach ($detail_classpage as $class): ?>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#loading').hide();
            var form = $('#edit-infomation-class');
            form.submit(function(event) {
                var data = form.serialize();
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createUrl('classPage/changeClassInformation?classid=' . $class->class_id) ?>',
                    data: data,
                    success: function(data) {
                        
                        var result = $.parseJSON(json);
                        $('#alert1').html('');
                        if (result.success == 1) {
                            var item = $('<div class="g-form-row-field">' +
                                    '<div id="success" class="g-alert1 type_success">' +
                                    '<div class="g-alert1-body">' +
                                    '<p><b>' + result.message + '</b></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>');
                            var hide = $('#alert1').css('display');
                            if (hide == 'none') {
                                $('#alert11').html(item).slideDown('slow');
                            } else {
                                $('#alert11').slideUp(function() {
                                    $('#alert11').html(item).slideDown('slow');
                                });
                            }
                        }
                        else {
                            var item = $('<div class="g-form-row-field">' +
                                    '<div id="error" class="g-alert1 type_error">' +
                                    '<div class="g-alert1-body" style="text-align: center">' +
                                    '<p><b>' + result.message + '</b></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>');
                            var hide = $('#alert1').css('display');
                            if (hide == 'none') {
                                $('#alert1').html(item).slideDown('slow');
                            } else {
                                $('#alert1').slideUp(function() {
                                    $('#alert1').html(item).slideDown('slow');
                                });
                            }
                        }
                    }});
            });
        });
    </script>
    <script type="text/javascript">
        function copyContent() {
            var $div = $('#myContentEditable div');
            $div.replaceWith(function() {
                return $('<p/>', {html: this.innerHTML});
            });
            document.getElementById("hiddenTextarea").value =
                    document.getElementById("myContentEditable").innerHTML;
            $('#myContentEditable').html('');
            return true;
        }
        $(document).ready(function() {
            $('#loading').hide();
            var post = $('#post_form');
            post.submit(function(event) {
                event.preventDefault();
                var data = post.serialize();
                $.ajax({
                    beforeSend: function() {
                        $('#loading').show();
                    },
                    type: 'POST',
                    url: '<?php echo Yii::app()->createUrl('classPage/createPost') ?>',
                    data: data,
                    success: function(dataview) {               
                        
                        var json = dataview;
                        var result = $.parseJSON(json);
                        var item = $('<div style="margin-top: 20px; background-color: white">' +
                                '<div class="activity-item">' +
                                '<a class="other-user-avatar" href="#">' +
                                '<img class="" width="50" height="50" src="<?php
    if (Yii::app()->session['user_avatar'] == "") {
        echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
    } else {
        echo Yii::app()->session['user_avatar'];
    }
    ?>" style="opacity: 1; height: 50px;">' +
                                '</a>' +
                                '<div  class="profile clearfix">' +
                                '<a style="float: left" href="#">' +
                                '<span data-paths="profile.firstName profile.lastName" id="el-105"><?php echo Yii::app()->session['user_real_name'] ?></span>' +
                                '</a>' +
                                '<p style="color: #dadcdd; float: left">&nbsp;&nbsp;12 hours ago</p>' +
                                '</div>' +
                                '<article data-paths="body" id="el-99">' +
                                '<p>' + result.message + '</p>' +
                                '</article>' +
                                '<div class="comment-container">' +
                                '<div class="list-item-comment-wrapper-' + result.post_id + '" >' +
                                '</div>' +
                                '</div>' +
                                '<form class="comment-form" id="comment-form-' + result.post_id + '" action ="<?php echo Yii::app()->createUrl('classPage/createComment?class_id=' . $class->class_id . '&post_id=') ?>' + result.post_id + '" method="post">'+
                                    '<div class="item-add-comment-box">'+
                                        '<a class="avatar-view fix-avatar-view" href="#">'+
                                            '<img class="" width="35" height="35" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/default-avatar.png" style="opacity: 1;">'+
                                        '</a>'+
                                        '<div class="comment-input-box">'+
                                            '<div contenteditable="true" class="comment-input-content" data-placeholder="Bình luận?"></div>'+
                                            '<textarea class="none-display text_comment_hidden" name="comment_content"></textarea>'+
                                        '</div>'+
                                    '</div>'+
                                '</form>'+
                                '</div>' +
                                '</div>').hide().fadeIn(800);
                        $('#activity_content').prepend(item);
                        $('#loading').hide();
                       
                        $('.opencmt').click(function(event) {
                            var current = $(this);
                            var hide = current.next().css('display');
                            if (hide == 'none') {
                                $(this).html('<span>Đóng</span>');
                                current.next().slideDown('slow', function() {
                                });
                            } else {
                                $(this).html('<span>Xem thêm</span>');
                                current.next().slideUp();
                            }
                        });
                        
                        
                // comment right after post
                $('.comment-input-box').each(function() {
                var text_comment_hidden = $(this).find('textarea.text_comment_hidden');
                var comment_input_content = $(this).find('.comment-input-content');
                comment_input_content.keypress(function(e) {
                    if (e.which === 13 && !e.shiftKey) {                               
                        var $div = comment_input_content.find('div');
                        $div.replaceWith(function() {
                            return $('<p/>', {html: this.innerHTML});
                        });
//                        document.getElementById("text_comment_hidden").value =
//                                document.getElementById("text_comment_display").innerHTML;
                        //alert(comment_input_content.html());
                        text_comment_hidden.val(comment_input_content.html());
                        comment_input_content.html('');
                        var form = $(this).parents(".comment-form");
                        var id = form.attr("id");
                        var data = form.serialize();
                        $.ajax({
                            type: "POST",
                            url: form.attr('action'),
                            data: data,
                            success: function(data) {
                                var json = data;
                                var result = $.parseJSON(json);
                                if (result.success) {
                                    var item2 = $('<div class="item-comment">' +
                                            '<a class="avatar-view-user" href="/sancak" style="width: 40px; height: 40px; background-size: 40px; background-image: none;">' +
                                            '<img class="" width="40" height="40" src="<?php
    if (Yii::app()->session['user_avatar'] == "") {
        echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
    } else {
        echo Yii::app()->session['user_avatar'];
    }
    ?>" style="opacity: 1;">' +
                                            '</a>' +
                                            '<div class="comment-content">' +
                                            '<div  class="fix-style-profile profile clearfix">' +
                                            '<a style="float: left" href="<?php echo Yii::app()->createUrl("user?token=" . Yii::app()->session['token']) ?>" ' +
                                            '<span data-paths="profile.firstName profile.lastName" id="el-105"><?php echo Yii::app()->session['user_real_name'] ?></span>' +
                                            '</a>' +
                                            '<p style="color: #dadcdd; float: left">&nbsp;&nbsp;16 hours ago</p>' +
                                            '</div>' +
                                            '<div class="comment-body-container">' +
                                            '<p data-paths="body" id="el-1140">' + result.comment_content + '</p>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>').hide().fadeIn(800);
                                    $(".list-item-comment-wrapper-" + result.comment_post_id).append(item2);
                                    document.getElementById("comment-form-" + result.comment_post_id).reset();
                                    $('#more-comment-' + result.comment_post_id).hide();
                                    //show comment if comment is closing
                                    var opencmt = $('#opencmt-' + result.comment_post_id);
                                    var hide_state = opencmt.next().css('display');
                                    if (hide_state == "none") {
                                        $(this).html('<span>Đóng</span>');
                                        opencmt.next().slideDown('slow', function() {
                                        });
                                    }
                                    ;
                                    //add function close comment after prepend new comment                         
                                } else {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    };
                });
                });
                    },
                    error: function(event) {
                        console.log(dataview);
                        alert(event);
                    }
                });
                              
            });
        });
    </script>

    <script type="text/javascript">
        //        function pressed(e, element) {
        //            if ( (window.event ? event.keyCode : e.which) === 13) { 
        //                // If it has been so, manually submit the <form>
        //                element.parents(".comment-form").submit();
        //            }
        //        }
        $(document).ready(function() {
            $('.comment-input-box').each(function() {
                var text_comment_hidden = $(this).find('textarea.text_comment_hidden');
                var comment_input_content = $(this).find('.comment-input-content');
                comment_input_content.keypress(function(e) {
                    if (e.which === 13 && !e.shiftKey) {
                        var $div = comment_input_content.find('div');
                        $div.replaceWith(function() {
                            return $('<p/>', {html: this.innerHTML});
                        });
//                        document.getElementById("text_comment_hidden").value =
//                                document.getElementById("text_comment_display").innerHTML;
                        //alert(comment_input_content.html());
                        text_comment_hidden.val(comment_input_content.html());
                        comment_input_content.html('');
                        var form = $(this).parents(".comment-form");
                        var id = form.attr("id");
                        var data = form.serialize();
                        $.ajax({
                            type: "POST",
                            url: form.attr('action'),
                            data: data,
                            success: function(data) {
                                var json = data;
                                var result = $.parseJSON(json);
                                if (result.success) {
                                    var item = $('<div class="item-comment">' +
                                            '<a class="avatar-view-user" href="/sancak" style="width: 40px; height: 40px; background-size: 40px; background-image: none;">' +
                                            '<img width="40" height="40" src="<?php
    if (Yii::app()->session['user_avatar'] == "") {
        echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
    } else {
        echo Yii::app()->session['user_avatar'];
    }
    ?>" style="opacity: 1; height: 40px;">' +
                                            '</a>' +
                                            '<div class="comment-content">' +
                                            '<div  class="fix-style-profile profile clearfix">' +
                                            '<a style="float: left" href="#">' +
                                            '<span data-paths="profile.firstName profile.lastName" id="el-105"><?php echo Yii::app()->session['user_real_name'] ?></span>' +
                                            '</a>' +
                                            '<p style="color: #dadcdd; float: left">&nbsp;&nbsp;16 hours ago</p>' +
                                            '</div>' +
                                            '<div class="comment-body-container">' +
                                            '<p data-paths="body" id="el-1140">' + result.comment_content + '</p>' +
                                            '</div>' +
                                            '</div>' +
                                            '</div>').hide().fadeIn(800);
                                    $(".list-item-comment-wrapper-" + result.comment_post_id).append(item);
                                    document.getElementById("comment-form-" + result.comment_post_id).reset();
                                    $('#more-comment-' + result.comment_post_id).hide();
                                    //show comment if comment is closing
                                    var opencmt = $('#opencmt-' + result.comment_post_id);
                                    var hide_state = opencmt.next().css('display');
                                    if (hide_state == "none") {
                                        $(this).html('<span>Đóng</span>');
                                        opencmt.next().slideDown('slow', function() {
                                        });
                                    }
                                    ;
                                    //add function close comment after prepend new comment                         
                                } else {
                                    alert(result.message);
                                }
                            }
                        });
                        return false;
                    }
                    ;
                });
            });
        });
    </script>
    <form class="g-form white-popup-block mfp-hide" id="edit-infomation-class" action="" method="POST">
        <h3>Chỉnh Sửa Thông Tin</h3>
        <div class="g-form-group">
            <div class="g-form-group-rows">
                <div class="g-form-row">
                    <div class="g-form-row-label">
                        <label class="g-form-row-label-h" for="classcode">Mã lớp (*)</label>
                    </div>
                    <div class="g-form-row-field">
                        <div class="g-input">
                            <input type="text" name="classcode" id="contact_username" placeholder="Mã lớp" value="">
                        </div>
                    </div>
                </div>
                <div class="g-form-row">
                    <div class="g-form-row-label">
                        <label class="g-form-row-label-h" for="classname">Tên lớp (*)</label>
                    </div>
                    <div class="g-form-row-field">
                        <div class="g-input">
                            <input type="text" name="classname" id="contact_username" placeholder="Tên lớp" value="">
                        </div>
                    </div>
                </div>
                <div class="g-form-row">
                    <div class="g-form-row-label">
                        <label class="g-form-row-label-h" for="classCredit">Số tín chỉ (*)</label>
                    </div>
                    <div class="g-form-row-field">
                        <div class="g-input">
                            <input type="text" name="classCredit" id="contact_username" placeholder="Số tín chỉ" value="">
                        </div>
                    </div>
                </div>
                <div class="g-form-row">
                    <div class="g-form-row-label">
                        <label class="g-form-row-label-h" for="classWebsite">Website Môn học (*)</label>
                    </div>
                    <div class="g-form-row-field">
                        <div class="g-input">
                            <input type="text" name="classWebsite" id="contact_username" placeholder="Website Môn học" value="">
                        </div>
                    </div>
                </div>
                <div class="g-form-group">
                    <div class="g-form-row-label">
                        <label class="g-form-row-label-h" for="description">Miêu tả (*)</label>
                    </div>
                    <div class="g-form-group-rows">
                        <div class="g-form-row">
                            <div class="g-form-row-field">
                                <textarea name="description" id="input1x3" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-form-row">
                    <div class="g-form-row-field">
                        <button class="g-btn type_primary" type="submit" name="Submit" value="Submit" style="text-transform: inherit" action="">Lưu thông tin</button>
                    </div>
                </div>

            </div>
            <div id="alert11"></div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            var urlstring = window.location;
            var realurlstring = urlstring.toString();
            var classid = realurlstring.substr(realurlstring.lastIndexOf('=') + 1);
            $('#class_id_post').val(classid);
        });
    </script>
    <?php $this->renderPartial('updateinfoclass') ?>



    <div class="l-submain-h i-cf">
        <div class="l-content">
            <div class="l-content-h i-widgets">
                <div class="g-cols">

                    <div class="full-width">
                        <div class="view2 effect1">

                            <img class="round_ava" src="<?php echo Yii::app()->createUrl($class->class_cover); ?>"/>
                            <div class="content-3">
                                <?php $this->renderPartial('changeCover') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="g-cols">
                    <div class="two-thirds">
                        <!-- w-tabs -->
                        <div class="w-tabs">
                            <div class="w-tabs-h" id="fix-style-w-tab">
                                <div class="w-tabs-list">
                                    <div class="w-tabs-item fix-w-tab-item active">
                                        <span class="w-tabs-item-icon"></span>
                                        <span class="w-tabs-item-title">Hoạt động</span>
                                    </div>

                                    <div class="w-tabs-item fix-w-tab-item">
                                        <span class="w-tabs-item-icon"></span>
                                        <span class="w-tabs-item-title">Documents</span>
                                    </div>
                                    <div class="w-tabs-item fix-w-tab-item">
                                        <span class="w-tabs-item-icon"></span>
                                        <span class="w-tabs-item-title">Giáo viên</span>
                                    </div>
                                </div>

                                <div class="w-tabs-section active">
                                    <div class="w-tabs-section-title">
                                        <span class="w-tabs-section-title-icon"></span>
                                        <span class="w-tabs-section-title-text">Hoạt động</span>
                                        <span class="w-tabs-section-title-control"></span>
                                    </div>

                                    <div class="w-tabs-section-content" style=" background-color: #ebf0f0; min-height: 500px">
                                        <div class="w-tabs-section-content-h" style="padding-top: 0px;">
                                            <div class="activity-input">
                                                <a class="avatar-view" href="user">
                                                    <img class="" width="50" height="50" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/default-avatar.png" style="opacity: 1; height: 50px">
                                                </a>
                                                <form class="activity-input-box" id="post_form" onsubmit='return copyContent()' action ="<?php echo Yii::app()->createUrl('classPage/createpost') ?>" method="post">
                                                    <div contenteditable="true" id="myContentEditable" class="activity-input-content" data-placeholder="Có Gì Hot?"></div>
                                                    <input type="hidden" id="class_id_post" name="class_id_post">
                                                    <textarea id="hiddenTextarea" name ="post_content" style="display:none"></textarea>
                                                    <button type="submit" class="g-btn type_primary size_small submit-button">
                                                        <span>Đăng Tin</span>
                                                    </button>
                                                </form>
                                            </div>
                                            <div style="border-top: 1px solid #d8d8d8;">
                                                <div id="loading" style="margin-left: 324px"> <img class="w-blog-entry-img-h" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax-loader.gif" alt="" style="" id=""></div>
                                                <div class="activity-content" id="activity_content">   
                                                    <?php foreach ($post as $post): $number_comment = 0; ?>

                                                        <div style="margin-top: 20px; background-color: white">
                                                            <div class="activity-item">
                                                                <?php foreach ($postUser as $user):
                                                                    if ($user->user_id == $post->post_author): ?>
                                                                <a class="other-user-avatar" href="#">
                                                                    <img class="" width="50" height="50" src="<?php echo $user->user_avatar; ?>" style="opacity: 1; height: 50px">
                                                                </a>
                                                                <div  class="profile clearfix">
                                                                    <a style="float: left" href="#">
                                                                        <span data-paths="profile.firstName profile.lastName" id="el-105"><?php echo $user->user_real_name ?></span>
                                                                    </a>
                                                                    <i class="icon-time" style="float: left; margin-top: 5px; margin-left: 15px; color: #dadcdd;"></i>
                                                                    <p style="color: #dadcdd; float: left">&nbsp;12 hours ago</p>
                                                                    <!-- <a class="fix-vote-button"><i class="icon-chevron-right"></i></a>
                                                                    <p style="float: right"><strong>&nbsp; 69 &nbsp;</strong></p>
                                                                    <a class="fix-vote-button"><i class="icon-chevron-left"></i></a> -->
                                                                </div>
                                                                <?php endif; ?>
                                                                <?php endforeach; ?>
                                                                <article data-paths="body" id="el-99">
                                                                    <p><?php echo $post->post_content ?></p>
                                                                </article>
                                                                <div class="vote none-display">
                                                                    <a><i class="icon-thumbs-up"></i></a>
                                                                    <p style="color: #dadcdd">1&nbsp;</p>
                                                                    <a><i class="icon-thumbs-down"></i></a>
                                                                    <p style="color: #dadcdd">2&nbsp;</p>
                                                                </div>
                                                                <button class=" g-btn type_primary size_small opencmt button-in-activity-box" id="opencmt-<?php echo $post->post_id ?>"><i class="icon-chevron-down"></i><span>&nbsp;Xem thêm</span></button>
                                                                <div class="comment-container">
                                                                    <div class="list-item-comment-wrapper-<?php echo $post->post_id ?>">
        <?php
        foreach ($comment_array as $comment):
            if ($post->post_id == $comment->comment_post_id):
                $number_comment = $number_comment + 1;
                ?>
                                                                        
                                                                                <div class="item-comment" id="item-comment-<?php echo $post->post_id ?>">
                                                                                    <?php foreach ($postUser as $user):
                                                                                          if ($user->user_id === $comment->comment_author_id): ?>
                                                                                    <a class="avatar-view-user" href="/sancak" style="width: 40px; height: 40px; background-size: 40px; background-image: none;">
                                                                                        <img class="" width="40" height="40" src="<?php echo $user->user_avatar;?>" style="opacity: 1; height: 40px">

                                                                                    </a>
                                                                                    <div class="comment-content">
                                                                                        <div  class="fix-style-profile profile clearfix">
                                                                                            <a style="float: left" href="#">
                                                                                                <span data-paths="profile.firstName profile.lastName" id="el-105"><?php echo $user->user_real_name ?></span>
                                                                                            </a>
                                                                                            <p style="color: #dadcdd; float: left">&nbsp;&nbsp;16 hours ago</p>
                                                                                        </div>
                                                                                        <div class="comment-body-container">
                                                                                            <p data-paths="body" id="el-1140"><?php echo $comment->comment_content ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                    <?php endif; ?>
                                                                                    <?php endforeach; ?>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </div>
                                                                    <?php if ($number_comment >= 2): ?>
                            <!--                                                                    <button class=" g-btn type_primary size_small more-comment button-in-activity-box" id="more-comment-//<?php echo $post->post_id ?>"><span>Xem thêm <?php echo ($number_comment - 1) ?> bình luận nữa</span></button>-->
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <form class="comment-form" id="comment-form-<?php echo $post->post_id ?>" action ="<?php echo Yii::app()->createUrl('classPage/createComment?class_id=' . $class->class_id . '&post_id=' . $post->post_id) ?>" method="post">
                                                                <div class="item-add-comment-box">
                                                                    <a class="avatar-view fix-avatar-view" href="user">
                                                                        <img class="" width="35" height="35" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/default-avatar.png" style="opacity: 1; height: 35px">
                                                                    </a>
                                                                    <div class="comment-input-box">
                                                                        <div contenteditable="true" class="comment-input-content" data-placeholder="Bình luận?"></div>                                
                                                                        <textarea class="none-display text_comment_hidden" name="comment_content"></textarea>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-tabs-section">
                                    <div class="w-tabs-section-title">
                                        <span class="w-tabs-section-title-icon"></span>
                                        <span class="w-tabs-section-title-text">Documents</span>
                                        <span class="w-tabs-section-title-control"></span>
                                    </div>
                                    <div class="w-tabs-section-content">
                                        <div class="w-tabs-section-content-h" disabled="disabled">
                                            <!--<p>'<script>alert('123');</script>'</p>-->
                                        </div>
                                    </div>
                                </div>

                                <div class="w-tabs-section">
                                    <div class="w-tabs-section-title">
                                        <span class="w-tabs-section-title-icon"></span>
                                        <span class="w-tabs-section-title-text">Giáo viên</span>
                                        <span class="w-tabs-section-title-control"></span>
                                    </div>
                                    <script>
                                        var json = {
                                            "people": {
                                                "person": [{
                                                        "name": "Sơn Vũ",
                                                        "id": "1"},
                                                    {
                                                        "name": "Sơn Vũ 2",
                                                        "id": "2"},
                                                    {
                                                        "name": "Sơn Vũ 3",
                                                        "id": "3"}]
                                            }
                                        };
                                        $(document).ready(function() {
                                            $('a#add-teacher').click(function() {
                                                var hide = $('.current-list').css('display');
                                                if (hide != 'none') {
                                                    $('.search-input').slideToggle();
                                                    $('.current-list').fadeOut('fast');
                                                    $('.suggest-list').delay(800).fadeIn(800);
                                                    $('.suggest-info').fadeOut(800, function() {
                                                        search_teacher();
                                                        $(this).html('<p>Tổng số giáo viên được gợi ý: ' + json.people.person.length + '</p>').fadeIn(800)
                                                    });
                                                    $('a#add-teacher').html('<p id="add-teacher-contents">Thêm giáo viên <span style="font-size: 20px"> ✕ </span></p>');
                                                } else {
                                                    $('.add-new-teacher').hide();
                                                    $('.search-input').slideToggle();
                                                    $('.suggest-list').fadeOut('fast');
                                                    $('.current-list').delay(800).fadeIn(800);
                                                    $('.suggest-info').fadeOut('fast', function() {
                                                        $(this).delay(800).html('<p>Tổng số giáo viên: 1</p>').fadeIn(800)
                                                    });
                                                    $(".search-input-box").val('');
                                                    $('.suggest-teacher').show();
                                                    $('a#add-teacher').html('<p id="add-teacher-contents">Thêm giáo viên <i class="icon-plus"></i></p>');
                                                }
                                            });
                                        });
                                        (function($) {
                                            "use strict";

                                            $.fn.RemoveResult = function() {
                                                Array.prototype.removeValue = function(name, value) {
                                                    var array = $.map(this, function(v, i) {
                                                        return v[name] === value ? null : v;
                                                    });
                                                    this.length = 0; //clear original array
                                                    this.push.apply(this, array); //push all elements except the one we want to delete
                                                }

                                                return this.each(function() {
                                                    var result = $(this),
                                                            close = result.find('.add-to-this-class');
                                                    if (close) {
                                                        close.click(function() {
                                                            var teacher_id = result.attr('id');
                                                            $.ajax({
                                                                type: "POST",
                                                                url: "<?php echo Yii::app()->createUrl('classPage/addTeacher?class_id=' . $class->class_id . '&teacher_id=') ?>" + teacher_id + "&found_result=1",
                                                                data: "",
                                                                success: function(data) {
                                                                    var json = data;
                                                                    var result = $.parseJSON(json);
                                                                }
                                                            });

                                                            result.animate({height: '0', margin: 0}, 400, function() {
                                                                var id = result.attr('id');
                                                                result.css('display', 'none');
                                                                result.remove();
                                                                json.people.person.removeValue('id', id);
                                                                search_teacher();
                                                            });
                                                        });
                                                    }
                                                });
                                            };
                                        })(jQuery);

                                        jQuery(document).ready(function() {
                                            "use strict";

                                            jQuery('.suggest-teacher').RemoveResult();
                                        });
                                        function search_teacher() {
                                            var num_display = 0;
                                            $('.add-new-teacher').hide();
                                            var value = $(".search-input-box").val();
                                            if (value.length != 0) {
                                                $('.suggest-teacher').hide();
                                                $.each(json.people.person, function(i, v) {
                                                    if (v.name.search(new RegExp(value + "", "i")) != -1) {
                                                        var id = "#" + v.id;
                                                        $(id).show();
                                                        num_display++;
                                                        return;
                                                    }
                                                });
                                                $('.suggest-info').html('<p>Tổng số giáo viên được gợi ý: ' + num_display + '</p>');
                                                if (num_display == 0 || json.people.person.length == 0) {
                                                    $('.add-new-teacher').show();
                                                }
                                            } else {
                                                $('.suggest-info').html('<p>Tổng số giáo viên được gợi ý: ' + json.people.person.length + '</p>');
                                                $('.suggest-teacher').show();
                                            }
                                            if (json.people.person.length == 0) {
                                                $('.add-new-teacher').show();
                                            }
                                        }
                                        $(function() {
                                            $(".search-input-box").keyup(function() {
                                                search_teacher();
                                            });
                                        });
                                    </script>
                                    <div class="w-tabs-section-content">
                                        <div class="w-tabs-section-content-h" style="padding-top: 10px">
                                            <div class="g-cols" style="margin-left: 10px; margin-right: 10px; position: relative;">
                                                <div class="navigation-teacher-tab clearfix">
                                                    <div class="float-left suggest-info"><p>Tổng số giáo viên: 1</p></div>
                                                    <div class="float_right">
                                                        <a id="add-teacher" style="margin-top: 10px" href="javascript:void(0)"><p id="add-teacher-contents">Thêm giáo viên <i class="icon-plus"></i></p></a>
                                                    </div>
                                                    <div class="float_right search-input" style="margin-right: 20px; display: none"><input class="search-input-box" type="text" placeholder="gõ tên 1 giáo viên vào đây" style="height: 24px; background-color: white;"></div>
                                                </div>
                                                <div class="add-new-teacher" style="display: none">
                                                    <h2 style="text-align: center; margin-top: 40px;">Không tìm thấy giáo viên</h2>
                                                    <a class="g-btn type_primary popup-with-form" style="text-transform: none; font-weight: normal; margin-left: 200px" href="#add-brand-new-teacher"><i class="icon-plus"></i>Thêm giáo viên mới</a>
                                                    <?php $this->renderPartial('formaddteacher') ?>
                                                </div>
                                                <div class="current-list">
                                                    <div class="result-teacher clearfix" style="margin: 0px">
                                                        <a class="search-avatar-view relative float-left" href="user" style="margin-top: 5px">
                                                            <img width="70" height="70" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ava_son.png" style="opacity: 1; height: 70px">
                                                        </a>
                                                        <div class="info">
                                                            <a href="#">
                                                                <span id="el-105">Sơn Vũ</span>
                                                            </a>
                                                            <p>Học vị: PGS.TS</p>
                                                            <p>Nơi công tác: Đại học công nghệ - Đại học quốc gia Hà Nội</p>
                                                            <p>Môn dạy: A, B,...</p>
                                                        </div>
                                                        <div class="float_right">
                                                            <div class="input select rating-f read-only">
                                                                <p style="float: left">Độ yêu thích:</p>
                                                                <br>
                                                                <select class="teacher-block-rating-outside" name="rating" style="display: none; float: right">
                                                                    <option value="1" selected="selected">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5">5</option>
                                                                </select>
                                                            </div>
                                                            <button class="g-btn type_primary size_small float_right none-display" style="text-transform: none; font-weight: normal; width: 120px"><i class="icon-comment"></i>Ý kiến</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="suggest-list">
                                                    <div class="suggest-teacher clearfix" style="margin: 0px" id="1">
                                                        <a class="search-avatar-view relative float-left" href="user" style="margin-top: 5px">
                                                            <img width="70" height="70" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ava_son.png" style="opacity: 1; height: 70px">
                                                        </a>
                                                        <div class="info">
                                                            <a href="#">
                                                                <span id="el-105">Sơn Vũ</span>
                                                            </a>
                                                            <p>Học vị: PGS.TS</p>
                                                            <p>Nơi công tác: Đại học công nghệ - Đại học quốc gia Hà Nội</p>
                                                            <p>Môn dạy: A, B,...</p>
                                                        </div>
                                                        <div class="float_right">
                                                            <div class="input select rating-f read-only">
                                                                <p style="float: left">Độ yêu thích:</p>
                                                                <br>
                                                                <select class="teacher-block-rating-outside" name="rating" style="display: none; float: right">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5" selected="selected">5</option>
                                                                </select>
                                                            </div>
                                                            <button class="add-to-this-class g-btn type_primary size_small float_right" style="text-transform: none; font-weight: normal; width: 120px"><i class="icon-plus"></i>Thêm vào lớp</button>
                                                        </div>
                                                    </div>
                                                    <div class="suggest-teacher clearfix" style="margin: 0px" id="2">
                                                        <a class="search-avatar-view relative float-left" href="user" style="margin-top: 5px">
                                                            <img width="70" height="70" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ava_son.png" style="opacity: 1; height: 70px">
                                                        </a>
                                                        <div class="info">
                                                            <a href="#">
                                                                <span id="el-105">Sơn Vũ 2</span>
                                                            </a>
                                                            <p>Học vị: PGS.TS</p>
                                                            <p>Nơi công tác: Đại học công nghệ - Đại học quốc gia Hà Nội</p>
                                                            <p>Môn dạy: A, B,...</p>
                                                        </div>
                                                        <div class="float_right">
                                                            <div class="input select rating-f read-only">
                                                                <p style="float: left">Độ yêu thích:</p>
                                                                <br>
                                                                <select class="teacher-block-rating-outside" name="rating" style="display: none; float: right">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5" selected="selected">5</option>
                                                                </select>
                                                            </div>
                                                            <button class="add-to-this-class g-btn type_primary size_small float_right" style="text-transform: none; font-weight: normal; width: 120px"><i class="icon-plus"></i>Thêm vào lớp</button>
                                                        </div>
                                                    </div>
                                                    <div class="suggest-teacher clearfix" style="margin: 0px" id="3">
                                                        <a class="search-avatar-view relative float-left" href="user" style="margin-top: 5px">
                                                            <img width="70" height="70" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ava_son.png" style="opacity: 1; height: 70px">
                                                        </a>
                                                        <div class="info">
                                                            <a href="#">
                                                                <span id="el-105">Sơn Vũ 3</span>
                                                            </a>
                                                            <p>Học vị: PGS.TS</p>
                                                            <p>Nơi công tác: Đại học công nghệ - Đại học quốc gia Hà Nội</p>
                                                            <p>Môn dạy: A, B,...</p>
                                                        </div>
                                                        <div class="float_right">
                                                            <div class="input select rating-f read-only">
                                                                <p style="float: left">Độ yêu thích:</p>
                                                                <br>
                                                                <select class="teacher-block-rating-outside" name="rating" style="display: none; float: right">
                                                                    <option value="1">1</option>
                                                                    <option value="2">2</option>
                                                                    <option value="3">3</option>
                                                                    <option value="4">4</option>
                                                                    <option value="5" selected="selected">5</option>
                                                                </select>
                                                            </div>
                                                            <button class="add-to-this-class g-btn type_primary size_small float_right" style="text-transform: none; font-weight: normal; width: 120px"><i class="icon-plus"></i>Thêm vào lớp</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="one-third">
                        <h3 style="margin-top: 20px">Lớp: <br><?php echo $class->class_name ?></h3>
                        <p style="float: left" id="show"><strong>Mã Môn Học: </strong><?php echo $class->class_code ?></p>
                        <a style="float: right; margin-top: 0" href="#edit-infomation-class" class="popup-with-form">
                            Chỉnh Sửa
                            <i class="icon-pencil"></i>
                        </a>
                        <p style="clear: both"><strong>Số tín chỉ: </strong> <?php echo $class->class_credit_number ?></p>
                        <p><strong>Website Môn Học: </strong> <a href="bluebee-uet.com"><?php echo $class->class_website ?></a></p>
                        <div class="clearfix">
                            <p style="float: left"><strong>Thành viên: </strong><a><?php echo $number_of_user ?></a></p>
                            <a id="add-members" style="float: right" href="javascript:void(0)"><p id="add-members-contents">Thêm thành viên <i class="icon-plus"></i></p></a>
                        </div>
                        <div id="alert-invite" style="display: none; position: absolute; overflow: visible; z-index: 2"></div>
                        <?php $this->renderPartial('inviteform', array('classid' => $class->class_id)) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        $('.comment-container').hide();
        $('.opencmt').click(function(event) {
            var current = $(this);
            var hide = current.next().css('display');
            if (hide == 'none') {
                $(this).html('<i class="icon-chevron-up"></i><span>&nbsp;Đóng</span>');
                current.next().slideDown('slow', function() {
                });
            } else {
                $(this).html('<i class="icon-chevron-down"></i><span>&nbsp;Xem thêm</span>');
                current.next().slideUp();
            }
        });
    });
    window.color_scheme = "color_11";
    window.body_layout = "wide";
</script>

