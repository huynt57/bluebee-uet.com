
<script type="text/javascript">

    $(document).ready(function() {

        jQuery("a.subject").click(function() {
            var $self = $(this);
            var faculty_id = $self.attr("faculty-id");
            var dept_id = $self.attr("dept-id");
            var subject_type = $self.attr("subject-type");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('document/listdocument') ?>",
                data: {subject_dept: dept_id, subject_faculty: faculty_id, subject_type: subject_type},
                beforeSend: function(xhr) {
                    jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                    $('#list_document-pagination').hide();
                },
                success: function(data) {
                    $('html, body').animate({scrollTop: 0}, 800);
                    var result = $.parseJSON(data);
                    setTimeout(function() {
                        jQuery('#list_document').empty();
                        jQuery.each(result.doc_data, function(key, value) {
                            jQuery('#list_document').append(
                                    '<li class="item_document">' +
                                    '<div class="box_item">' +
                                    '<div class="short_info_document clearfix">' +
                                    '<div class="document_img">' +
                                    '<img src="' + this.doc_url + '" height = "166">' +
                                    '<a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '" class="document_img_hover">' +
                                    '<span class="describe_document">' + this.doc_description + '</span>' +
                                    '</a>' +
                                    '</div>' +
                                    ' <ul class="document_status clearfix">' +
                                    '</ul>' +
                                    '<span class="attribution-user">' +
                                    '<a href="/sonvn" class="url_user" title="' + this.doc_author_name + '">' +
                                    '</a>' +
                                    '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="name_document"><a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '"><strong>' + this.doc_name + '</strong></a></div>' +
                                    '</li>'
                                    ).hide().fadeIn(500);
                        });
                        $('#list_document').paginate({itemsPerPage: 24});
                        jQuery('#filter_subject').html('');
                        jQuery.each(result.subject_data, function(key, value) {

                            jQuery('#filter_subject').append(
                                    '<label class="checkbox-styled">' +
                                    '<input type="checkbox"/>' +
                                    '<span class = "subject_filter" subject-link = "#subject-filter-' + this.subject_id + '" subject-id-filter = ' + this.subject_id + ' onclick="loaddoc(' + this.subject_id + ')">' + this.subject_name + '</span>' +
                                    '</label>').hide().fadeIn(500);
                        });

                        $('input[type="checkbox"]').on('change', function() {
                            $('input[type="checkbox"]').not(this).prop('checked', false);
                        });
                    }, 200);
                }
            });
        });

    });
</script>

<script type="text/javascript">
    // var $j = jQuery.noConflict();
    $(document).ready(function() {

        jQuery("a.dept").click(function() {
            var $self = $(this);
            var faculty_id = $self.attr("faculty-id");
            var dept_id = $self.attr("dept-id");
            var subject_type = $self.attr("subject-type");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('document/listdocumentdept') ?>",
                data: {subject_dept: dept_id, subject_faculty: faculty_id, subject_type: subject_type},
                beforeSend: function(xhr) {
                    jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                    $('#list_document-pagination').hide();
                },
                success: function(data) {
                    $('html, body').animate({scrollTop: 0}, 800);
                    var result = $.parseJSON(data);
                    setTimeout(function() {
                        jQuery('#list_document').empty();
                        jQuery.each(result.doc_data, function(key, value) {
                            jQuery('#list_document').append(
                                    '<li class="item_document">' +
                                    '<div class="box_item">' +
                                    '<div class="short_info_document clearfix">' +
                                    '<div class="document_img">' +
                                    '<img src="' + this.doc_url + '" height = "166">' +
                                    '<a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '" class="document_img_hover">' +
                                    '<span class="describe_document">' + this.doc_description + '</span>' +
                                    '</a>' +
                                    '</div>' +
                                    ' <ul class="document_status clearfix">' +
                                    '</ul>' +
                                    '<span class="attribution-user">' +
                                    '<a href="/sonvn" class="url_user" title="' + this.doc_author_name + '">' +
                                    '</a>' +
                                    '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="name_document"><a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '"><strong>' + this.doc_name + '</strong></a></div>' +
                                    '</li>'
                                    ).hide().fadeIn(500);
                        });
                        $('#list_document').paginate({itemsPerPage: 24});
                        jQuery('#filter_subject').html('');
                        jQuery.each(result.subject_data, function(key, value) {

                            jQuery('#filter_subject').append(
                                    '<label class="checkbox-styled">' +
                                    '<input type="checkbox"/>' +
                                    '<span class = "subject_filter" subject-link = "#subject-filter-' + this.subject_id + '" subject-id-filter = ' + this.subject_id + ' onclick="loaddoc(' + this.subject_id + ')">' + this.subject_name + '</span>' +
                                    '</label>').hide().fadeIn(500);
                        });
                        $('input[type="checkbox"]').on('change', function() {
                            $('input[type="checkbox"]').not(this).prop('checked', false);
                        });
                    }, 200);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    // var $j = jQuery.noConflict();
    $(document).ready(function() {

        jQuery("a.faculty").click(function() {
            var $self = $(this);
            var faculty_id = $self.attr("faculty-id");
            var dept_id = $self.attr("dept-id");
            var subject_type = $self.attr("subject-type");
            jQuery.ajax({
                type: "POST",
                url: "<?php echo Yii::app()->createUrl('document/listdocumentfaculty') ?>",
                data: {subject_dept: dept_id, subject_faculty: faculty_id, subject_type: subject_type},
                beforeSend: function(xhr) {
                    jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                    $('#list_document-pagination').hide();
                },
                success: function(data) {
                    $('html, body').animate({scrollTop: 0}, 800);
                    var result = $.parseJSON(data);
                    setTimeout(function() {
                        jQuery('#list_document').empty();
                        jQuery.each(result.doc_data, function(key, value) {
                            jQuery('#list_document').append(
                                    '<li class="item_document">' +
                                    '<div class="box_item">' +
                                    '<div class="short_info_document clearfix">' +
                                    '<div class="document_img">' +
                                    '<img src="' + this.doc_url + '" height = "166">' +
                                    '<a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '" class="document_img_hover">' +
                                    '<span class="describe_document">' + this.doc_description + '</span>' +
                                    '</a>' +
                                    '</div>' +
                                    ' <ul class="document_status clearfix">' +
                                    '</ul>' +
                                    '<span class="attribution-user">' +
                                    '<a href="/sonvn" class="url_user" title="' + this.doc_author_name + '">' +
                                    '</a>' +
                                    '</span>' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="name_document"><a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '"><strong>' + this.doc_name + '</strong></a></div>' +
                                    '</li>'
                                    ).hide().fadeIn(500);
                        });
                        $('#list_document').paginate({itemsPerPage: 24});
                        jQuery('#filter_subject').html('');
//Scrip Loc theo mon hoc - bar-right
                        jQuery.each(result.subject_data, function(key, value) {

                            jQuery('#filter_subject.filter_subjects').append(
                                    '<label class="checkbox-styled">' +
                                    '<input type="checkbox"/>' +
                                    '<span class = "subject_filter" subject-link = "#subject-filter-' + this.subject_id + '" subject-id-filter = ' + this.subject_id + ' onclick="loaddoc(' + this.subject_id + ')">' + this.subject_name + '</span>' +
                                    '</label>').hide().fadeIn(500);
                        });
                        $('input[type="checkbox"]').on('change', function() {
                            $('input[type="checkbox"]').not(this).prop('checked', false);
                        });
                    }, 200);
                }
            });
        });

    });
</script>


<script type="text/javascript">
    // var $j = jQuery.noConflict();
    function loaddocpagedoc() {

        var $self = $(this);
        var faculty_id = $self.attr("faculty-id");
        var dept_id = $self.attr("dept-id");
        var subject_type = $self.attr("subject-type");
        jQuery.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('document/listdocumentfaculty') ?>",
            data: {subject_dept: 1, subject_faculty: 1, subject_type: 1},
            beforeSend: function(xhr) {
                jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                $('#list_document-pagination').hide();
            },
            success: function(data) {
                $('html, body').animate({scrollTop: 0}, 800);
                var result = $.parseJSON(data);
                setTimeout(function() {
                    jQuery('#list_document').empty();
                    jQuery.each(result.doc_data, function(key, value) {
                        jQuery('#list_document').append(
                                '<li class="item_document">' +
                                '<div class="box_item">' +
                                '<div class="short_info_document clearfix">' +
                                '<div class="document_img">' +
                                '<img src="' + this.doc_url + '" height = "166">' +
                                '<a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '" class="document_img_hover">' +
                                '<span class="describe_document">' + this.doc_description + '</span>' +
                                '</a>' +
                                '</div>' +
                                ' <ul class="document_status clearfix">' +
                                '</ul>' +
                                '<span class="attribution-user">' +
                                '<a href="/sonvn" class="url_user" title="' + this.doc_author_name + '">' +
                                '</a>' +
                                '</span>' +
                                '</div>' +
                                '</div>' +
                                '<div class="name_document"><a href="<?php echo Yii::app()->createAbsoluteUrl('viewDocument') ?>/' + this.doc_id + '/' + updateKey('' + this.doc_name + '') + '"><strong>' + this.doc_name + '</strong></a></div>' +
                                '</li>'
                                ).hide().fadeIn(500);
                    });
                    $('#list_document').paginate({itemsPerPage: 24});
                    jQuery('#filter_subject').html('');
                    jQuery.each(result.subject_data, function(key, value) {

                        jQuery('#filter_subject.filter_subjects').append(
                                '<label class="checkbox-styled">' +
                                '<input type="checkbox"/>' +
                                '<span class = "subject_filter" subject-link = "#subject-filter-' + this.subject_id + '" subject-id-filter = ' + this.subject_id + ' onclick="loaddoc(' + this.subject_id + ')">' + this.subject_name + '</span>' +
                                '</label>').hide().fadeIn(500);
                    });
                    $('input[type="checkbox"]').on('change', function() {
                        $('input[type="checkbox"]').not(this).prop('checked', false);
                    });
                }, 200);
            }

        });

    }
    ;
    jQuery(document).ready(function($) {
        var hash = window.location.hash;
        var loc = window.location;
        if (hash.length !== 0) {
            if (hash === "#_=_") {
                 history.pushState("", document.title, loc.pathname + loc.search);
                 location.reload();}
            else {
                $('a[href="' + hash + '"]').trigger("click");
                $(document).on('click', 'span[subject-link="' + hash + '"]', function() {
                    alert('Clicked!');
                });
            }

            // do something
            //     $('span[subject-link="' + hash + '"]').live('click');
            console.log(hash);
        } else {
            window.onload = loaddocpagedoc;
            //console.log(hash);
        }
    });
</script>