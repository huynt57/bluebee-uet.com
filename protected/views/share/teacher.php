
<?php foreach ($teacher_detail_info as $teacher): ?>
    <div class="l-main-h">
        <div class="l-submain">
            <div class="l-submain-h g-html">
                <div class="g-cols" style="height: auto">
                    <div class="one-third" >
                        <a href=""><img class="rectan" src="<?php
                            if ($teacher['teacher_avatar'] == "") {
                                echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
                            } else {
                                echo $teacher['teacher_avatar'];
                            }
                            ?>" style=""/></a>
                        <!--rating function script when click rating star  -->
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $(".star").click(function() {
                                    var score = $(this).attr("data-rating-value");
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo Yii::app()->createUrl('share/Rating') ?>",
                                        data: {rating_score: score, teacher_id: <?php echo $teacher['teacher_id'] ?>},
                                        success: function(data) {
                                            var result = $.parseJSON(data);
                                            if (result.checkRatingStatus === 0) {
                                                var i;
                                                console.log(result.score);
                                                console.log(result.aver);
                                                console.log(result.count);
                                                $("#number_rator").html(result.count);
                                                $("#average_score").html(result.aver);
                                                for (i = 1; i <= 5; i++) {
                                                    if (i <= result.score)
                                                        $('a[data-rating-value=' + i + ']').addClass("br-selected");
                                                    else
                                                        $('a[data-rating-value=' + i + ']').removeClass("br-selected");
                                                }
                                            } else {
                                                alert(result.message);
                                            }
                                        }
                                    });
                                    ;
                                });
                            });
                        </script>

                        <!--loading star corresponds to teacher's rating score-->
                        <script>
                            $(document).ready(function() {
                                for (i = 1; i <= 5; i++) {
                                    if (i <= <?php echo round($teacher['teacher_rate']) ?>)
                                        $('a[data-rating-value=' + i + ']').addClass("br-selected");
                                    else
                                        $('a[data-rating-value=' + i + ']').removeClass(".br-selected");
                                }
                                $("#average_score").html("<?php echo $teacher->teacher_rate ?>");
                                $("#number_rator").html("<?php echo " " . $countVote ?>");
                            });
                        </script>

                        <h5>Đánh giá giáo viên:</h5>
                        <div style="width:50%;float:left">
                            <div class="input select rating-f">
                                <label for="example-f"></label>
                                <select id="example-f" name="rating">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                        </div>
                        <div style="float: left;width:20%">
                            <strong style="font-size: 150%" id="average_score"></strong>
                        </div>
                        <div style="margin-left: 43px;width:30%">
                            <div ><p><i class="icon-user" id="number_rator"></i></p></div>
                        </div>   

                        <script>
                            function checkuploadfunction() {
                                alert("Bạn phải đăng nhập mới được bình chọn, hãy bấm đăng nhập với facebook phía trên");
                            }
                        </script>
                        <div class="morph-button morph-button-modal morph-button-fixed" id="morph-upload">
                            <button class="btn" type="button" ><i class="icon-comment"></i> Gửi ý kiến</button>
                            <div class="morph-content" id="upload_area_morph" style="height: auto;">
                                <div class="content-style-text">
                                    <span class="icon icon-close" id="close_form">✕</span>
                                    <h4 style="margin-bottom: 5px;">Gửi ý kiến về giáo viên</h4>

                                    <form method="POST" action="<?php echo Yii::app()->createUrl('share/comment') ?>" enctype="multipart/form-data" id="formscribd" data-type="iframe" data-success-event="upload-doc-success" data-load-event="upload-doc-load" data-send-event="upload-doc-send" style="height: auto">
                                        <p>Chúng tôi không ghi lại danh tính của bạn, hãy tự do thể hiện ý kiến bản thân :D</p>
                                        <textarea id="description_document" placeholder="Bạn nghĩ gì vể giảng viên <?php echo $teacher['teacher_name'] ?>" name="teacher_comment"></textarea>
                                        <input type ="hidden" value="<?php echo $teacher['teacher_id'] ?>" name="teacher_id">
                                        <br/>

                                        <button class="g-btn size_small type_primary" type="button" onclick="__ajax(this.form)">Gửi ý kiến</button>
                                    </form>
                                    <div style="float:right; margin-top: -90px">
                                        <div style=" ">
                                            <img id="loading-image-upload" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax-loader.gif" style="margin-left: 400px;"/>
                                        </div>
                                        <div style="display: none; background-color: red; box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); color: white; border-radius: 3px;" id="error_status">
                                            <p class="clearfix" style="padding: 10px 10px 10px 10px" id="error_info">

                                            </p>
                                        </div>
                                        <div style="background-color: green; box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.3); color: white; border-radius: 3px;" id="success_status">
                                            <p class="clearfix" style="padding: 10px 10px 10px 10px" id="success_info">
                                                Đăng thành công
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--                        <a href="<?php //echo Yii::app()->createAbsoluteUrl('share/teacherListPage')     ?>"><button class="g-btn type_outline size_small"><span>Danh sách giáo viên</span></button></a>-->

                        <div class="rounded1 color_alternate" style="margin-top: 20px">
                            <h6>Môn học đang dạy</h6>
                        </div>
                        <?php foreach ($subject_teacher as $subject_teacher): ?>                            
                            <div style="margin-top:10px">
                                <span class="dataItem1" style="width: 75%;"><a href="<?php echo Yii::app()->createAbsoluteUrl('listOfSubject/subject') . "/" . $subject_teacher->subject_id . "/" . StringHelper::makeUrlString($subject_teacher->subject_name) ?>"><?php echo $subject_teacher->subject_name ?></a></span>
                                <span class="dataTitle1" style="width: 25%;"><?php echo $subject_teacher->subject_code ?></span>
                            </div>
                        <?php endforeach; ?>                          

                    </div>

                    <div class="two-thirds">
                        <div>
                            <h1><?php echo $teacher['teacher_acadamic_title'] . ". " . $teacher['teacher_name'] ?></h1>
                            <br/>
                            <span class="dataTitle">Website</span>
                            <span class="dataItem"><a href="http://<?php echo $teacher['teacher_personal_page'] ?>"><?php echo $teacher['teacher_personal_page'] ?></a></span>
                            <br/>
                            <span class="dataTitle">Ngày sinh</span>
                            <span class="dataItem"><?php
                                if ($teacher['teacher_birthday'] != "")
                                    echo $teacher['teacher_birthday'];
                                else
                                    echo "Đang cập nhật";
                                ?></span>
                            <span class="dataTitle">Số điện thoại</span>
                            <span class="dataItem"><?php
                                if ($teacher['teacher_phone'] != "")
                                    echo $teacher['teacher_phone'];
                                else
                                    echo "Đang cập nhật";
                                ?></span>
                            <span class="dataTitle">Email</span>
                            <span class="dataItem"><?php
                                if ($teacher['teacher_email'] != "")
                                    echo $teacher['teacher_email'];
                                else
                                    echo "Đang cập nhật";
                                ?></span>
                            <br/>
                            <span class="dataTitle">Thông tin thêm:</span>
                            <span class="dataItem"><?php
                                if ($teacher['teacher_description'] != "")
                                    echo $teacher['teacher_description'];
                                else
                                    echo "Đang cập nhật";
                                ?></span>
                            <br/>
                        </div>


                        <div style="margin-top: 100px">
                            <h2>Sơ lược</h2>
                        </div>
                        <div class="g-hr type_long">
                            <span class="g-hr-h">
                                <i class="icon-arrow-down"></i>
                            </span>
                        </div>

                        <div class="g-cols">
                            <div class="full-width">
                                <div class="w-iconbox icon_left">
                                    <div class="w-iconbox-h">
                                        <div class="w-iconbox-icon">
                                            <i class="icon-magic"></i>
                                        </div>
                                        <div class="w-iconbox-text">
                                            <h3 class="w-iconbox-text-title">Tính cách</h3>
                                            <div class="w-iconbox-text-description">
                                                <p><?php echo $teacher['teacher_personality'] ?></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <br/>
                                <div class="w-iconbox icon_left">
                                    <div class="w-iconbox-h">
                                        <div class="w-iconbox-icon">
                                            <i class="icon-code"></i>
                                        </div>
                                        <div class="w-iconbox-text">
                                            <h3 class="w-iconbox-text-title">Lời khuyên</h3>
                                            <div class="w-iconbox-text-description">
                                                <p><?php echo $teacher['advices'] ?></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <br/>
                                <br/>
                                <div class="w-iconbox icon_left">
                                    <div class="w-iconbox-h">
                                        <div class="w-iconbox-icon">
                                            <i class="icon-trophy"></i>
                                        </div>
                                        <div class="w-iconbox-text">
                                            <h3 class="w-iconbox-text-title">Công trình nghiên cứu</h3>
                                            <div class="w-iconbox-text-description">
                                                <p><?php echo $teacher['teacher_research'] ?></p>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="g-hr type_invisible">
                                    <span class="g-hr-h">
                                        <i class="icon-star"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <!--cmt facebook-->
                    </div>
                    <div>
                        <h3>Bình luận</h3>

                        <div class="fb-like" data-href="<?php echo Yii::app()->createAbsoluteUrl('share/teacher') . "/" . $teacher['teacher_id'] . "/" . StringHelper::makeUrlString($teacher['teacher_name']) ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
                        <div class="fb-comments" data-href="<?php echo Yii::app()->createAbsoluteUrl('share/teacher') . "/" . $teacher['teacher_id'] . "/" . StringHelper::makeUrlString($teacher['teacher_name']) ?>" data-width="1000" data-numposts="8" data-colorscheme="light"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php endforeach; ?>
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/js/uiMorphingButton_fixed.js"></script>
<script>
                                            (function() {
                                                var docElem = window.document.documentElement, didScroll, scrollPosition;

                                                // trick to prevent scrolling when opening/closing button
                                                function noScrollFn() {
                                                    window.scrollTo(scrollPosition ? scrollPosition.x : 0, scrollPosition ? scrollPosition.y : 0);
                                                }

                                                function noScroll() {
                                                    window.removeEventListener('scroll', scrollHandler);
                                                    window.addEventListener('scroll', noScrollFn);
                                                }

                                                function scrollFn() {
                                                    window.addEventListener('scroll', scrollHandler);
                                                }

                                                function canScroll() {
                                                    window.removeEventListener('scroll', noScrollFn);
                                                    scrollFn();
                                                }

                                                function scrollHandler() {
                                                    if (!didScroll) {
                                                        didScroll = true;
                                                        setTimeout(function() {
                                                            scrollPage();
                                                        }, 60);
                                                    }
                                                }
                                                ;

                                                function scrollPage() {
                                                    scrollPosition = {x: window.pageXOffset || docElem.scrollLeft, y: window.pageYOffset || docElem.scrollTop};
                                                    didScroll = false;
                                                }
                                                ;

                                                scrollFn();

                                                var UIBtnn = new UIMorphingButton(document.querySelector('.morph-button'), {
                                                    closeEl: '.icon-close',
                                                    onBeforeOpen: function() {
                                                        // don't allow to scroll
                                                        noScroll();
                                                    },
                                                    onAfterOpen: function() {
                                                        // can scroll again
                                                        canScroll();
                                                    },
                                                    onBeforeClose: function() {
                                                        // don't allow to scroll
                                                        noScroll();
                                                    },
                                                    onAfterClose: function() {
                                                        // can scroll again
                                                        canScroll();
                                                    }
                                                });

                                                document.getElementById('terms').addEventListener('change', function() {
                                                    UIBtnn.toggle();
                                                });
                                            })();
</script>
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