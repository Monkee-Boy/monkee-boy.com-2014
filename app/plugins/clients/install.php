<?php
$sFolder = $this->_settings->rootPublic."uploads/clients/";
if($sPluginStatus == 1) {
  // Install
  mkdir($sFolder);
} else {
  // Uninstall
  $this->deleteDir($sFolder);
}

$aTables = array(
  'clients' => 'CREATE TABLE `{dbPrefix}clients` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(255),
    `website` varchar(255),
    `logo` varchar(255),
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
  "title" => "Clients",
  "menu" => array(
    array(
      "text" => "Clients",
      "link" => "/admin/clients/"
    )
  )
);
