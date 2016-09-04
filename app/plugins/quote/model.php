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

    $this->content = getContent(null, 'request-a-quote');
    $this->ty_content = getContent(null, 'thank-you');
  }

  function getQuotes() {
    $aQuotes = $this->dbQuery(
      "SELECT `work_with_us`.* FROM `{dbPrefix}work_with_us` as `work_with_us`"
      ." GROUP BY `work_with_us`.`id`"
      ." ORDER BY `created_datetime` DESC"
      ,"all"
    );

    foreach($aQuotes as &$aQuote) {
      $this->_getQuoteInfo($aQuote);
    }

    return $aQuotes;
  }
  function getQuote($sId) {
    $aQuote = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}work_with_us`"
      ." WHERE `id` = ".$this->dbQuote($sId, "integer")
      ." LIMIT 1"
      ,"row"
    );

    $this->_getQuoteInfo($aQuote);

    return $aQuote;
  }
  private function _getQuoteInfo(&$aQuote) {
    if(!empty($aQuote)) {
      if(!empty($aQuote['first_name']) && !empty($aQuote['last_name'])) {
        $aQuote['name'] = htmlspecialchars(stripslashes($aQuote['first_name'])) . ' ' . htmlspecialchars(stripslashes($aQuote['last_name']));
      } elseif(!empty($aQuote['name'])) {
        $aQuote['name'] = htmlspecialchars(stripslashes($aQuote['name']));
      } else {
        $aQuote['name'] = 'No name provided.';
      }
      $aQuote['email'] = htmlspecialchars(stripslashes($aQuote['email']));
      $aQuote['phone'] = htmlspecialchars(stripslashes($aQuote['phone']));
      $aQuote['organization'] = htmlspecialchars(stripslashes($aQuote['organization']));
      $aQuote['website'] = htmlspecialchars(stripslashes($aQuote['website']));
      $aQuote['breif'] = nl2br(htmlspecialchars(stripslashes($aQuote['breif'])));
      $aQuote['attachments'] = json_decode($aQuote['attachments'], false);
      $aQuote['budget'] = htmlspecialchars(stripslashes($aQuote['budget']));

      if(!empty($aQuote['deadline'])) {
        $aQuote['deadline'] = $aQuote['deadline'];
      }

      $aQuote['created_datetime'] = strtotime($aQuote['created_datetime']);
      $aQuote['updated_datetime'] = strtotime($aQuote['updated_datetime']);
    }
  }
}
