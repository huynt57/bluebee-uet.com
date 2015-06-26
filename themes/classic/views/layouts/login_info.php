<div class="w-nav-item level_1">
    <div class="w-nav-item-h">
        <a href="<?php echo Yii::app()->createUrl("user?token=" . Yii::app()->session['token']) ?>" class="w-nav-anchor level_ava">
            <img style="border: 5px solid white;"class="ava" src="<?php
            if (Yii::app()->session['user_avatar'] == "") {
                echo Yii::app()->theme->baseUrl, "/assets/img/logo.jpg";
            } else {

                echo Yii::app()->session['user_avatar'];
            }
            ?>"/>
        </a>


        <div class="w-nav-list place_down show_onhover level_2">
            <div class="w-nav-list-h">
                <div class="w-nav-item level_2">
                    <div class="w-nav-item-h">
                        <a href="<?php echo Yii::app()->createUrl('welcomePage/logout') ?>" class="w-nav-anchor level_2">Đăng xuất</a>
                    </div>
                </div>
                <!--                                                            <div class="w-nav-item level_2">
                                                                                <div class="w-nav-item-h">
                                                                                    <a href="home-parallax.html" class="w-nav-anchor level_2">Cập nhật thông tin</a>
                                                                                </div>
                                                                            </div>-->

            </div>
        </div>

    </div>
</div>