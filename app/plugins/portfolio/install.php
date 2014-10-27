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
    `website` varchar(255),
    `subtitle` varchar(255),
    `short_description` longtext,
    `logo` varchar(255),
    `synopsis` longtext,
    `case_study` varchar(255),
    `listing_image` varchar(255),
    `quote` longtext,
    `other_services` longtext,
    `sort_order` int,
    `active` tinyint(1),
    `featured` tinyint(1),
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`sort_order`, `active`)
  ) Engine=MyISAM;',

  "portfolio_services" => 'CREATE TABLE `{dbPrefix}portfolio_services` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255),
    `sort_order` int(11) unsigned,
    PRIMARY KEY (`id`),
    UNIQUE (`sort_order`)
  ) Engine=MyISAM;',

  "portfolio_services_assign" => 'CREATE TABLE `{dbPrefix}portfolio_services_assign` (
    `clientid` int(11) unsigned,
    `serviceid` int(11) unsigned,
    INDEX `index` (`clientid`, `serviceid`)
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
    )
  )
);
