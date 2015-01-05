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
  "/client-list/" => array(
    "cmd" => "clients",
    "action" => "index"
  ),
  "/<parent:[a-z0-9_\-/]+>/client-list/" => array(
    "cmd" => "clients",
    "action" => "index"
  ),
  "/admin/clients/" => array(
    "cmd" => "admin_clients",
    "action" => "index"
  ),
  "/admin/clients/add/" => array(
    "cmd" => "admin_clients",
    "action" => "add"
  ),
  "/admin/clients/add/s/" => array(
    "cmd" => "admin_clients",
    "action" => "add_s"
  ),
  "/admin/clients/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_clients",
    "action" => "edit"
  ),
  "/admin/clients/edit/s/" => array(
    "cmd" => "admin_clients",
    "action" => "edit_s"
  ),
  "/admin/clients/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_clients",
    "action" => "delete"
  ),
  "/admin/clients/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_clients",
    "action" => "sort"
  ),
);
###############################################
