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
  "/the-troop/" => array(
    "cmd" => "troop",
    "action" => "index"
  ),
  "/<parent:[a-z0-9_-/]+>/the-troop/" => array(
    "cmd" => "troop",
    "action" => "index"
  ),
  "/admin/troop/" => array(
    "cmd" => "admin_troop",
    "action" => "index"
  ),
  "/admin/troop/add/" => array(
    "cmd" => "admin_troop",
    "action" => "add"
  ),
  "/admin/troop/add/s/" => array(
    "cmd" => "admin_troop",
    "action" => "add_s"
  ),
  "/admin/troop/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_troop",
    "action" => "edit"
  ),
  "/admin/troop/edit/s/" => array(
    "cmd" => "admin_troop",
    "action" => "edit_s"
  ),
  "/admin/troop/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_troop",
    "action" => "delete"
  ),
  "/admin/troop/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_troop",
    "action" => "sort"
  ),
);
###############################################
