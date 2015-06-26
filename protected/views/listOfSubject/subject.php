
<?php foreach ($subject as $subject): ?>
    <div class="l-submain">
        <div class="l-submain-h i-cf">
            <div class="g-cols">

                <div class="full-width">
                    <div class="head"><?php echo $subject->subject_name ?> <?php
                        if ($subject->subject_requirement == "")
                            echo '';
                        else
                            echo '(Môn học tiên quyết: '.$subject->subject_requirement.')';
                        ?></div>
                    <div class="fb-like" data-href="<?php echo Yii::app()->createAbsoluteUrl('listOfSubject/subject') ."/". $subject->subject_id."/".StringHelper::makeUrlString($subject->subject_name) ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true"></div>
                    <div class="w-testimonial">
                        <div class="w-testimonial-h">
                            <blockquote>
                                <q class="w-testimonial-text"><?php echo $subject->subject_target ?></q>
                                <div class="w-testimonial-person">
                                    <i class="icon-user"></i>
                                    <span class="w-testimonial-person-name">Mục tiêu môn học</span>
                                </div>
                            </blockquote>
                        </div>
                    </div>
                    <div class="g-cols" style="margin-top:20px">
                        <div class="two-thirds" >
                            <strong style="color: #262626">Nội dung môn học</strong>
                            <p style="margin-right: 25px;margin-top: 20px;margin-bottom: 20px">
    <?php echo $subject->subject_content ?>
                            </p>
                            <strong style="color: #262626">Giáo viên giảng dạy:</strong>
                            <div class="g-cols" style="margin-right: 30px;margin-top: 20px">
    <?php if (count($teacher) > 0 )foreach ($teacher as $teacher): ?>
                                    <div class="one-third">
                                        <div class="w-team-member">
                                            <div class="w-team-member-h">
                                                <div class="w-team-member-image">
                                                    <a href="<?php echo Yii::app()->createUrl('share/teacher') . "/".$teacher->teacher_id."/".StringHelper::makeUrlString($teacher->teacher_name) ?>">
                                                        <img src="<?php
                                                        if ($teacher->teacher_avatar != "") {
                                                            echo $teacher->teacher_avatar;
                                                        } else {
                                                            echo Yii::app()->createAbsoluteUrl("themes/classic/assets/img/Teacher_img/Teacher_default_avatar.png");
                                                        }
                                                        ?>" alt="<?php echo $teacher->teacher_name ?>" style="height: 191px; width: 193px;"/>
                                                    </a>
                                                </div>
                                                <div class="w-team-member-meta">
                                                    <h4 class="w-team-member-name"><?php echo $teacher->teacher_acadamic_title . " " . $teacher->teacher_name ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
    <?php endforeach; else echo('Chưa có thông tin giáo viên')?>                    

                            </div>
                        </div>
                        <div class="one-third">
                            <div class="box more-box">
                                <h6 style="color: #262626"><strong>THÔNG TIN</strong></h6>

                                <h6> Thông tin cơ bản </h6>
                                <div class="white">
                                    Mã môn học : <?php echo $subject->subject_code ?>
                                    <div class="underline1"></div>
                                    Tên môn : <?php echo $subject->subject_name ?>
                                    <div class="underline1"></div>
                                    Số tín chỉ : <?php echo $subject->subject_credits ?>
                                    <div class="underline1"></div>
                                    Môn học tiên quyết : không
                                </div>

                        
                            </div>
                        </div>

                        <style type="text/css">
                            .jcarousel-wrapper {
                                margin: 20px auto;
                                margin-left: 70px !important;
                                position: relative;
                                border: 10px solid #fff;
                                -webkit-border-radius: 5px;
                                -moz-border-radius: 5px;
                                border-radius: 5px;
                                -webkit-box-shadow: 0 0 2px #999;
                                -moz-box-shadow: 0 0 2px #999;
                                box-shadow: 0 0 2px #999;
                                width: 850px !important;
                            }
                            .jcarousel {
                                position: relative;
                                overflow: hidden;
                            }

                            .jcarousel-control-prev,
                            .jcarousel-control-next {
                                position: absolute;
                                top: 165px;
                                width: 30px;
                                height: 30px;
                                text-align: center;
                                background: #4E443C;
                                color: #fff;
                                text-decoration: none;
                                text-shadow: 0 0 1px #000;
                                font: 24px/27px Arial, sans-serif;
                                -webkit-border-radius: 30px;
                                -moz-border-radius: 30px;
                                border-radius: 30px;
                                -webkit-box-shadow: 0 0 2px #999;
                                -moz-box-shadow: 0 0 2px #999;
                                box-shadow: 0 0 2px #999;
                            }

                            .jcarousel-control-prev {
                                left: -50px;
                            }

                            .jcarousel-control-next {
                                right: -50px;
                            }

                            .jcarousel-control-prev:hover span,
                            .jcarousel-control-next:hover span {
                                display: block;
                            }

                            .jcarousel-control-prev.inactive,
                            .jcarousel-control-next.inactive {
                                opacity: .5;
                                cursor: default;
                            }
                            .jcarousel ul {
                                width: 20000em;
                                position: relative;
                                list-style: none;
                                margin: 0;
                                padding: 0;
                            }

                            .jcarousel li {
                                position: relative;
                                width: 200px;
                                float: left;
                                padding: 0;
                                margin: 0 10px 0 10px !important;
                            }
                        </style>
                        <div class="jcarousel-wrapper">

                            <strong style="color: #262626">Tài liệu môn học</strong>
                            <div class="jcarousel"><ul class="list_document" style="padding-top: 15px;">
    <?php foreach ($doc_related as $doc): ?>
                                        <li class="item_document">
                                            <div class="box_item">
                                                <div class="short_info_document clearfix">
                                                    <div class="document_img">
                                                        <img src="<?php echo $doc->doc_url ?>">
                                                        <a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ."/". $doc->doc_id."/".StringHelper::makeUrlString($doc->doc_name)?>" class="document_img_hover">
                                                            <span class="describe_document"><?php echo $doc->doc_description ?></span>
            <!--                                                                                <em class="timestamp"><i class="icon-time"></i>&nbsp;June 26, 2014</em>-->
                                                        </a>
                                                    </div>
                                                    <!--                                                                        <ul class="document_status clearfix">
                                                                                                                                <li class="score"><i class="icon-heart"></i>2000</li>
                                                                                                                                <li class="view"><i class="icon-eye-open"></i>1999</li>
                                                                                                                                <li class="comment"><i class="icon-comment"></i>1203</li>
                                                                                                                            </ul>-->

                                                </div>
                                            </div>
                                            <a class="name_document" href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ."/". $doc->doc_id."/".StringHelper::makeUrlString($doc->doc_name)?>"><strong><?php echo $doc->doc_name ?></strong></a>
                                        </li>
    <?php endforeach; ?>
                                </ul></div>
                            <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
                            <a href="#" class="jcarousel-control-next">&rsaquo;</a>
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $('.jcarousel').jcarousel({
                                    list: '.list_document',
                                    wrap: 'circular'
                                });
                                $('.jcarousel-control-prev')
                                        .on('jcarouselcontrol:active', function() {
                                            $(this).removeClass('inactive');
                                        })
                                        .on('jcarouselcontrol:inactive', function() {
                                            $(this).addClass('inactive');
                                        })
                                        .jcarouselControl({
                                            // Options go here
                                            target: '-=1'
                                        });

                                /*
                                 Next control initialization
                                 */
                                $('.jcarousel-control-next')
                                        .on('jcarouselcontrol:active', function() {
                                            $(this).removeClass('inactive');
                                        })
                                        .on('jcarouselcontrol:inactive', function() {
                                            $(this).addClass('inactive');
                                        })
                                        .jcarouselControl({
                                            // Options go here
                                            target: '+=1'
                                        });
                            });

                        </script>
                        <div style="margin-left: 0px !important" class="fb-comments" data-href="<?php echo Yii::app()->createAbsoluteUrl('listOfSubject/subject') ."/". $subject->subject_id."/".StringHelper::makeUrlString($subject->subject_name) ?>" data-width="1000" data-numposts="8" data-colorscheme="light"></div>
                    </div>

                </div>
            </div>
            <!--cmt facebook-->
        </div>
    </div>
<?php endforeach; ?>