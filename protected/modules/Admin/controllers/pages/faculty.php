<?php

return array(
    "fields" => array(
        "faculty_id" => array(
            "label" => "Faculty ID"
        ),
        "faculty_name" => array(
            "label" => "Faculty Name"
        ),
        "faculty_research" => array(
            "label" => "Faculty Research",
            "type" => "_html"
        ),
        "faculty_lab" => array(
            "label" => "Faculty Lab",
            "type" => "_html"
        ),
    ),
    "columns" => array(
        "faculty_id", "faculty_name", 
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "faculty_name", "faculty_research", "faculty_lab",
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "faculty_name", "faculty_research", "faculty_lab",
            ),
        ),
        "_search" => array(
            "faculty_name",
        ),
        "_search_advanced" => array(
            "faculty_name",
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "faculty_id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "faculty",
    "title" => "Faculty Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Faculty",
    "primary" => "faculty_id",
    "itemLabel" => "faculty",
    "additionalFiles" => array()
);
