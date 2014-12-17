<?php
if($sPluginStatus == 1) {
	// Install
} else {
	// Uninstall
}

$aTables = array(
	'testimonials' => 'CREATE TABLE `{dbPrefix}testimonials` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`client` varchar(100),
		`name` varchar(100),
		`title` varchar(100),
		`text` longtext,
		`tag` varchar(100),
		`sort_order` int,
		`active` tinyint(1),
		`created_datetime` datetime NOT NULL,
		`created_by` int(11) unsigned NOT NULL,
		`updated_datetime` datetime NOT NULL,
		`updated_by` int(11) unsigned NOT NULL,
		PRIMARY KEY (`id`),
		INDEX `index` (`sort_order`, `active`)
	) Engine=MyISAM;',
	"testimonials_categories" => 'CREATE TABLE `{dbPrefix}testimonials_categories` (
		`id` int(11) unsigned NOT NULL auto_increment,
		`name` varchar(255),
		`parentid` int(11) unsigned,
		`sort_order` int(11) unsigned,
		PRIMARY KEY (`id`),
		UNIQUE (`sort_order`)
	) Engine=MyISAM;',
	"testimonials_categories_assign" => 'CREATE TABLE `{dbPrefix}testimonials_categories_assign` (
		`testimonialid` int(11) unsigned,
		`categoryid` int(11) unsigned,
		INDEX `index` (`testimonialid`, `categoryid`)
	) Engine=MyISAM;'
);

$aSettings = array(
	// array(
	// 	"group" => "Testimonials",
	// 	"tag" => "testimonial_tag1",
	// 	"title" => "Tag 1",
	// 	"text" => "Test 1",
	// 	"value" => "Value 1",
	// 	"type" => "text",
	// 	"order" => 1
	// )
);

$aMenuAdmin = array(
	"title" => "Testimonials",
	"menu" => array(
		array(
			"text" => "Testimonials",
			"link" => "/admin/testimonials/"
		),
		array(
			"text" => "Categories",
			"link" => "/admin/testimonials/categories/"
		)
	)
);
