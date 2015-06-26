

<script type="text/javascript">
    $(document).ready(function() {
        $("a.dept").each(function() {
            var faculty_id = $(this).attr("faculty-id");
            var dept_id = $(this).attr("dept-id");
            $(this).click(function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo Yii::app()->createUrl('listOfSubject/deptInfo') ?>",
                    data: {faculty_id: faculty_id, dept_id: dept_id},
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                    }

                });
            });
        });
    });
</script>
