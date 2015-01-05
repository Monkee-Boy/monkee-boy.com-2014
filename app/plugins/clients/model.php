<?php
class clients_model extends appModel {
  public $imageFolder;
  public $sort;
  public $content;

  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }

    $this->content = getContent(null, 'client-list');
  }

  function getClients($sRandom = false, $sAll = false, $sSVG = false) {
    $aWhere = array();
    $sJoin = "";

    // Filter those that are only active, unless told otherwise
    if($sAll == false) {
      $aWhere[] = "`active` = 1";
    }

    // Filter to only those that have SVG logo
    if($sSVG == true) {
      $aWhere[] = "`logo_svg` <> ''";
    }

    // Combine filters if atleast one was added
    if(!empty($aWhere)) {
      $sWhere = " WHERE ".implode(" AND ", $aWhere);
    }

    // Check if sort direction is set, and clean it up for SQL use
    $sSort = explode("-", $this->sort);
    $sSortDirection = array_pop($sSort);
    if(empty($sSortDirection) || !in_array(strtolower($sSortDirection), array("asc", "desc"))) {
      $sSortDirection = "ASC";
    } else {
      $sSortDirection = strtoupper($sSortDirection);
    }

    // Choose sort method based on model setting
    switch(array_shift($sSort)) {
      case "manual":
        $sOrderBy = " ORDER BY `sort_order` ".$sSortDirection;
        break;
      case "created":
        $sOrderBy = " ORDER BY `created_datetime` ".$sSortDirection;
        break;
      case "updated":
        $sOrderBy = " ORDER BY `updated_datetime` ".$sSortDirection;
        break;
      case "random":
        $sOrderBy = " ORDER BY RAND()";
        break;
      case "subname":
        $sOrderBy = " ORDER BY `sub_name` ".$sSortDirection;
        break;
      // Default to sort by name
      default:
        $sOrderBy = " ORDER BY `name` ".$sSortDirection;
    }

    if($sRandom == true)
      $sOrderBy = " ORDER BY RAND() ";

    $aClients = $this->dbQuery(
      "SELECT `clients`.* FROM `{dbPrefix}clients` as `clients`"
        .$sJoin
        .$sWhere
        ." GROUP BY `clients`.`id`"
        .$sOrderBy
      ,"all"
    );

    foreach($aClients as &$aClient) {
      $aClient = $this->_getClientInfo($aClient);
    }

    return $aClients;
  }
  function getClient($sId, $sAll = false) {
    if(!empty($sId))
      $sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
    else
      return false;

    if($sAll == false)
      $sWhere .= " AND `active` = 1";

    $aClient = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}clients`"
        .$sWhere
        ." LIMIT 1"
      ,"row"
    );

    $aClient = $this->_getClientInfo($aClient);

    return $aClient;
  }
  private function _getClientInfo($aClient) {
    if(!empty($aClient)) {
      $aClient["name"] = htmlspecialchars(stripslashes($aClient["name"]));
      $aClient["logo_url"] = $this->imageFolder.$aClient["logo"];
      $aClient["logo_svg_url"] = $this->imageFolder.$aClient["logo_svg"];
    }

    return $aClient;
  }
}
