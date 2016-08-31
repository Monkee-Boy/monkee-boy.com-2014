<?php
$sFolder = $this->_settings->rootPublic."uploads/quote/";
if($sPluginStatus == 1) {
  // Install
  mkdir($sFolder);
} else {
  // Uninstall
  $this->deleteDir($sFolder);
}

$aTables = array(
  'work_with_us' => 'CREATE TABLE `{dbPrefix}work_with_us` (
    `id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(100),
    `email` varchar(100),
    `phone` varchar(20),
    `organization` varchar(255),
    `website` varchar(255),
    `brief` longtext,
    `attachments` longtext,
    `deadline` date,
    `budget` varchar(100),
    `status` tinyint(1),
    `ip` varchar(100),
    `created_datetime` datetime NOT NULL,
    `updated_datetime` datetime NOT NULL,
    `updated_by` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `index` (`status`)
  ) Engine=MyISAM;',
);

$aSettings = array();

$aMenuAdmin = array(
  "title" => "Work With Us",
  "menu" => array(
    array(
      "text" => "Work With Us",
      "link" => "/admin/quote/"
    )
  )
);
