<?php
# Custom URL using mod_rewrite

### Url Pattern ###############################
/*
# Function Variable Order:
#   1. URL parameters (<name:[a-z]+>)
#   2. Pattern parameters
#
# Example URL Patterns:
#   /page/<name:[a-z0-9]+>/
#   /<tag:[a-z]+>/
*/
$aPluginUrlPatterns = array(
  "/admin/content/" => array(
    "cmd" => "admin_content",
    "action" => "index"
  ),
  "/admin/content/add/" => array(
    "cmd" => "admin_content",
    "action" => "add"
  ),
  "/admin/content/add/s/" => array(
    "cmd" => "admin_content",
    "action" => "add_s"
  ),
  "/admin/content/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_content",
    "action" => "edit"
  ),
  "/admin/content/edit/s/" => array(
    "cmd" => "admin_content",
    "action" => "edit_s"
  ),
  "/admin/content/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_content",
    "action" => "delete"
  ),
  "/admin/content/excerpts/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts"
  ),
  "/admin/content/excerpts/add/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts_add"
  ),
  "/admin/content/excerpts/add/s/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts_add_s"
  ),
  "/admin/content/excerpts/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts_edit"
  ),
  "/admin/content/excerpts/edit/s/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts_edit_s"
  ),
  "/admin/content/excerpts/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_content",
    "action" => "excerpts_delete"
  )
);
###############################################
