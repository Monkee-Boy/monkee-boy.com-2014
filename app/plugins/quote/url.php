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
  "/work-with-us/upload/" => array(
    "cmd" => "quote",
    "action" => "upload"
  ),
  "/work-with-us/thank-you/" => array(
    "cmd" => "quote",
    "action" => "submit_form"
  ),
  "/<parent:[a-z0-9_\-/]+>/work-with-us/thank-you/" => array(
    "cmd" => "quote",
    "action" => "thank_you"
  ),
  "/admin/quote/" => array(
    "cmd" => "admin_quote",
    "action" => "index"
  ),
  "/admin/quote/view/<id:[0-9]+>/" => array(
    "cmd" => "admin_quote",
    "action" => "view"
  ),
  "/admin/quote/edit/s/" => array(
    "cmd" => "admin_quote",
    "action" => "edit_s"
  ),
  "/admin/quote/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_quote",
    "action" => "delete"
  )
);
###############################################
