<?php foreach ($user_detail_info as $user): ?>
    <script type="text/javascript">
        $(document).ready(function() {
            var form = $('#newclassform');
            form.submit(function(event) {
                $('#res').html('');
                var data = form.serialize();
                $.ajax({
                    type: "POST",
                    url: '<?php echo Yii::app()->createUrl('classPage/createclass') ?>',
                    data: data,
                    beforeSend: function() {
                        $('#alert').html('<img class="w-blog-entry-img-h" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" alt="" style="" id="loading"/>');
                    },
                    success: function(data) {
                        var json = data;
                        var result = $.parseJSON(json);
                        //       $('#res').html(result.message);
                        $('#alert').html('');
                            
                        if (result.success == 1) {
                            var item = $('<div class="g-form-row-field">' +
                                    '<div id="success" class="g-alert type_success">' +
                                    '<div class="g-alert-body">' +
                                    '<p><b>' + result.message + '</b></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>').hide().fadeIn(120);
                                
                            $('#alert').html(item)
                            location.href = result.url;
                        }
                        else if (result.success == 2) {
                                
                            var item = $('<div class="g-form-row-field">' +
                                    '<div id="error" class="g-alert type_error">' +
                                    '<div class="g-alert-body">' +
                                    '<p><b>' + result.message + ' <a href = "' + result.url_class_exist + '">đây</a></b></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>').hide().fadeIn(120);
                                
                            $('#alert').html(item)
                            //   var json = $.parseJSON(data);
                            //  $('#res').html('Message : ' + json.message + '<br>Success : ' + json.success)
                        }
                            
                        else {
                                
                            var item = $('<div class="g-form-row-field">' +
                                    '<div id="error" class="g-alert type_error">' +
                                    '<div class="g-alert-body">' +
                                    '<p><b>' + result.message + '</b></p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>').hide().fadeIn(120);
                                
                            $('#alert').html(item)
                            //   var json = $.parseJSON(data);
                            //  $('#res').html('Message : ' + json.message + '<br>Success : ' + json.success)
                        }
                    }});
                event.preventDefault();
                event.stopPropagation();
                return false;
            });
        });</script>

    <div class="l-main-h">
        <div class="l-submain">
            <div class="l-submain-h g-html i-cf">
                <div class="g-cols">
                    <div class="full-width">
                        <div class="view effect">  
                            <img class="round_ava" src="
                            <?php
                            if ($user['user_cover'] == "") {
                                echo Yii::app()->theme->baseUrl, "/assets/img/demo/cover.jpg";
                            } else {

                                echo $user['user_cover'];
                            }
                            ?>"/>
                            <div class="content">
                                <div class="custom_file_upload info">
                                    <div class=" file_upload">  
                                        <input type="file" id="file_upload" name="file_upload" class="">
                                    </div>  
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <div class="l-submain-h g-html i-cf" id="profile_tag">
            <script>
                $(document).ready(function() {
                    var top = $("#profile_tag").offset().top;
                    $("body,html").scrollTop(top);
                });
            </script>
            <div class="g-cols">

                <div class="two-thirds">
                    <div class="l-content">
                        <div class='g-cols'>
                            <div class='full-width'>
                                <a href=""><img class="circular float_left" src="<?php
                                    if (Yii::app()->session['user_avatar'] == "") {
                                        echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
                                    } else {

                                        echo Yii::app()->session['user_avatar'];
                                    }
                                    ?>"/></a>
                                <div class="rounded">
                                    <b>Trích dẫn ưa thích:</b> <?php echo $user['user_qoutes'] ?>
                                    <br/>
                                    <b>Ngày tham gia:</b> <?php echo $user['user_date_attend'] ?>
                                </div>

                                <!--                                <div style="text-align: center">
                                                                    <p>
                                                                        <a href="">Add he/she to a class</a> | <a href="">Add he/she to a group</a> | <a href="">Suggest he/she books</a>
                                                                    </p>
                                                                </div>-->

                                <!--                                <div class="rounded1 color_alternate">
                                                                    <h6>Tài liệu đã xem</h6>
                                                                </div>
                                
                                                                <div class="w-gallery layout_tile size_s">
                                                                    <div class="w-gallery-h">
                                                                        <div class="w-gallery-tnails">
                                                                            <div class="w-gallery-tnails-h">
                                
                                                                                <a class="w-gallery-tnail" href="img/demo/photo-1.jpg" title="Photo Title">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-1.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                                                                <a class="w-gallery-tnail" href="img/demo/photo-2.jpg">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-2.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                                                                <a class="w-gallery-tnail" href="img/demo/photo-3.jpg">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-3.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                                                                <a class="w-gallery-tnail" href="img/demo/photo-4.jpg">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-4.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                                                                <a class="w-gallery-tnail" href="img/demo/photo-5.jpg">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-5.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                
                                                                                <a class="w-gallery-tnail" href="img/demo/project-2.jpg">
                                                                                    <span class="w-gallery-tnail-h">
                                                                                        <img class="w-gallery-tnail-img" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/thumb-6.jpg" alt="photo" />
                                                                                        <span class="w-gallery-tnail-title"><i class="icon-mail-forward"></i></span>
                                                                                    </span>
                                                                                </a>
                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                
                                                                <a href="" style="margin-left: 30px">More...</a>-->
                                <?php $this->renderPartial('partial/user_activity') ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="one-third">

                    <div class="rounded2 color_alternate"  style="margin-top: 70px">
                        <h6>Thông tin chi tiết</h6>
                    </div>

                    <div>

                        <span class="dataTitle1"> <i class="icon-user"></i> Tên : </span>
                        <span class="dataItem1"><?php echo $user->user_real_name ?></span>
                        <br/>

                        <span class="dataTitle1"> <i class="icon-phone"></i> SĐT : </span>
                        <span class="dataItem1"><?php echo $user->user_phone ?> </span>
                        <br/>

                        <span class="dataTitle1"> <i class="icon-home"></i> Sống tại : </span>
                        <span class="dataItem1"><?php echo $user->user_hometown ?></span>
                        <br/>

                        <span class="dataTitle1"><i class="icon-calendar"></i> Ngày sinh : </span>
                        <span class="dataItem1"><?php echo $user->user_dob ?></span>
                        <br/>
                    </div>

                    <div class="rounded2 color_alternate" style="margin-top: 10px">
                        <h6>Lớp đang theo học</h6>
                    </div>

                    <div class="w-portfolio columns_2 wide-margins type_sortable">
                        <div class="w-portfolio-h">
                            <div class="w-portfolio-list">
                                <div class="w-portfolio-list-h">
                                    <?php foreach ($user_class_info as $class): ?>
                                        <div class = "w-portfolio-item naming webdesign">
                                            <div class = "w-portfolio-item-h animate_afc">
                                                <a class = "w-portfolio-item-anchor" href = "<?php echo Yii::app()->baseUrl, "/classPage?classid=" . $class['class_id'] ?>">
                                                    <div class = "w-portfolio-item-image">
                                                        <img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/portfolio-1.jpg" alt = "" />
                                                        <div class = "w-portfolio-item-meta">
                                                            <h2 class = "w-portfolio-item-title"><?php echo $class['class_name'] ?></h2>
                                                            <i class = "icon-mail-forward"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--                    <div class = "rounded2 color_alternate">
                                            <h6>Nhóm đã tham gia</h6>
                                        </div>
                    
                                        <div class = "w-portfolio columns_2 wide-margins type_sortable">
                                            <div class = "w-portfolio-h">
                                                <div class = "w-portfolio-list">
                                                    <div class = "w-portfolio-list-h">
                    
                                                        <div class = "w-portfolio-item naming webdesign">
                                                            <div class = "w-portfolio-item-h animate_afc">
                                                                <a class = "w-portfolio-item-anchor" href = "project-another-slider.html">
                                                                    <div class = "w-portfolio-item-image">
                                                                        <img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/portfolio-1.jpg" alt = "" />
                                                                        <div class = "w-portfolio-item-meta">
                                                                            <h2 class = "w-portfolio-item-title">Vietnam National University</h2>
                                                                            <i class = "icon-mail-forward"></i>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                    
                                                        <div class = "w-portfolio-item naming webdesign">
                                                            <div class = "w-portfolio-item-h animate_afc">
                                                                <a class = "w-portfolio-item-anchor" href = "project-another-slider.html">
                                                                    <div class = "w-portfolio-item-image">
                                                                        <img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/portfolio-1.jpg" alt = "" />
                                                                        <div class = "w-portfolio-item-meta">
                                                                            <h2 class = "w-portfolio-item-title">Vietnam National University</h2>
                                                                            <i class = "icon-mail-forward"></i>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                    
                                                        <div class = "w-portfolio-item naming branding">
                                                            <div class = "w-portfolio-item-h animate_afc d1">
                                                                <a class = "w-portfolio-item-anchor" href = "project-slider.html">
                                                                    <div class = "w-portfolio-item-image">
                                                                        <img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/demo/portfolio-2.jpg" alt = "" />
                                                                        <div class = "w-portfolio-item-meta">
                                                                            <h2 class = "w-portfolio-item-title">Kien's </h2>
                                                                            <i class="icon-mail-forward"></i>
                                                                        </div>
                                                                    </div>
                                                                </a>
                                                            </div>
                                                        </div>
                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

