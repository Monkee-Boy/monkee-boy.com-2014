<?php
$aPluginInfo = array(
  /* Plugin Details */
  "name" => "Monkee Troop",
  "version" => "1.0",
  "author" => "Monkee-Boy Dev",
  "website" => "http://monkee-boy.com/",
  "email" => "webmaster@monkee-boy.com",
  "description" => "",

  /* Plugin Configuration */
  "config" => array(
    "accounts" => array(
      "twitter" => "Twitter",
      "linkedin" => "LinkedIn",
      "instagram" => "Instagram",
      "github" => "Github",
      "dribble" => "Dribble",
      "codepen" => "Codepen",
      "behance" => "Behance",
      "pinboard" => "Pinboard",
      "vsco_cam" => "Vsco Cam",
    ),
    "imageFolder" => "/uploads/troop/",
    "sort" => "manual-asc" // manual, name, subname, created, updated, random - asc, desc
  )
);
