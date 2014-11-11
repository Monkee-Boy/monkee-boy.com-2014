<?php
if($sPluginStatus == 1) {
	// Install
} else {
	// Uninstall
}

$aTables = array(
	"news" => 'CREATE TABLE `{dbPrefix}news` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`title` varchar(255),
		`tag` varchar(255),
		`excerpt` longtext,
		`content` longtext,
		`tags` longtext,
		`publish_on` datetime NOT NULL,
		`active` tinyint(1),
		`views` int(11) unsigned,
		`created_datetime` datetime NOT NULL,
		`created_by` int(11) unsigned NOT NULL,
		`updated_datetime` datetime NOT NULL,
		`updated_by` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id`),
		INDEX `index` (`active`),
		UNIQUE (`tag`),
		FULLTEXT `fullindex` (`title`, `excerpt`, `content`, `tags`)
	) Engine=MyISAM;',
	"news_categories" => 'CREATE TABLE `{dbPrefix}news_categories` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`name` varchar(255),
		`parentid` int(11) unsigned,
		`sort_order` int(11) unsigned,
		PRIMARY KEY (`id`),
		UNIQUE (`sort_order`)
	) Engine=MyISAM;',
	"news_categories_assign" => 'CREATE TABLE `{dbPrefix}news_categories_assign` (
		`articleid` int(11) unsigned,
		`categoryid` int(11) unsigned,
		INDEX `index` (`articleid`, `categoryid`)
	) Engine=MyISAM;'
);

$aSettings = array();

$aMenuAdmin = array(
	"title" => "News",
	"menu" => array(
		array(
			"text" => "News",
			"link" => "/admin/news/"
		),
		array(
			"text" => "Categories",
			"link" => "/admin/news/categories/"
		)
	),
	"icon" => "icon-file"
);
