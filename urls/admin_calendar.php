<?php
$aUrlPatterns_import = array(
	"/admin/calendar/" => array(
        "cmd" => "admin_calendar",
        "action" => "index"
    ),
	"/admin/calendar/add/" => array(
        "cmd" => "admin_calendar",
        "action" => "add"
    ),
	"/admin/calendar/add/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "add_s"
    ),
	"/admin/calendar/edit/{id:[0-9]+}/" => array(
        "cmd" => "admin_calendar",
        "action" => "edit"
    ),
	"/admin/calendar/edit/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "edit_s"
    ),
	"/admin/calendar/delete/{id:[0-9]+}/" => array(
        "cmd" => "admin_calendar",
        "action" => "delete"
    ),
	"/admin/calendar/image/{id:[0-9]+}/upload/" => array(
        "cmd" => "admin_calendar",
        "action" => "image_upload"
    ),
	"/admin/calendar/image/upload/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "image_upload_s"
    ),
	"/admin/calendar/image/{id:[0-9]+}/edit/" => array(
        "cmd" => "admin_calendar",
        "action" => "image_edit"
    ),
	"/admin/calendar/image/edit/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "image_edit_s"
    ),
	"/admin/calendar/image/{id:[0-9]+}/delete/" => array(
        "cmd" => "admin_calendar",
        "action" => "image_delete"
    ),
	"/admin/calendar/categories/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_index"
    ),
	"/admin/calendar/categories/add/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_add"
    ),
	"/admin/calendar/categories/add/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_add_s"
    ),
	"/admin/calendar/categories/edit/{id:[0-9]+}/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_edit"
    ),
	"/admin/calendar/categories/edit/s/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_edit_s"
    ),
	"/admin/calendar/categories/delete/{id:[0-9]+}/" => array(
        "cmd" => "admin_calendar",
        "action" => "categories_delete"
    )
);