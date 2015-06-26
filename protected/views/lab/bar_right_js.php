<script type="text/javascript">
    function loaddoc(id) {
        var $self = $(this);
        jQuery.ajax({
            type: "POST",
            url: "<?php echo Yii::app()->createUrl('lab/FilterDocumentBySubject') ?>",
            beforeSend: function(xhr) {
                jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                $('#list_document-pagination').hide();
            },
            data: {subject_id: id},
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
                                '<img src="' + this.doc_url + '" height = "166px">' +
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
                    $('#list_document-pagination').show();
                    $('#list_document').paginate({itemsPerPage: 24});
                }, 200);
            }
        });

    }
    ;
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var form = $('#box-choose-subjects');
        form.submit(function(event) {
            var data = form.serialize();
            // $('#box-choose-subjects').slideUp('400');
            $.ajax({
                type: "POST",
                url: '<?php echo Yii::app()->createUrl('lab/FilterSubjectByForm') ?>',
                dataType: 'json',
                data: data,
                beforeSend: function(xhr) {
                    jQuery('#list_document').html('<img src = "<?php echo Yii::app()->theme->baseUrl; ?>/assets/img/ajax_loader_blue_128.gif" style = "padding-left:200px; padding-top: 100px;"/>');
                    $('#list_document-pagination').hide();
                },
                success: function(data) {
                    $('html, body').animate({scrollTop: 0}, 800);
                    var result = data;
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
                        $('#list_document-pagination').show();
                        $('#list_document').paginate({itemsPerPage: 24});
                    });
                }});

            event.preventDefault();
            event.stopPropagation();
            return false;
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "get",
            url: '<?php echo Yii::app()->createUrl('lab/suggestsubjects') ?>',
            success: function(data) {
                var arr = $.parseJSON(data);
                $("#choose-subjects").tokenInput(
                        arr
                        , {
                            theme: "facebook",
                            preventDuplicates: true,
                            hintText: "Nhập môn bạn cần tìm tại đây",
                            noResultsText: "Không tìm thấy kết quả",
                            searchingText: "Đang tìm kiếm"
                        });
            }
        });
    });
</script>
