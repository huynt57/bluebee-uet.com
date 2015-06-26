<?php

return array(
    "fields" => array(
        "doc_id" => array(
            "label" => "Doc ID"
        ),
        "doc_path" => array(
            "label" => "File",
            "type" => "_document",
            "modelFile" => "doc_path_file"
        ),
        "doc_url" => array(
            "label" => "Preview",
            "type" => "_image",
        ),
        "doc_name" => array(
            "label" => "Doc Name"
        ),
        "doc_description" => array(
            "label" => "Doc Description",
            "type" =>"_textarea"
        ),
        "doc_author_name" => array(
            "label" => "User upload",
        ),
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
        "subject_doc" => array(
            "label" => "Subject",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "subject_id",
                "displayAttr" => "subject_name",
                "src" => function() {
            $rows = Subject::model()->findAll();
            return $rows;
        }
            )
        ),
        "subject_faculty" => array(
            "label" => "Faculty",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "faculty_id",
                "displayAttr" => "faculty_name",
                "src" => function() {
            $rows = Faculty::model()->findAll();
            return $rows;
        }
            )),
        "subject_type" => array(
            "label" => "Subject Type",
            "type" => "_dropdown",
            "_list" => array(
                "primary" => "id",
                "displayAttr" => "subject_type_name",
                "src" => function() {
            $rows = SubjectType::model()->findAll();
            return $rows;
        }
            ),),
        "doc_dept_name" => array(
            "label" => "Department",
            "src" => "dept.dept_name",
        ),
    ),
    "columns" => array(
        "doc_id", "doc_url", "doc_name", "doc_description", "doc_author_name", "subject_faculty", "doc_dept_name", "doc_path",
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "doc_name", "doc_description", "doc_author_name", "subject_dept", "subject_faculty", "subject_type"
        ),
        "_delete" => true,
        "_new" => array(
            "type" => "popup",
            "attr" => array(
                "doc_name", "doc_description", "doc_path", "subject_doc"
            ),
            "extend" => array(
                "doc_author" => Util::param("ADMIN_ID"),
                "doc_author_name" => "Admin"
            )
        ),
        "_search" => array(
            "doc_id", "doc_name",
        ),
        "_search_advanced" => array(
            "doc_author_name", "subject_dept", "subject_faculty", "doc_name",
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "doc_id",
        "orderType" => "desc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "join" => array(
        "dept" => array(
            "table" => "select dept_id, dept_name from tbl_dept",
            "type" => "left join",
            "selected_properties" => array(
                "dept_name" => "doc_dept_name" //select tu dept join voi doc
            ),
            "on" => array(
                "dept_id" => "t.subject_dept"
            )
        ),
    ),
    // select dept.dept_name as doc_dept_name, t.* from ....... lefr join (select dept_id, dept_name from tbl_dept) dept ON dept.dept_id = t.subject_dept
    "tableAlias" => "document",
    "title" => "Document Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "Doc",
    "primary" => "doc_id",
    "itemLabel" => "Document",
    "additionalFiles" => array(),
    "insertScenario" => "fromAdmin",
    "updateScenario" => "fromAdmin",
    "formUpload" => TRUE,
);
