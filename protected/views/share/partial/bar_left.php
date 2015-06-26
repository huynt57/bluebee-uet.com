<div class="one-fourth" style="
     border-right-style: double;
     border-right-width: thick;
     border-color: #d0d6d9;
     ">
    <h3>Các ngành học</h3>
    <div class="widget">
        <nav class="w-nav">
            <div class="w-nav-h">
                <div class="w-nav-list layout_ver level_1">
                    <div class="w-nav-list-h">
                        <?php foreach ($category_father as $category): ?>
                            <div class="w-nav-item level_1 active">
                                <?php $dept = Dept::model()->findAllByAttributes(array('dept_faculty' => $category->faculty_id)); ?>
                                <div class="w-nav-item-h">
                                    <a href="#faculty-<?php echo $category->faculty_id ?>" class="w-nav-anchor level_1 faculty" faculty-id="<?php echo $category->faculty_id ?>"><?php echo $category->faculty_name ?>
                                        <span class="w-nav-title " ></span>
                                    </a>
                                    <?php
                                    if ($dept) {
                                        foreach ($dept as $dept_detail):
                                            ?>
                                            <div class="w-tabs layout_accordion type_toggle">
                                                <div class="w-tabs-h">
                                                    <div class="w-tabs-section with_icon">
                                                        <div class="w-tabs-section-title">
                                                            <a href="#dept-<?php echo $category->faculty_id ?>-<?php echo $dept_detail->dept_id ?>" class="w-tabs-section-title-text dept" style="margin-left: 32px" faculty-id="<?php echo $category->faculty_id ?>" dept-id="<?php echo $dept_detail->dept_id ?>">- <?php echo $dept_detail->dept_name ?></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <div class="w-tabs-section-content">
                                            <div class="w-tabs-section-content-h">
                                                <?php foreach ($subject_type as $subject_detail): ?>
                                                    <div class="w-nav-item level_2 active">
                                                        <div class="w-nav-item-h">
                                                            <a href="#dept-<?php echo $category->faculty_id ?>-<?php echo $dept_detail->dept_id ?>" class="w-nav-anchor level_2 subject" faculty-id="<?php echo $category->faculty_id; ?>" dept-id="<?php echo $dept_detail->dept_id ?>" subject-type="<?php echo $subject_detail->id ?>">
                                                                <span class="w-nav-title" >
                                                                    <?php echo $subject_detail->subject_type_name ?>
                                                                </span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>