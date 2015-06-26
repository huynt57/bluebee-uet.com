<?php

return array(
    "fields" => array(
        "teacher_id" => array(
            "label" => "Teacher ID"
        ),
        "teacher_name" => array(
            "label" => "Name",
        ),
        "teacher_personal_page" => array(
            "label" => "Personal Page",
            "type" => "_link"
        ),
        "teacher_avatar" => array(
            "label" => "Avatar",
            "type" => "_image",
            "modelFile" => "teacher_path_file",
        ),
        "teacher_description" => array(
            "label" => "Description",
            "type" => "_textarea"
        ),
        "teacher_work_place" => array(
            "label" => "Work place",
            "type" => "_textarea"
        ),
        "teacher_acadamic_title" => array(
            "label" => "Academic Title",
        ),
        "teacher_birthday" => array(
            "label" => "Birthday",
        ),
        "teacher_sex" => array(
            "label" => "Gender",
            "type" => "_dropdown",
            "list" => array("1" => "Nam", "0" => "Nữ")
        ),
        "teacher_faculty" => array(
            "label" => "Faculty",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "faculty_id",
                "displayAttr" => "faculty_name",
                "src" => function() {
            $rows = Faculty::model()->findAll();
            return $rows;
        },),
        ),
        "teacher_dept" => array(
            "label" => "Department",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "dept_id",
                "displayAttr" => "dept_name",
                "src" => function() {
            $rows = Dept::model()->findAll();
            return $rows;
        },),
        ),
        "teacher_rate" => array(
            "label" => "Rating",
        ),
        "teacher_personality" => array(
            "label" => "Personality",
            "type" => "_textarea",
        ),
        "advices" => array(
            "label" => "Advices for teacher",
        ),
        "teacher_research" => array(
            "label" => "Research",
            "type" => "_html"
        ),
    ),
    "columns" => array(
        "teacher_id", "teacher_name", "teacher_avatar", "teacher_acadamic_title", "teacher_faculty", "teacher_dept", "teacher_rate", "teacher_sex"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "teacher_name", "teacher_avatar", "teacher_personal_page", "teacher_acadamic_title", "teacher_faculty", "teacher_dept", "teacher_rate", "teacher_sex", "teacher_description", "teacher_work_place",
            "teacher_birthday", "advices", "teacher_research"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "teacher_name", "teacher_avatar", "teacher_personal_page", "teacher_acadamic_title", "teacher_faculty", "teacher_dept", "teacher_rate", "teacher_sex", "teacher_description", "teacher_work_place",
                "teacher_birthday", "advices", "teacher_research"
            ),
        ),
        "_search" => array(
            "teacher_name", "teacher_id",
        ),
        "_search_advanced" => array(
            "teacher_name", "teacher_id",
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "teacher_id",
        "orderType" => "desc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    // select dept.dept_name as doc_dept_name, t.* from ....... lefr join (select dept_id, dept_name from tbl_dept) dept ON dept.dept_id = t.subject_dept
    "tableAlias" => "teacher",
    "title" => "Teacher Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Teacher",
    "primary" => "teacher_id",
    "itemLabel" => "Teacher",
    "additionalFiles" => array(),
    "insertScenario" => "fromAdmin",
    "updateScenario" => "fromAdmin",
    "formUpload" => TRUE,
);
