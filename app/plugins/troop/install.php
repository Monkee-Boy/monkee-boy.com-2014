<?php
$sFolder = $this->_settings->rootPublic."uploads/troop/";
if($sPluginStatus == 1) {
  // Install
  mkdir($sFolder);
} else {
  // Uninstall
  $this->deleteDir($sFolder);
}

$aTables = array(
  'troop' => 'CREATE TABLE `{dbPrefix}troop` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255),
    `who` longtext,
    `what` longtext,
    `history` longtext,
    `quirk` longtext,
    `quote` longtext,
    `title` varchar(255),
    `social_accounts` longtext NULL,
    `photo` varchar(255),
    `photo_over` varchar(255),
    `sort_order` int,
    `active` tinyint(1),
    `created_datetime` datetime NOT NULL,
    `created_by` int(11) unsigned NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`sort_order`, `active`)
  ) Engine=MyISAM;'
);

$aSettings = array(

);

$aMenuAdmin = array(
  "title" => "Troop",
  "menu" => array(
    array(
      "text" => "Troop",
      "link" => "/admin/troop/"
    )
  )
);
