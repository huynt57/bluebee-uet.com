<?php

return array(
    "fields" => array(
        "id" => array(
            "label" => "ID"
        ),
         "lesson_id" => array(
            "label" => "Lesson Name",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "lesson_id",
                "displayAttr" => "lesson_name",
                "src" => function() {
            $rows = Lesson::model()->findAll();
            return $rows;
        },),),
        "doc_id" => array(
            "label" => "Document Name",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "doc_id",
                "displayAttr" => "doc_name",
                "src" => function() {
            $rows = Doc::model()->findAll();
            return $rows;
        },),),
      
        
    ),
    "columns" => array(
        "id","lesson_id", "doc_id" 
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "lesson_id", "doc_id" 
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "lesson_id", "doc_id" 
            ),
        ),
        "_search" => array(
             "lesson_id", "doc_id" 
        ),
        "_search_advanced" => array(
             "lesson_id", "doc_id" 
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
    "tableAlias" => "lessondoc",
    "title" => "Lesson - Doc Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "LessonDoc",
    "primary" => "id",
    "itemLabel" => "lessondoc",
    "additionalFiles" => array()
);
