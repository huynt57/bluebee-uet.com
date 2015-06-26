<div class="l-submain">
    <div class="l-submain-h i-cf">
        <div class="g-cols">
            <div class="full-width">
                <?php foreach ($info_lesson as $detail_info): ?>
                    <div class="head"><?php echo $detail_info->lesson_name ?></div>
                    <div class="l-submain">
                        <div class="l-submain-h g-html">

                            <div class="g-cols">
                                <div class="two-thirds">

                                    <h3>Giới thiệu sơ lược</h3>

                                    <p><?php echo $detail_info->lesson_info ?></p>

                                    <h4 style="text-align: center">Các video bài giảng liên quan</h4>
                                    <?php foreach ($vid_lesson as $detail_vid): ?>
                                        <div class="w-video ratio_16-9">
                                            <div class="w-video-h">
                                                <iframe src="<?php echo $detail_vid->video_link ?>"></iframe>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                    <div class="underline1"></div>
                                </div>
                                <div class="one-third">
                                    <div class="box more-box1">
                                        <h6 style="color: #262626"><strong>TÀI LIỆU</strong></h6>
                                        <?php
                                        foreach ($doc_lesson as $doc):
                                            $detail_doc = Doc::model()->find(array(
                                                'select' => "*",
                                                'condition' => "doc_id = :doc_id",
                                                'params' => array(':doc_id' => $doc->doc_id)
                                            ));
                                            ?>
                                            <div class="underline3"></div>
                                            <div class="block">
                                                <img src="<?php echo $detail_doc->doc_url ?>" height="70" width="50"/>
                                                <a href="<?php echo Yii::app()->createUrl('viewDocument?doc_id= ') . $detail_doc->doc_id ?>"><i class="icon-arrow-down"></i><?php echo $detail_doc->doc_name; ?></a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div>
                    <h4>Bình luận</h4>
                    <div class="fb-comments" data-href="<?php echo Yii::app()->createAbsoluteUrl('lesson?lesson_id=') . $detail_info->lesson_id ?>" data-width="1000" data-numposts="8" data-colorscheme="light"></div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>