<?php
class content_model extends appModel {
  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }
  }

  /**
  * Get pages from the database.
  * @param  integer $sCategory Filter only posts assigned to this category.
  * @param  boolean $sAll      When true returns all posts no matter conditions.
  * @param  boolean $sPopular  When true sorts posts by `views` instead of publish date.
  * @return array              Return array of posts.
  */
  function getPages() {
    $aWhere = array();
    $sJoin = "";

    $sOrderBy = " ORDER BY `content`.`publish_on` DESC";

    $aArticles = $this->dbQuery(
    "SELECT `content`.* FROM `{dbPrefix}content` AS `content`"
    .$sJoin
    .$sWhere
    .$sOrderBy
    ,"all"
    );

    // Clean up each post information and get additional info if needed.
    foreach($aPages as &$aPage) {
      $this->_getPageInfo($aPage);
    }

    // Posts are ready for use.
    return $aPages;
  }

  /**
  * Get a single post from the database.
  * @param  integer $sId  Unique ID for the post or null.
  * @param  string  $sTag Unique tag for the post or null.
  * @param  boolean $sAll When true returns result no matter conditions.
  * @return array         Return the post.
  */
  function getArticle($sId, $sTag = "") {
    if(!empty($sId))
    $sWhere = " WHERE `content`.`id` = ".$this->dbQuote($sId, "integer");
    else
    $sWhere = " WHERE `content`.`tag` = ".$this->dbQuote($sTag, "text");

    $aPage = $this->dbQuery(
      "SELECT `content`.* FROM `{dbPrefix}content` AS `content`"
      .$sWhere
      ,"row"
    );

    $this->_getPageInfo($aPage);

    return $aPage;
  }

  /**
  * Clean up post info and get any other data to be returned.
  * @param  array &$aPost An array of a single post.
  */
  private function _getPageInfo(&$aPage) {
    if(!empty($aPage)) {
      $aPage["title"] = htmlspecialchars(stripslashes($aPage["title"]));
      $aPage["content"] = stripslashes($aArticle["content"]);
      $aPage["url"] = "";
    }
  }

  /**
  * Get a posts URL
  * @param  integer $sID A posts unique ID.
  * @return array|false  Return post URL or false.
  */
  function getURL($sID) {
    $aArticle = $this->getArticle($sID);

    if(!empty($aArticle)) {
      return $aArticle["url"];
    } else {
      return false;
    }
  }
}
