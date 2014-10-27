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
  "/admin/portfolio/" => array(
    "cmd" => "admin_portfolio",
    "action" => "index"
  ),
  "/admin/portfolio/add/" => array(
    "cmd" => "admin_portfolio",
    "action" => "add"
  ),
  "/admin/portfolio/add/s/" => array(
    "cmd" => "admin_portfolio",
    "action" => "add_s"
  ),
  "/admin/portfolio/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio",
    "action" => "edit"
  ),
  "/admin/portfolio/edit/s/" => array(
    "cmd" => "admin_portfolio",
    "action" => "edit_s"
  ),
  "/admin/portfolio/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio",
    "action" => "delete"
  ),
  "/admin/portfolio/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio",
    "action" => "sort"
  ),
);
###############################################
