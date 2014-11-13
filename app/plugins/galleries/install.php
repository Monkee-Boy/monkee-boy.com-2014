<?php
$sFolder = $this->settings->rootPublic."uploads/galleries/";
if($sPluginStatus == 1) {
	// Install
	mkdir($sFolder);
} else {
	// Uninstall
	$this->deleteDir($sFolder);
}

$aTables = array(
	"galleries" => 'CREATE TABLE `{dbPrefix}galleries` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`name` varchar(255),
		`tag` varchar(100),
		`description` longtext,
		`sort_order` int(11),
		`active` tinyint(1),
		`created_datetime` datetime NOT NULL,
		`created_by` int(11) unsigned NOT NULL,
		`updated_datetime` datetime NOT NULL,
		`updated_by` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id`),
		INDEX `index` (`sort_order`,`active`),
		UNIQUE (`tag`)
	) Engine=MyISAM;',

	"galleries_categories" => 'CREATE TABLE `{dbPrefix}galleries_categories` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`name` varchar(255),
		`sort_order` int(11) unsigned,
		PRIMARY KEY (`id`),
		UNIQUE (`sort_order`)
	) Engine=MyISAM;',

	"galleries_categories_assign" => 'CREATE TABLE `{dbPrefix}galleries_categories_assign` (
		`galleryid` int(11) unsigned,
		`categoryid` int(11) unsigned,
		INDEX `index` (`galleryid`, `categoryid`)
	) Engine=MyISAM;',

	"galleries_photos" => 'CREATE TABLE `{dbPrefix}galleries_photos` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`galleryid` int(11),
		`photo` varchar(100),
		`title` varchar(255),
		`description` longtext,
		`gallery_default` tinyint(1),
		`sort_order` int(11),
		PRIMARY KEY (`id`),
		INDEX `index` (`galleryid`, `gallery_default`, `sort_order`)
	) Engine=MyISAM;'
);

$aSettings = array();

$aMenuAdmin = array(
	"title" => "Photo Galleries",
	"menu" => array(
		array(
			"text" => "Galleries",
			"link" => "/admin/galleries/"
		),
		array(
			"text" => "Categories",
			"link" => "/admin/galleries/categories/"
		)
	)
);
