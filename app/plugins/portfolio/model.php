<?php
class portfolio_model extends appModel {
  public $imageFolder;
  public $sort;

  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }
  }

  function getClients($sRandom = false, $sAll = false) {
    $aWhere = array();
    $sJoin = "";

    // Filter those that are only active, unless told otherwise
    if($sAll == false) {
      $aWhere[] = "`active` = 1";
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
      "SELECT `portfolio`.* FROM `{dbPrefix}portfolio` as `portfolio`"
        .$sJoin
        .$sWhere
        ." GROUP BY `portfolio`.`id`"
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
      "SELECT * FROM `{dbPrefix}portfolio`"
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
    }

    return $aClient;
  }
}
