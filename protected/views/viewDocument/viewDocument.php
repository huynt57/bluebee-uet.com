
<?php foreach ($detail_doc as $detail): ?>
    <link href="<?php echo $detail->doc_url ?>" rel="image_src"/>
    <div id="content">
        <div class="l-submain">
            <div class="l-submain-h">
                <p style="margin-bottom: 10px;">Thông báo: Nếu bạn không xem được tài liệu đề nghị bạn thoát tài khoản google ra</p>
                <div class="g-cols">
                    <div style="margin-bottom: 20px">
                        <style>
                            .information_document {
                                min-height: 50px;
                                margin: 0 0 20px 0;
                                font-size: .9em;
                                position: relative;
                            }
                            .information_document h1 {
                                font-size: 23px;
                                line-height: 1.1;
                                font-weight: bold;
                                margin: 0 0 5px 60px;
                            }
                            .information_document h1 p{
                                font-size: 16px;
                                font-weight: normal;
                                margin: 10px 5px 0 0;
                            }
                            .shot-byline {
                                margin-left: 60px;
                                font-size: 13px;
                                line-height: 1.4;
                                color: #999;
                            }
                            .shot-byline-user {
                                float: left;
                            }
                            .time_post {
                                float: left;
                                margin: 2px 0 0 12px;
                                font-size: 12px;
                                color: #999;
                            }
                            .related_document {
                            }
                        </style>
                        <div class="information_document">
                            <a href="<?php echo Yii::app()->createUrl('user') . "/" . $detail->doc_author . "/" . StringHelper::makeUrlString($detail->doc_author_name) ?>" class="url_user" title="<?php echo $detail->doc_author_name ?>">
                                <?php $user_info = User::model()->findByAttributes(array('user_id' => $detail->doc_author)) ?>
                                <img class="photo_user" src="<?php echo $user_info->user_avatar ?>" style="width: 50px; max-height: 50px; min-height: 50px;">
                            </a>
                            <h1>
                                <span><?php echo $detail->doc_name ?></span>
                            </h1>
                            <div class="shot-byline">
                                <div class="attribution ">
                                    <span class="shot-byline-user">
                                        đăng bởi <a href="<?php echo Yii::app()->createUrl('user') . "/" . $detail->doc_author . "/" . StringHelper::makeUrlString($detail->doc_author_name) ?>" class="url_user" title="<?php echo $detail->doc_author_name ?>"><?php echo $detail->doc_author_name ?></a>
                                    </span>
                                </div>

                            </div>

                        </div>
                        <div class="clearfix">
                            <p style="float: left; margin-top: 6px; margin-right: 5px;">Môn học:</p>
                            <button onclick="window.location.href = '<?php echo $this->createAbsoluteUrl("listOfSubject/subject") . "/" . $subject->subject_id . "/" . StringHelper::makeUrlString($subject->subject_name) ?>';" class="g-btn type_primary size_small" style="float: left; text-transform: none; font-size: 14px; font-weight: normal;"><span><?php echo $subject->subject_name ?></span></button>
                        </div>

                        <div class="fb-like" data-href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') . "/" . $detail->doc_id . "/" . StringHelper::makeUrlString($detail->doc_name) ?>" data-layout="standard" data-action="like" data-show-faces="false" data-share="true" style="margin-bottom: 10px;"></div>
                        </br>
                        <div class="l-content">
                            <?php
                            if ($detail->doc_type == 2) {
                                echo '<iframe src="http://docs.google.com/viewer?url=' . $detail->doc_path . '&embedded=true" height="600" style="border-radius: 3px; box-shadow: 0 0 2px rgba(0, 0, 0, 0.3); width: 100%; "></iframe></br></br>' . '<a href="' . $detail->doc_path . '"' . 'download="' . "[Bluebee-UET.com] ". $detail->doc_name . '" style = "font-size:25px;"><button class="g-btn type_primary size_small">Download</button></a>';
                            } else {
                                if ($detail->doc_type == 1) {
                                    echo '<div style="text-align:center"><img style="width: auto; height: auto; margin: 0 auto; " align = "middle" src="' . $detail->doc_path . '" /></div></br></br>' . '<a href="' . $detail->doc_path . '"' . 'download="'. "[Bluebee-UET.com] " .$detail->doc_name.".".substr($detail->doc_path, strripos($detail->doc_path, ".") + 1) . '" style = "font-size:25px;"><button class="g-btn type_primary size_small">Download</button></a>';
                                } else {
                                    if ($detail->doc_type == 3) {
                                        echo '<p>Tài liệu nén không xem trước được các bạn vui lòng bấm nút download để tải</p>';
                                        echo '<a href="' . $detail->doc_path . '"' . 'download="' . "[Bluebee-UET.com] ".$detail->doc_name . '" style = "font-size:25px;"><button class="g-btn type_primary size_small">Download</button></a>';
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <div style="margin-top: 10px;"></div>
                    <div class="one-third" style="margin-left: 0;">
                        <h3>Miêu tả về tài liệu:</h3>
                        <p><?php echo $detail->doc_description ?></p>
                    </div>
                    <div class="two-thirds">
                        <div class="related_document">
                            <span style="font-size: 16px; padding-bottom: 10px;">Có thể bạn quan tâm:</span>
                            <ol class="list_document">
                                <?php foreach ($related_doc as $related_doc): ?>
                                    <li class="item_document">
                                        <div class="box_item">
                                            <div class="short_info_document clearfix">
                                                <div class="document_img">
                                                    <img src="<?php echo $related_doc->doc_url ?>"/>
                                                    <a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') . "/" . $related_doc->doc_id . "/" . StringHelper::makeUrlString($related_doc->doc_name) ?>" action="" class="document_img_hover">
                                                        <span class="describe_document"><?php $related_doc->doc_description ?></span>
        <!--                                                <em class="timestamp"><i class="icon-time"></i>&nbsp;June 26, 2014</em>-->
                                                    </a>
                                                </div>

                                                <span class="attribution-user">
                                                    <a href="<?php echo Yii::app()->createUrl('user', array('id' => $related_doc->doc_author)) . "/" . StringHelper::makeUrlString($related_doc->doc_author_name) ?>" class="url_user" title="<?php echo $related_doc->doc_author_name ?>">
                                                        <img class="photo_user" src="<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/default-avatar.png"> <?php echo $related_doc->doc_author_name ?>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                        <a class="name_document" href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') . "/" . $related_doc->doc_id . "/" . StringHelper::makeUrlString($related_doc->doc_name) ?>"><strong><?php echo $related_doc->doc_name ?></strong></a>
                                    </li>
                                <?php endforeach; ?>
                            </ol>
                        </div>
                    </div>
                </div>
                <div>
                    <h3>Bình luận</h3>
                    <div class="fb-comments" data-href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') . "/" . $detail->doc_id . "/" . StringHelper::makeUrlString($detail->doc_name) ?>" data-width="1000" data-numposts="8" data-colorscheme="light"></div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
