<?php
$aPluginInfo = array(
  /* Plugin Details */
  "name" => "Portfolio",
  "version" => "1.0",
  "author" => "Monkee-Boy",
  "website" => "http://monkee-boy.com/",
  "email" => "webmaster@monkee-boy.com",
  "description" => "",

  /* Plugin Configuration */
  "config" => array(
    "imageFolder" => "/uploads/portfolio/",
    "sortPortfolio" => "created-desc", // manual, name, subname, created, updated, random - asc, desc
    "sortPortfolioSlides" => "manual-asc",
    "sortServices" => "manual-asc",
    "sortServiceSubs" => "manual-asc",
    "sortServiceSubItems" => "manual-asc"
  )
);
