<?php
$sFolder = $this->settings->rootPublic."uploads/posts/";
if($sPluginStatus == 1) {
	// Install
	mkdir($sFolder);
} else {
	// Uninstall
	$this->deleteDir($sFolder);
}

$aTables = array(
	"posts" => 'CREATE TABLE `{dbPrefix}posts` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`title` varchar(255),
		`tag` varchar(255),
		`excerpt` longtext,
		`content` longtext,
		`tags` longtext,
		`publish_on` datetime NOT NULL,
		`allow_comments` tinyint(1),
		`allow_sharing` tinyint(1),
		`sticky` tinyint(1),
		`active` tinyint(1),
		`authorid` int(11) unsigned,
		`views` int(11) unsigned,
		`photo_x1` int(11) unsigned,
		`photo_y1` int(11) unsigned,
		`photo_x2` int(11) unsigned,
		`photo_y2` int(11) unsigned,
		`photo_width` int(11) unsigned,
		`photo_height` int(11) unsigned,
		`created_datetime` datetime NOT NULL,
		`created_by` int(11) unsigned NOT NULL,
		`updated_datetime` datetime NOT NULL,
		`updated_by` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id`),
		INDEX `index` (`sticky`, `active`),
		UNIQUE (`tag`),
		FULLTEXT `fullindex` (`title`, `excerpt`, `content`, `tags`)
	) Engine=MyISAM;',
	"posts_categories" => 'CREATE TABLE `{dbPrefix}posts_categories` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`name` varchar(255),
		`parentid` int(11) unsigned,
		`sort_order` int(11) unsigned,
		PRIMARY KEY (`id`),
		UNIQUE (`sort_order`)
	) Engine=MyISAM;',
	"posts_categories_assign" => 'CREATE TABLE `{dbPrefix}posts_categories_assign` (
		`postid` int(11) unsigned,
		`categoryid` int(11) unsigned,
		INDEX `index` (`postid`, `categoryid`)
	) Engine=MyISAM;'
);

$aSettings = array();

$aMenuAdmin = array(
	"title" => "Posts",
	"menu" => array(
		array(
			"text" => "Posts",
			"link" => "/admin/posts/"
		),
		array(
			"text" => "Categories",
			"link" => "/admin/posts/categories/"
		)
	),
	"icon" => "icon-file"
);
