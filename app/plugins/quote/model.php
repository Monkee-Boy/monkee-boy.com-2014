<?php
class quote_model extends appModel {
  public $useCategories;
  public $sort;
  public $sortCategory;
  public $content;
  public $ty_content;

  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }

    $this->content = getContent(null, 'work-with-us');
    $this->ty_content = getContent(null, 'thank-you');
  }
}
