<?php

return array(
    "fields" => array(
        "lesson_id" => array(
            "label" => "ID"
        ),
        "lesson_weeks" => array(
            "label" => "Lesson week"
        ),
        "lesson_subject" => array(
            "label" => "Lesson of Subject",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "subject_id",
                "displayAttr" => "subject_name",
                "src" => function() {
            $rows = Subject::model()->findAll();
            return $rows;
        },),
        ),
        "lesson_doc" => array(
            "label" => "Document of Lesson",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "doc_id",
                "displayAttr" => "doc_name",
                "src" => function() {
            $rows = Doc::model()->findAll();
            return $rows;
        },),
        ),
    ),
    "columns" => array(
        "lesson_id", "lesson_weeks", "lesson_subject", "lesson_doc"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
             "lesson_weeks", "lesson_subject", "lesson_doc"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                 "lesson_weeks", "lesson_subject", "lesson_doc"
            ),
        ),
        "_search" => array(
             "lesson_weeks", "lesson_subject", "lesson_doc"
        ),
        "_search_advanced" => array(
             "lesson_weeks", "lesson_subject", "lesson_doc"
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "lesson_id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "lesson",
    "title" => "Lesson Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Lesson",
    "primary" => "lesson_id",
    "itemLabel" => "lesson",
    "additionalFiles" => array()
);
