<?php

return array(
    "fields" => array(
        "id" => array(
            "label" => "Subject Type ID"
        ),
        "subject_type_name" => array(
            "label" => "Subject Type Name"
        ),
        
    ),
    "columns" => array(
        "id", "subject_type_name", 
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "subject_type_name",
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "subject_type_name", 
            ),
        ),
        "_search" => array(
            "subject_type_name",
        ),
        "_search_advanced" => array(
            "subject_type_name",
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
    "tableAlias" => "subjecttype",
    "title" => "Type of Subject Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "SubjectType",
    "primary" => "id",
    "itemLabel" => "subjecttype",
    "additionalFiles" => array()
);
