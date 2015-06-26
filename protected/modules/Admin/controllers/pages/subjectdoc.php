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
         "doc_type" => array(
            "label" => "Document Type",
//             "type" => "_dropdown",
//            "_list" => array(
//                "primary" => "doc_id",
//                "displayAttr" => "doc_name",
//                "src" =>function() { 
//                $rows = array('1' => 'Ảnh', '2' => 'Tài liệu thường', '3' => 'Tài liệu nén');
//                return $rows;}
//                ),
            ),
        
    ),
    "columns" => array(
        "id","doc_id", "subject_id" , "doc_type"
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "subject_id","doc_id", "doc_type"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "subject_id","doc_id", "doc_type"
            ),
        ),
        "_search" => array(
             "subject_id","doc_id", "doc_type"
        ),
        "_search_advanced" => array(
             "subject_id","doc_id", "doc_type"
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
    "tableAlias" => "subjectdoc",
    "title" => "Subject - Doc Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "SubjectDoc",
    "primary" => "id",
    "itemLabel" => "subjectdoc",
    "additionalFiles" => array()
);
