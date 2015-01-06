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
  "/the-work/" => array(
    "cmd" => "portfolio",
    "action" => "index"
  ),
  "/<parent:[a-z0-9_\-/]+>/the-work/" => array(
    "cmd" => "portfolio",
    "action" => "index"
  ),
  "/the-work/client-list/" => array(
    "cmd" => "clients",
    "action" => "index"
  ),
  "/the-work/testimonials/" => array(
    "cmd" => "testimonials",
    "action" => "index"
  ),
  "/the-work/<tag:[^/]+>/" => array(
    "cmd" => "portfolio",
    "action" => "single"
  ),
  "/<parent:[a-z0-9_\-/]+>/the-work/<tag:[^/]+>/" => array(
    "cmd" => "portfolio",
    "action" => "single"
  ),
  "/our-process/" => array(
    "cmd" => "portfolio",
    "action" => "services_index"
  ),
  "/<parent:[a-z0-9_\-/]+>/our-process/" => array(
    "cmd" => "portfolio",
    "action" => "services_index"
  ),
  "/our-process/<tag:[^/]+>/" => array(
    "cmd" => "portfolio",
    "action" => "services_single"
  ),
  "/<parent:[a-z0-9_\-/]+>/our-process/<tag:[^/]+>/" => array(
    "cmd" => "portfolio",
    "action" => "services_single"
  ),
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

  "/admin/portfolio/categories/" => array(
    "cmd" => "admin_portfolio",
    "action" => "categories_index"
  ),
  "/admin/portfolio/categories/add/s/" => array(
    "cmd" => "admin_portfolio",
    "action" => "categories_add_s"
  ),
  "/admin/portfolio/categories/edit/s/" => array(
    "cmd" => "admin_portfolio",
    "action" => "categories_edit_s"
  ),
  "/admin/portfolio/categories/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio",
    "action" => "categories_delete"
  ),
  "/admin/portfolio/categories/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio",
    "action" => "categories_sort"
  ),

  "/admin/portfolio/<client:[0-9]+>/slides/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "index"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/add/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "add"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/add/s/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "add_s"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "edit"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/edit/s/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "edit_s"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "delete"
  ),
  "/admin/portfolio/<client:[0-9]+>/slides/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio_views",
    "action" => "sort"
  ),

  "/admin/portfolio/services/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "index"
  ),
  "/admin/portfolio/services/add/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "add"
  ),
  "/admin/portfolio/services/add/s/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "add_s"
  ),
  "/admin/portfolio/services/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "edit"
  ),
  "/admin/portfolio/services/edit/s/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "edit_s"
  ),
  "/admin/portfolio/services/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "delete"
  ),
  "/admin/portfolio/services/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio_services",
    "action" => "sort"
  ),

  "/admin/portfolio/services/<service:[0-9]+>/sub/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "index"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/add/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "add"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/add/s/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "add_s"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "edit"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/edit/s/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "edit_s"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "delete"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio_services_sub",
    "action" => "sort"
  ),

  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "index"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/add/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "add"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/add/s/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "add_s"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "edit"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/edit/s/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "edit_s"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "delete"
  ),
  "/admin/portfolio/services/<service:[0-9]+>/sub/<servicesub:[0-9]+>/item/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_portfolio_services_sub_item",
    "action" => "sort"
  ),
);
###############################################
