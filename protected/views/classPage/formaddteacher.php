<form class="g-form white-popup-block mfp-hide" id="add-brand-new-teacher" action="" method="POST">
    <h3>Thêm giáo viên mới</h3>
    <div class="g-form-group">
        <div class="g-form-group-rows">
            <div class="g-form-row">
                <div class="g-form-row-label">
                    <label class="g-form-row-label-h" for="classcode">Tên (*)</label>
                </div>
                <div class="g-form-row-field">
                    <div class="g-input">
                        <input type="text" name="classcode" id="contact_username" placeholder="Tên" value="">
                    </div>
                </div>
            </div>
            <div class="g-form-row">
                <div class="g-form-row-label">
                    <label class="g-form-row-label-h" for="classCredit">Ngày sinh (*)</label>
                </div>
                <div class="g-form-row-field">
                    <div class="g-input">
                        <input type="text" name="classCredit" id="contact_username" placeholder="Ngày sinh" value="">
                    </div>
                </div>
            </div>
            <div class="g-form-row">
                <div class="g-form-row-label">
                    <label class="g-form-row-label-h" for="classname">Trang cá nhân (*)</label>
                </div>
                <div class="g-form-row-field">
                    <div class="g-input">
                        <input type="text" name="classname" id="contact_username" placeholder="Trang cá nhân" value="">
                    </div>
                </div>
            </div>
            <div class="g-form-row">
                <div class="g-form-row-label">
                    <label class="g-form-row-label-h" for="classCredit">Nơi công tác (*)</label>
                </div>
                <div class="g-form-row-field">
                    <div class="g-input">
                        <input type="text" name="classCredit" id="contact_username" placeholder="Nơi công tác" value="">
                    </div>
                </div>
            </div>
            <div class="g-form-row">
                <div class="g-form-row-label">
                    <label class="g-form-row-label-h" for="classCredit">Giới tính (*)</label>
                </div>
                <div class="g-form-row-field">
                    <input type="radio" id="0" name="sex" value="0"> <label>Nam</label>
                    <input type="radio" id="1" name="sex" value="1"> <label>Nữ</label>
                    <script>
                        $(document).ready(function() {
                            $('input#0').attr('checked', 'checked');
                            $('#btnGetSelected').click(function() {
                                //alert($('input:radio[name="sex"]:checked').val());
                            });
                        });
                    </script>
                </div>
            </div>
            <div class="g-form-row">
                <div class="g-form-row-field">
                    <button class="g-btn type_primary" type="submit" name="Submit" value="Submit" style="text-transform: inherit" id="btnGetSelected" action="">Thêm giáo viên</button>
                </div>
            </div>
        </div>
        <div id="alert11"></div>
    </div>
</form>