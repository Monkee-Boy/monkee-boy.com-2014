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
  "/work-with-us/" => array(
    "cmd" => "quote",
    "action" => "index"
  ),
  "/<parent:[a-z0-9_\-/]+>/work-with-us/" => array(
    "cmd" => "quote",
    "action" => "index"
  ),
  "/work-with-us/submit-form/" => array(
    "cmd" => "quote",
    "action" => "submit_form"
  ),
  "/<parent:[a-z0-9_\-/]+>/work-with-us/submit-form/" => array(
    "cmd" => "quote",
    "action" => "submit_form"
  ),
  "/work-with-us/thank-you/" => array(
    "cmd" => "quote",
    "action" => "submit_form"
  ),
  "/<parent:[a-z0-9_\-/]+>/work-with-us/thank-you/" => array(
    "cmd" => "quote",
    "action" => "thank_you"
  ),
  "/admin/work-with-us/" => array(
    "cmd" => "admin_quote",
    "action" => "index"
  ),
  "/admin/work-with-us/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_quote",
    "action" => "edit"
  ),
  "/admin/work-with-us/edit/s/" => array(
    "cmd" => "admin_quote",
    "action" => "edit_s"
  ),
  "/admin/work-with-us/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_quote",
    "action" => "delete"
  )
);
###############################################
