<?php

return array(
    "fields" => array(
        "subject_id" => array(
            "label" => "Subject ID"
        ),
        "subject_name" => array(
            "label" => "Subject Name",
        ),
        "subject_code" => array(
            "label" => "Subject Code",
        ),
        "subject_credits" => array(
            "label" => "Credits of subject"
        ),
        "subject_credit_hour" => array(
            "label" => "Credit - Hour",
        ),
        "subject_faculty" => array(
            "label" => "Faculty",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "faculty_id",
                "displayAttr" => "faculty_name",
                "src" => function() {
            $rows = Faculty::model()->findAll();
            return $rows;
        },),),
        "subject_dept" => array(
            "label" => "Department",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "dept_id",
                "displayAttr" => "dept_name",
                "src" => function() {
            $rows = Dept::model()->findAll();
            return $rows;
        }
            ),
        ),
       
        "subject_general_faculty_id" => array(
           "label" => "Faculty Common",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "faculty_id",
                "displayAttr" => "faculty_name",
                "src" => function() {
            $rows = Faculty::model()->findAll();
            return $rows;
        }
            ),),
//        "doc_dept_name" => array(
//            "label" => "Department Name",
//            "src" => "dept.dept_name",
//        ),
    ),
    "columns" => array(
        "subject_id", "subject_name", "subject_code", "subject_credits", "subject_credit_hour", "subject_dept", "subject_faculty", "subject_general_faculty_id", 
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "subject_name", "subject_code", "subject_credits", "subject_credit_hour", "subject_dept", "subject_faculty","subject_general_faculty_id", 
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "subject_name", "subject_code", "subject_credits", "subject_credit_hour", "subject_dept", "subject_faculty", "subject_general_faculty_id"
            ),
        ),
        "_search" => array(
            "subject_name", "subject_code",
        ),
        "_search_advanced" => array(
            "subject_name", "subject_code", 
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "subject_id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
//    "join" => array(
//        "dept" => array(
//            "table" => "select dept_id, dept_name from tbl_dept",
//            "type" => "left join",
//            "selected_properties" => array(
//                "dept_name" => "doc_dept_name" //select tu dept join voi doc
//            ),
//            "on" => array(
//                "dept_id" => "t.subject_dept"
//            )
//        ),
//    ),
    // select dept.dept_name as doc_dept_name, t.* from ....... lefr join (select dept_id, dept_name from tbl_dept) dept ON dept.dept_id = t.subject_dept
    "tableAlias" => "subject",
    "title" => "Subject Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Subject",
    "primary" => "subject_id",
    "itemLabel" => "Subject",
    "additionalFiles" => array(),
);
