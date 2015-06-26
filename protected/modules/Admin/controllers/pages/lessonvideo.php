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
        "video_link" => array(
            "label" => "Video Link (Youtube or Vimeo)"
        ),
      
        
    ),
    "columns" => array(
        "id","lesson_id", "video_link" 
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "lesson_id", "video_link" 
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "lesson_id", "video_link" 
            ),
        ),
        "_search" => array(
             "lesson_id", "video_link" 
        ),
        "_search_advanced" => array(
             "lesson_id", "video_link" 
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
    "tableAlias" => "lessonvideo",
    "title" => "Lesson - Video Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "LessonVideo",
    "primary" => "id",
    "itemLabel" => "lessonvideo",
    "additionalFiles" => array()
);
