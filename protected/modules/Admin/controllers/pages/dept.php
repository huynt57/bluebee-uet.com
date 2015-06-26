<?php

return array(
    "fields" => array(
        "dept_id" => array(
            "label" => "Department ID"
        ),
        "dept_name" => array(
            "label" => "Department Name"
        ),
        "dept_faculty_name" => array(
            "label" => "Faculty of Department",
            "src" => "faculty.faculty_name",
        ),
        "dept_knowleadge" => array(
            "label" => "Knowledge"
        ),
        "dept_behavior" => array(
            "label" => "Behavior",
            "type" => "_html"
        ),
        "dept_target" => array(
            "label" => "Target",
            "type" => "_html"
        ),
        "dept_out_standard" => array(
            "label" => "Out Standard",
            "type" => "_html"
        ),
        "dept_in_standart" => array(
            "label" => "In Standard",
            "type" => "_html"
        ),
        "dept_contact" => array(
            "label" => "Contact",
            "type" => "_html"
        ),
        "dept_language" => array(
            "label" => "Language",
        ),
       
        "dept_credits" => array(
            "label" => "Credit Number",
        ),
        "dept_code" => array(
            "label" => "Code Dept",
        ),
         "dept_skill" => array(
            "label" => "Skill",
             'type' => "_html",
        ),
    ),
    "columns" => array(
        "dept_id", "dept_name", "dept_faculty_name", "dept_code",  "dept_credits"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "dept_name", "dept_faculty_name", "dept_code",  "dept_credits", "dept_knowleadge", "dept_behavior", "dept_target" ,"dept_out_standard","dept_in_standart","dept_contact","dept_language","dept_skill"
        ),
        "_delete" => true,
        "_new" => false,
        "_search" => array(
            "dept_name", "dept_code", 
        ),
        "_search_advanced" => array(
            "dept_name", "dept_code", 
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "dept_id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "dept",
    "title" => "Department Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Dept",
    "primary" => "dept_id",
    "itemLabel" => "Dept",
    "additionalFiles" => array(),
     "join" => array(
        "faculty" => array(
            "table" => "select faculty_id, faculty_name from tbl_faculty",
            "type" => "left join",
            "selected_properties" => array(
                "faculty_name" => "dept_faculty_name" //select tu dept join voi doc
            ),
            "on" => array(
                "faculty_id" => "t.dept_faculty"
            )
        ),
    ),
    // select dept.dept_name as doc_dept_name, t.* from ....... lefr join (select dept_id, dept_name from tbl_dept) dept ON dept.dept_id = t.subject_dept
);
