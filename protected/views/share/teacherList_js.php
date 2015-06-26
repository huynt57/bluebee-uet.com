<script type="text/javascript">

    $(document).ready(function() {

        jQuery("a.dept").click(function() {
            var $self = $(this);
            var faculty_id = $self.attr("faculty-id");
            var dept_id = $self.attr("dept-id");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('share/ListTeacherDeptFaculty') ?>",
                data: {dept_id: dept_id, faculty_id: faculty_id},
                beforeSend: function(xhr) {
                    jQuery('#teacher-list').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:300px; padding-top: 100px;"/>');
                    $('#teacher-list-pagination').hide();
                },
                success: function(data) {
                    var result = $.parseJSON(data);
                    jQuery('#teacher-list').empty();
                    jQuery.each(result.teacher_data, function(key, value) {
                        jQuery('#teacher-list').append(
                                '<div class="leftAlignedImage ">' +
                                '<div class="coverWrapper">' +
                                '<div class="w-team-member">' +
                                '<div class="w-team-member-h">' +
                                '<div class="w-team-member-image">' +
                                '<a href = "<?php echo Yii::app()->createUrl('share/teacher') ?>' + '/' + this.teacher_id + '/' + updateKey(this.teacher_name) + '">' +
                                '<img src="' + this.teacher_avatar + '" style = "height: 130px; width: 130px;" />' +
                                '</a>' +
                                '</div>' +
                                '<div class="w-team-member-meta">' +
                                '<h5 class="w-team-member-name">' + this.teacher_acadamic_title + ' ' + this.teacher_name + '</h5>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                ' </div>' +
                                '</div> ').hide().fadeIn(500);
                    });
                    $('#teacher-list').paginate({itemsPerPage: 16});
                    jQuery.each(result.dept_data, function(key, value) {
                        jQuery('#teacher_header').html(this.dept_name).hide().fadeIn(500);
                    });

                }
            });
        });
    });
</script>

<script type="text/javascript">

    $(document).ready(function() {

        jQuery("a.faculty").click(function() {
            var $self = $(this);
            var faculty_id = $self.attr("faculty-id");

            jQuery.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('share/ListTeacherFaculty') ?>",
                data: {faculty_id: faculty_id},
                beforeSend: function(xhr) {
                    jQuery('#teacher-list').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:300px; padding-top: 100px;"/>');
                    $('#teacher-list-pagination').hide();
                },
                success: function(data) {
                    var result = $.parseJSON(data);
                    jQuery('#teacher-list').empty();
                    jQuery.each(result.teacher_data, function(key, value) {
                        jQuery('#teacher-list').append(
                                '<div class="leftAlignedImage ">' +
                                '<div class="coverWrapper">' +
                                '<div class="w-team-member">' +
                                '<div class="w-team-member-h">' +
                                '<div class="w-team-member-image">' +
                                '<a href = "<?php echo Yii::app()->createUrl('share/teacher') ?>' + '/' + this.teacher_id + '/' + updateKey(this.teacher_name) + '">' +
                                '<img src="' + this.teacher_avatar + '" style = "height: 130px; width: 130px;"/>' +
                                '</a>' +
                                '</div>' +
                                '<div class="w-team-member-meta">' +
                                '<h5 class="w-team-member-name">' + this.teacher_acadamic_title + ' ' + this.teacher_name + '</h5>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                ' </div>' +
                                '</div> ').hide().fadeIn(500);
                    });
                    $('#teacher-list').paginate({itemsPerPage: 16});
                    jQuery.each(result.faculty_data, function(key, value) {
                        jQuery('#teacher_header').html(this.faculty_name).hide().fadeIn(500);
                    });

                }
            });
        });
    });
</script>

<script>
    function listteacher() {
        var $self = $(this);
        var faculty_id = 1;
        jQuery.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('share/ListTeacherFaculty') ?>",
            data: {faculty_id: faculty_id},
            beforeSend: function(xhr) {
                jQuery('#teacher-list').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:300px; padding-top: 100px;"/>');
                $('#teacher-list-pagination').hide();
            },
            success: function(data) {
                var result = $.parseJSON(data);
                jQuery('#teacher-list').empty();
                jQuery.each(result.teacher_data, function(key, value) {
                    jQuery('#teacher-list').append(
                            '<div class="leftAlignedImage ">' +
                            '<div class="coverWrapper">' +
                            '<div class="w-team-member">' +
                            '<div class="w-team-member-h">' +
                            '<div class="w-team-member-image">' +
                            '<a href = "<?php echo Yii::app()->createUrl('share/teacher') ?>' + '/' + this.teacher_id + '/' + updateKey(this.teacher_name) + '">' +
                            '<img src="' + this.teacher_avatar + '" style = "height: 130px; width: 130px;"/>' +
                            '</a>' +
                            '</div>' +
                            '<div class="w-team-member-meta">' +
                            '<h5 class="w-team-member-name">' + this.teacher_acadamic_title + ' ' + this.teacher_name + '</h5>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            ' </div>' +
                            '</div> ').hide().fadeIn(500);
                });

                $('#teacher-list').paginate({itemsPerPage: 16});
                jQuery.each(result.faculty_data, function(key, value) {
                    jQuery('#teacher_header').html(this.faculty_name).hide().fadeIn(500);
                });

            }
        });

    }
    jQuery(document).ready(function($) {
        var hash = window.location.hash;
        if (hash.length != 0) {
            $('a[href="' + hash + '"]').trigger("click");
        } else {
            window.onload = listteacher;
            //console.log(hash);
        }
    });
</script>