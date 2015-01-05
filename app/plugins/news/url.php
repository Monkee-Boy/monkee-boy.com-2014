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
  "/latest-news/" => array(
    "cmd" => "news",
    "action" => "index"
  ),
  "/<parent:[a-z0-9_-/]+>/latest-news/" => array(
		"cmd" => "news",
		"action" => "index"
	),
  "/latest-news/rss/" => array(
    "cmd" => "news",
    "action" => "rss"
  ),
	"/<parent:[a-z0-9_-/]+>/latest-news/rss/" => array(
		"cmd" => "news",
		"action" => "rss"
	),
  "/latest-news/<year:[0-9]+>/<month:[0-9]+>/<date:[0-9]+>/<tag:[^/]+>/" => array(
    "cmd" => "news",
    "action" => "article"
  ),
	"/<parent:[a-z0-9_-/]+>/latest-news/<year:[0-9]+>/<month:[0-9]+>/<date:[0-9]+>/<tag:[^/]+>/" => array(
		"cmd" => "news",
		"action" => "article"
	),
  "/latest-news-ajax/" => array(
    "cmd" => "news",
    "action" => "ajax_load"
  ),
  "/<parent:[a-z0-9_-/]+>/latest-news-ajax/" => array(
    "cmd" => "news",
    "action" => "ajax_load"
  ),

	"/admin/news/" => array(
    "cmd" => "admin_news",
    "action" => "index"
  ),
  "/admin/news/add/" => array(
    "cmd" => "admin_news",
    "action" => "add"
  ),
  "/admin/news/add/s/" => array(
    "cmd" => "admin_news",
    "action" => "add_s"
  ),
  "/admin/news/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_news",
    "action" => "edit"
  ),
  "/admin/news/edit/s/" => array(
    "cmd" => "admin_news",
    "action" => "edit_s"
  ),
  "/admin/news/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_news",
    "action" => "delete"
  ),

  "/admin/news/categories/" => array(
    "cmd" => "admin_news",
    "action" => "categories_index"
  ),
  "/admin/news/categories/add/s/" => array(
    "cmd" => "admin_news",
    "action" => "categories_add_s"
  ),
  "/admin/news/categories/edit/s/" => array(
    "cmd" => "admin_news",
    "action" => "categories_edit_s"
  ),
  "/admin/news/categories/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_news",
    "action" => "categories_delete"
  ),
  "/admin/news/categories/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_news",
    "action" => "categories_sort"
  )
);
###############################################
