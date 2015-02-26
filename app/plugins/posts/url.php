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
  "/blog/" => array(
    "cmd" => "posts",
    "action" => "index"
  ),
  "/blog/preview/<id:[0-9]+>/" => array(
    "cmd" => "posts",
    "action" => "preview"
  ),
  "/blog/latest-post/" => array(
    "cmd" => "posts",
    "action" => "latest_post"
  ),
  "/blog/freebie-friday/" => array(
    "cmd" => "posts",
    "action" => "freebie_friday"
  ),
  "/<parent:[a-z0-9_\-/]+>/blog/" => array(
		"cmd" => "posts",
		"action" => "index"
	),
  "/blog/rss/" => array(
    "cmd" => "posts",
    "action" => "rss"
  ),
	"/<parent:[a-z0-9_\-/]+>/blog/rss/" => array(
		"cmd" => "posts",
		"action" => "rss"
	),
  "/blog/<year:[0-9]+>/<month:[0-9]+>/<tag:[^/]+>/" => array(
    "cmd" => "posts",
    "action" => "post"
  ),
	"/<parent:[a-z0-9_\-/]+>/blog/<year:[0-9]+>/<month:[0-9]+>/<tag:[^/]+>/" => array(
		"cmd" => "posts",
		"action" => "post"
	),
  "/ajax/blog/load_more/" => array(
    "cmd" => "posts",
    "action" => "load_more"
  ),

	"/admin/posts/" => array(
    "cmd" => "admin_posts",
    "action" => "index"
  ),
	"/admin/posts/add/" => array(
    "cmd" => "admin_posts",
    "action" => "add"
  ),
	"/admin/posts/add/s/" => array(
    "cmd" => "admin_posts",
    "action" => "add_s"
  ),
	"/admin/posts/edit/<id:[0-9]+>/" => array(
    "cmd" => "admin_posts",
    "action" => "edit"
  ),
	"/admin/posts/edit/s/" => array(
    "cmd" => "admin_posts",
    "action" => "edit_s"
  ),
	"/admin/posts/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_posts",
    "action" => "delete"
  ),

	"/admin/posts/categories/" => array(
    "cmd" => "admin_posts",
    "action" => "categories_index"
  ),
	"/admin/posts/categories/add/s/" => array(
    "cmd" => "admin_posts",
    "action" => "categories_add_s"
  ),
	"/admin/posts/categories/edit/s/" => array(
    "cmd" => "admin_posts",
    "action" => "categories_edit_s"
  ),
	"/admin/posts/categories/delete/<id:[0-9]+>/" => array(
    "cmd" => "admin_posts",
    "action" => "categories_delete"
  ),
	"/admin/posts/categories/sort/<id:[0-9]+>/<sort:[a-z]+>/" => array(
    "cmd" => "admin_posts",
    "action" => "categories_sort"
  )
);
###############################################
