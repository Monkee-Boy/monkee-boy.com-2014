<?php
class troop_model extends appModel {
  public $imageFolder;
  public $accounts;

  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }
  }

  function getTroop($sRandom = false, $sAll = false) {
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

    $aTroop = $this->dbQuery(
      "SELECT `troop`.* FROM `{dbPrefix}troop` as `troop`"
        .$sJoin
        .$sWhere
        ." GROUP BY `troop`.`id`"
        .$sOrderBy
      ,"all"
    );

    foreach($aTroop as &$aEmployee) {
      $aEmployee = $this->_getEmployeeInfo($aEmployee);
    }

    return $aTroop;
  }
  function getEmployee($sId, $sAll = false) {
    if(!empty($sId))
      $sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
    else
      return false;

    if($sAll == false)
      $sWhere .= " AND `active` = 1";

    $aEmployee = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}troop`"
        .$sWhere
        ." LIMIT 1"
      ,"row"
    );

    $aEmployee = $this->_getEmployeeInfo($aEmployee);

    return $aEmployee;
  }
  private function _getEmployeeInfo($aEmployee) {
    if(!empty($aEmployee)) {
      $aEmployee["name"] = htmlspecialchars(stripslashes($aEmployee["name"]));
      $aEmployee["photo_url"] = $this->imageFolder.$aEmployee["photo"];
      $aEmployee["photo_over_url"] = $this->imageFolder.$aEmployee["photo_over"];

      $aEmployee["what"] = htmlspecialchars(stripslashes($aEmployee["what"]));
      $aEmployee["who"] = htmlspecialchars(stripslashes($aEmployee["who"]));
      $aEmployee["where"] = htmlspecialchars(stripslashes($aEmployee["where"]));
      $aEmployee["quirck"] = htmlspecialchars(stripslashes($aEmployee["quirck"]));

      if(!empty($aEmployee['social_accounts'])) {
        $aEmployee['social_accounts'] = json_decode($aEmployee['social_accounts'], true);
      }
    }

    return $aEmployee;
  }
}
