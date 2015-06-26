<?php

return array(
    "fields" => array(
        "id" => array(
            "label" => "ID"
        ),
        "subject_id" => array(
            "label" => "Subject Name",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "subject_id",
                "displayAttr" => "subject_name",
                "src" => function() {
            $rows = Subject::model()->findAll();
            return $rows;
        },),
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
    ),
    "columns" => array(
        "id", "subject_id","teacher_id"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
           "subject_id","teacher_id"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "subject_id","teacher_id"
            ),
        ),
        "_search" => array(
            "subject_id","teacher_id"
        ),
        "_search_advanced" => array(
            "subject_id","teacher_id"
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
    "tableAlias" => "subjectteacher",
    "title" => "Subject - Teacher Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "SubjectTeacher",
    "primary" => "id",
    "itemLabel" => "subjectteacher",
    "additionalFiles" => array()
);
