<div class="one-third" style="float: right;">
    <?php $this->renderPartial('partial/upload', array('subject_info' => $subject_info)); ?>
    <div class="wrap_fliter">
        <div class="clearfix">
            <script type="text/javascript">
                $(document).ready(function() {
                    $('input[type="checkbox"]').on('change', function() {
                        $('input[type="checkbox"]').not(this).prop('checked', false);
                    });
                });

            </script>
        </div>
        <div class="clearfix" style="margin-top: 10px">
            <form id="box-choose-subjects" style="" action="">
                <span class="">Lọc theo Môn học</span>
                <input contenteditable=true id="choose-subjects" type="text" name="subjects"></input>
                <button type="submit" id="choose-subjects-button" class="g-btn type_primary size_small" style="width: 100%">
                    <span>Lọc</span>
                </button>
            </form>
            <div class="filter_subjects" id="filter_subject">

            </div>
        </div>
    </div>
    <div>

    </div>
</div>
<?php $this->renderPartial('bar_right_js'); ?>
