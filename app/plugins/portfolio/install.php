<?php
$sFolder = $this->_settings->rootPublic."uploads/portfolio/";
if($sPluginStatus == 1) {
  // Install
  mkdir($sFolder);
} else {
  // Uninstall
  $this->deleteDir($sFolder);
}

$aTables = array(
  'portfolio' => 'CREATE TABLE `{dbPrefix}portfolio` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255),
    `tag` varchar(255),
    `website` varchar(255),
    `subtitle` varchar(255),
    `short_description` longtext,
    `logo` varchar(255),
    `synopsis` longtext,
    `case_study` varchar(255),
    `listing_image` varchar(255),
    `other_services_1` longtext,
    `other_services_2` longtext,
    `quotes` longtext,
    `sort_order` int,
    `active` tinyint(1),
    `featured` tinyint(1),
    `app` tinyint(1),
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`sort_order`, `active`)
  ) Engine=MyISAM;',

  "portfolio_views" => 'CREATE TABLE `{dbPrefix}portfolio_views` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `portfolioid` int(11) unsigned,
    `listing_image` varchar(255),
    `desktop_image` varchar(255),
    `tablet_image` varchar(255),
    `mobile_image` varchar(255),
    `sort_order` int(11) unsigned,
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`portfolioid`),
    UNIQUE (`sort_order`)
  ) Engine=MyISAM;',

  "portfolio_quotes" => 'CREATE TABLE `{dbPrefix}portfolio_quotes` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `portfolioid` int(11) unsigned,
    `quote` longtext,
    `name` varchar(255),
    `subname` varchar(255),
    `sort_order` int(11) unsigned,
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`portfolioid`),
    UNIQUE (`sort_order`)
  ) Engine=MyISAM;',

  "services" => 'CREATE TABLE `{dbPrefix}services` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255),
    `tag` varchar(255),
    `subtitle` varchar(255),
    `description` longtext,
    `sort_order` int(11) unsigned,
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE (`sort_order`, `tag`)
  ) Engine=MyISAM;
  INSERT INTO `{dbPrefix}services` (`name`, `subtitle`, `description`, `sort_order`, `created_datetime`, `created_by`, `updated_datetime`, `updated_by`) VALUES
  (\'Discover\', \'Reaserch + Strategy\', \'\', 1, NOW(), 1, NOW(), 1),
  (\'Create\', \'Design + Development + Marketing\', \'\', 2, NOW(), 1, NOW(), 1),
  (\'Evolve\', \'Maintenance + Growth\', \'\', 3, NOW(), 1, NOW(), 1);',

  "services_sub" => 'CREATE TABLE `{dbPrefix}services_sub` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `serviceid` int(11) unsigned,
    `name` varchar(255),
    `tag` varchar(255),
    `subtitle` longtext,
    `description` longtext,
    `quote` longtext,
    `quote_attribution` varchar(255),
    `services_byline` varchar(255),
    `sort_order` int(11) unsigned,
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`serviceid`, `sort_order`)
  ) Engine=MyISAM;',

  "services_sub_items" => 'CREATE TABLE `{dbPrefix}services_sub_items` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `servicesubid` int(11) unsigned,
    `name` varchar(255),
    `description` longtext,
    `sort_order` int(11) unsigned,
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`servicesubid`, `sort_order`)
  ) Engine=MyISAM;',

  "portfolio_services_sub_assign" => 'CREATE TABLE `{dbPrefix}portfolio_services_assign` (
    `portfolioid` int(11) unsigned,
    `servicesubid` int(11) unsigned,
    INDEX `index` (`portfolio`, `servicesubid`)
  ) Engine=MyISAM;'
);

$aSettings = array(

);

$aMenuAdmin = array(
  "title" => "Portfolio",
  "menu" => array(
    array(
      "text" => "Portfolio",
      "link" => "/admin/portfolio/"
    ),
    array(
      "text" => "Service",
      "link" => "/admin/portfolio/services/"
    )
  )
);
