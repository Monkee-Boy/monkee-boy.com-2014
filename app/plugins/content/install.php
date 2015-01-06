<?php
if($sPluginStatus == 1) {
  // Install
} else {
  // Uninstall
}

$aTables = array(

);

$aSettings = array(

);

$aMenuAdmin = array(
  "title" => "Content Pages",
  "menu" => array(
    array(
      "text" => "Content Pages",
      "link" => "/admin/content/"
    )
  ),
  "icon" => "icon-book"
);
