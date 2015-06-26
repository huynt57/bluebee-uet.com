<?php

return array(
    "fields" => array(
        "subject_type_id" => array(
            "label" => "ID"
        ),
        "subject_group_type" => array(
            "label" => "Subject Group Type Name"
        ),
        "subject_group" => array(
            "label" => "Subject Type",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "id",
                "displayAttr" => "subject_type_name",
                "src" => function() {
            $rows = SubjectType::model()->findAll();
            return $rows;
        },),),
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
    ),
    "columns" => array(
        "subject_type_id", "subject_group_type","subject_dept","subject_faculty","subject_group"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "subject_group_type","subject_dept","subject_faculty","subject_group"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "subject_group_type","subject_dept","subject_faculty","subject_group"
            ),
        ),
        "_search" => array(
            "subject_group_type",
        ),
        "_search_advanced" => array(
            "subject_group_type",
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "subject_type_id",
        "orderType" => "asc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "subjectgrouptype",
    "title" => "Type of Group Subject Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "SubjectGroupType",
    "primary" => "subject_type_id",
    "itemLabel" => "subjectgrouptype",
    "additionalFiles" => array()
);
