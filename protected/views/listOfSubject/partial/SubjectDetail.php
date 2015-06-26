<script type="text/javascript">
    $(document).ready(function() {
        $("a.subject").each(function() {
            $(this).click(function(e){
                
                e.preventDefault();
                e.stopPropagation();
                
               /* var faculty_id = $(this).attr("faculty-id");
                var dept_id = $(this).attr("dept-id");
                var subject_type = $(this).attr("subject-type");

                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('listOfSubject/listOfSubjectInfo') ?>",
                    data: {subject_dept: dept_id, subject_faculty: faculty_id, subject_type: subject_type},
                    dataType: 'json',
                    success: function(data) {
                        var json = data;
                        var result = data;
                        $('#listsubject').html('');

                        $.each(result.subject_data, function(key, value) {

                            $('#listsubject').append(
                                    '<tr style="border-bottom: 1px solid #d0d6d9">' +
                                    '<td><a href = "<?php echo Yii::app()->createUrl('subject') ?>' + this.subject_id + '">' + this.subject_name + '</a></td>' +
                                    '<td>2</td>' +
                                    '<td>21 - 5 - 4</td>' +
                                    '<td>PHI1004</td>' +
                                    '</tr>');

                        });
                    }
                });*/
                
                return false;
            });


        });
    });
</script>
<table class="g-table">
    <thead>
        <tr>
            <th>Môn học</th>
            <th>Số tín chỉ</th>
            <th>Số giờ tín chỉ</th>
            <th>Mã môn học</th>
        </tr>
    </thead>
    <tbody id="listsubject">

    </tbody>
</table>