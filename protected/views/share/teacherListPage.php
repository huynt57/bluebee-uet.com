<?php $this->renderPartial('teacherList_js')?>
<div class="l-main-h">
    <div class="l-submain">
        <div class="l-submain-h g-html i-cf">
            <div class="g-cols">
                <?php $this->renderPartial("partial/bar_left", array('category_father' => $category_father, 'subject_type' => $subject_type)) ?>

                <div class="three-fourths ">

                    <h3 id="teacher_header"></h3>
                    <div class="teacherList" id="teacher-list">

                        <!--cmt facebook-->
                    </div>
                    <center>
                        <div id="teacher-list-pagination"  style="display: none; clear: both; padding-top: 20px;">     
                            <a id="teacher-list-previous" class="disabled" href="#" style="font-size: large; font-weight: bold; padding-right: 15px;">« Trước</a>
                            <a id="teacher-list-next" href="#" style="font-size: large; font-weight: bold">Sau »</a>      
                        </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
a.disabled {
    text-decoration: none;
    color: black;
    cursor: default;
}

</style>