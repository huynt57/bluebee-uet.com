<?php

return array(
    "fields" => array(
        "id" => array(
            "label" => "ID"
        ),
        "teacher_id" => array(
            "label" => "Teacher Name",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "teacher_id",
                "displayAttr" => "teacher_name",
                "src" => function() {
            $rows = Teacher::model()->findAll();
            return $rows;
        },),
        ),
        "faculty_id" => array(
            "label" => "Faculty Name",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "faculty_id",
                "displayAttr" => "faculty_name",
                "src" => function() {
            $rows = Faculty::model()->findAll();
            return $rows;
        },),
        ),
        "teacher_position" => array(
            "label" => "Teacher position"
        ),
    ),
    "columns" => array(
        "id", "teacher_id", "faculty_id", "teacher_position"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "teacher_id", "faculty_id", "teacher_position"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "teacher_id", "faculty_id", "teacher_position"
            ),
        ),
        "_search" => array(
            "teacher_id", "faculty_id", "teacher_position"
        ),
        "_search_advanced" => array(
            "teacher_id", "faculty_id", "teacher_position"
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "teacherfacultypos",
    "title" => "Teacher Position in Faculty",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "TeacherFacultyPosition",
    "primary" => "id",
    "itemLabel" => "teacherfacultypos",
    "additionalFiles" => array()
);
