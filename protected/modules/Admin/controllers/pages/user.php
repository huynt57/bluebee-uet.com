<?php

return array(
    "fields" => array(
        "user_id" => array(
            "label" => "User ID"
        ),
        "user_id_fb" => array(
            "label" => "User ID facebook"
        ),
        "username" => array(
            "label" => "User Email"
        ),
        "user_real_name" => array(
            "label" => "User Name"
        ),
        "user_avatar" => array(
            "label" => "User Avatar",
            "type" => "_image"
        ),
        "user_dob" => array(
            "label" => "User DOB"
        ),
        "user_hometown" => array(
            "label" => "User Home"
        ),
    ),
    "columns" => array(
        "user_id", "user_id_fb", "user_real_name", "user_avatar",
    ),
    "actions" => array(
        "_view" => true,
        "_edit" => array(
            "user_real_name", "username",
        ),
        "_delete" => true,
        "_new" => false,
        "_search" => array(
            "user_id", "username", "user_real_name"
        ),
        "_search_advanced" => array(
            "user_id", "username", "user_real_name",
        ),
        "_customButtons" => array()
    ),
    "default" => array(
        "orderBy" => "user_id",
        "orderType" => "desc",
        "page" => 1,
        "per_page" => 10,
        "search" => "",
        "search_advanced" => ""
    ),
    "tableAlias" => "user",
    "title" => "User Manager",
    "condition" => false,
    "limit_values" => array(10, 20, 30, 40),
    "model" => "User",
    "primary" => "user_id",
    "itemLabel" => "User",
    "additionalFiles" => array()
);
