<script type="text/javascript">
    $(document).ready(function() {
        $('#loading').hide();
        var form = $('#postform');
        form.submit(function(event) {
            // prevent default action
            event.preventDefault();
            // send ajax request
            $.ajax({
                beforeSend: function() {
                    $('#loading').show();
                },
                url: '<?php echo Yii::app()->createUrl('discussion/makepost') ?>',
                type: 'POST',
                data: form.serialize(), //form serizlize data
                complete: function() {
                    $('#loading').hide();
                },
                success: function(data) {
                    // Append with fadeIn see http://stackoverflow.com/a/978731
                    var json = data;
                    var result = $.parseJSON(json);
                    var item = $('<div class="w-blog-entry" >' +
                            ' <div class="w-blog-entry-h">' +
                            '<a class="w-blog-entry-link" href="blog-post.html">' +
                            '<span class="w-blog-entry-img animate_afc animate_start" style="width: 60px;">' +
                            '<img class="w-blog-entry-img-h" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/blog-1.jpg" alt="" style=""/>' +
                            '</span>' +
                            ' </a>' +
                            '<div class="w-blog-entry-body" style="margin-left: 90px;">' +
                            '<div class="w-blog-entry-meta">' +
                            '<div class="w-blog-entry-meta-date">' +
                            '<i class="icon-time"></i>' +
                            '<span class="w-blog-entry-meta-date-month">March</span>' +
                            '<span class="w-blog-entry-meta-date-day">23,</span>' +
                            '<span class="w-blog-entry-meta-date-year">2013</span>' +
                            '</div>' +
                            '<div class="w-blog-entry-meta-author">' +
                            '<i class="icon-user"></i>' +
                            '<a class="w-blog-entry-meta-author-h" href="javascript:void(0);">Admin</a>' +
                            ' </div>' +
                            '<div class="w-blog-entry-meta-tags">' +
                            ' <i class="icon-tags"></i>' +
                            '<a href="javascript:void(0);">Web Design</a>,' +
                            '<a href="javascript:void(0);">Branding</a>' +
                            ' </div>' +
                            '<div class="w-blog-entry-meta-comments">' +
                            '<i class="icon-comments"></i>' +
                            '<a class="w-blog-entry-meta-comments-h" href="javascript:void(0);">13 comments</a>' +
                            '</div>' +
                            '</div>' +
                            '<div class="w-blog-entry-short">' +
                            '<p>' + result.message + '</p>' +
                            '</div>' +
                            '<button class=" g-btn type_primary size_small" id="opencmt" onclick=""><span>Xem thêm</span></button>' +
                            '</div>' +
                            '</div>' +
                            '</div>').hide().fadeIn(800);
                    $('#loading').html('');
                    $('#blogblock').prepend(item);
                    document.getElementById("postform").reset();
                },
                error: function(event) {
                    alert(event);
                }
            });

            event.stopPropagation();
            return false;
        });
    });

    //valid
    var r = {
        'special': /['<>']/g,
    }

    function valid(o, w) {
        o.value = o.value.replace(r[w], '');
    }
</script>

<!-- 
<div class="l-main-h">
    <div class="l-submain for_pagehead">
        <div class="l-submain-h g-html i-cf">
            <div class="w-pagehead">
                <h1>Thảo luận</h1>
                <p>Share everything !!</p>
            </div>
        </div>
    </div>
    <div class="l-submain">
        <div class="l-submain-h g-html i-cf ">
            <div class="g-cols">
                <?php $this->renderPartial("partial/sidebar_left") ?>
                <div class="three-fourths">
                    <div class="one-half" style="margin-bottom: 40px">
                        <div class="w-tabs layout_accordion type_toggle">
                            <div class="w-tabs-h">
                                <div class="w-tabs-section with_icon">
                                    <div class="w-tabs-section-title" name ="Hay cho y kien cua ban ...">
                                        <span class="w-tabs-section-title-icon icon-pencil"></span>
                                        <span class="w-tabs-section-title-text">Hay cho y kien cua ban ...</span>
                                        <span class="w-tabs-section-title-control"><i class="icon-angle-down"></i></span>
                                    </div>
                                    <div class="w-tabs-section-content" style="margin: 2% 5% 2% 5%">
                                        <form class="g-form" action="<?php echo Yii::app()->createUrl('discussion/makepost') ?>" method="post" id="postform">
                                            <div class="g-form-group">
                                                <div class="g-form-group-rows">
                                                    <div class="g-form-row" style="margin: 5px 0 5px 0; padding: 0;">
                                                        <div class="g-form-row-field">
                                                            <div class="g-input">
                                                                <textarea name="post_content" id="contact_message" cols="30" rows="10"  style="border-color: #429EDB" onkeyup="valid(this, 'special')" onblur="valid(this, 'special')" placeholder="what do you want to post?"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="g-form-row">
                                                        <div class="g-form-row-field">
                                                            <button class="g-btn type_primary size_small" type="submit" name="Submit">Đăng tin</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div> <img class="w-blog-entry-img-h" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax-loader.gif" alt="" style="" id="loading"/></div>
                    <?php foreach ($post as $detailpost): ?>
                        <div class="l-content">
                            <div class="l-content-h">
                                <div class="w-blog imgpos_atleft meta_tagscomments">
                                    <div class="w-blog-h" id="blogblock">
                                        <div class="w-blog-list">
                                            <div class="w-blog-entry" >
                                                <div class="w-blog-entry-h">
                                                    <a class="w-blog-entry-link" href="blog-post.html">
                                                        <span class="w-blog-entry-img animate_afc" style="width: 60px;">
                                                            <img class="w-blog-entry-img-h" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/blog-1.jpg" alt="" style=""/>
                                                        </span>
                                                    </a>
                                                    <div class="w-blog-entry-body" style="margin-left: 90px;">
                                                        <div class="w-blog-entry-meta">
                                                            <div class="w-blog-entry-meta-date">
                                                                <i class="icon-time"></i>
                                                                <span class="w-blog-entry-meta-date-month">March</span>
                                                                <span class="w-blog-entry-meta-date-day">23,</span>
                                                                <span class="w-blog-entry-meta-date-year">2013</span>
                                                            </div>

                                                            <div class="w-blog-entry-meta-author">
                                                                <i class="icon-user"></i>
                                                                <a class="w-blog-entry-meta-author-h" href="javascript:void(0);">Admin</a>
                                                            </div>

                                                            <div class="w-blog-entry-meta-tags">
                                                                <i class="icon-tags"></i>
                                                                <a href="javascript:void(0);">Web Design</a>,
                                                                <a href="javascript:void(0);">Branding</a>
                                                            </div>

                                                            <div class="w-blog-entry-meta-comments">
                                                                <i class="icon-comments"></i>
                                                                <a class="w-blog-entry-meta-comments-h" href="javascript:void(0);">13 comments</a>
                                                            </div>
                                                        </div>

                                                        <div class="w-blog-entry-short">
                                                            <p><?php echo $detailpost->post_content ?></p>
                                                        </div>

                                                        <button class=" g-btn type_primary size_small" id="opencmt" ><span>Xem thêm</span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div> -->