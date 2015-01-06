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
  * @param  boolean $sAll      When true returns all posts no matter conditions.
  * @return array              Return array of posts.
  */
  function getPages($sAll = false) {
    $aWhere = array();
    $sJoin = '';

    // Filter only posts that are active unless told otherwise.
    if($sAll == false) {
      $aWhere[] = "`active` = 1";
    }

    // Combine the above filters for sql.
    if(!empty($aWhere)) {
      $sWhere = " WHERE ".implode(" AND ", $aWhere);
    }

    $aPages = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}content`"
      .$sJoin
      .$sWhere
      ." GROUP BY `id`"
      ." ORDER BY `title` ASC"
      , "all"
    );

    // Clean up each page information and get additional info if needed.
    foreach($aPages as &$aPage) {
      $this->_getPageInfo($aPage);
    }

    return $aPages;
  }

  function getPage($sId, $sTag = null) {
    if(!empty($sTag)) {
      $sWhere = " WHERE `tag` = ".$this->dbQuote($sTag, "text");
    } else {
      $sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
    }

    $aPage = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}content`"
      .$sWhere
      ,"row"
    );

    $this->_getPageInfo($aPage);

    return $aPage;
  }

  function getPageTag($sId) {
    $sTag = $this->dbQuery(
      "SELECT `tag` FROM `{dbPrefix}content`"
      ." WHERE `id` = ".$this->dbQuote($sId, "integer")
      ,"row"
    );

    return $sTag;
  }

  /**
  * Clean up page info and get any other data to be returned.
  * @param  array &$aPage An array of a single page.
  */
  private function _getPageInfo(&$aPage) {
    if(!empty($aPage)) {
      $aPage["title"] = htmlspecialchars(stripslashes($aPage["title"]));
      $aPage["content"] = stripslashes($aPage["content"]);
      $aPage["subtitle"] = stripslashes($aPage["subtitle"]);
      $aPage["tags"] = htmlspecialchars(stripslashes($aPage["tags"]));

      $aPage['url'] = $this->_buildUrl($aPage['tag'], $aPage['parentid']);
    }
  }

  private function _buildUrl($sTag, $sParentId = null, $sUrl = null) {
    if(!empty($sParentId)) {
      $aParentPage = $this->dbQuery(
        "SELECT `tag`, `parentid` FROM `{dbPrefix}content`"
        ." WHERE `id` = ".$this->dbQuote($sParentId, "integer")
        ,"row"
      );

      $sUrl = '/'.$sTag.$sUrl;

      return $this->_buildUrl($aParentPage['tag'], $aParentPage['parentid'], $sUrl);
    }
    else {
      $sUrl = '/'.$sTag.$sUrl.'/';

      return $sUrl;
    }
  }

  public function getTemplates() {
    $all_headers = array(
      "Name" =>  "Name",
      "Description" => "Description",
      "Version" => "Version",
      "Restricted" => "Restricted",
      "Author" => "Author"
    );

    $aData = array();
    $template_dir = $this->settings->root."plugins/content/views/templates/";
    $template_files = scandir($template_dir);
    foreach($template_files as $file) {
      if ($file === "." or $file === "..") continue;

      $fp = fopen($this->settings->root."plugins/content/views/templates/".$file, "r");
      $file_data = fread($fp, 8192);
      fclose($fp);

      foreach($all_headers as $field => $regex) {
        preg_match("/^[ \t\/*#@]*".preg_quote($regex, "/").":(.*)$/mi", $file_data, ${$field});

        if(!empty(${$field}))
        ${$field} = trim(preg_replace("/\s*(?:\*\/|\?>).*/", '', ${$field}[1]));
        else
        ${$field} = '';
      }

      $aTemplateInfo = compact(array_keys($all_headers));
      $aTemplateInfo["file"] = $file;

      if($aTemplateInfo["Restricted"] === "false" || $sRestricted) {
        $aData[] = $aTemplateInfo;
      }
    }

    return $aData;
  }
}
