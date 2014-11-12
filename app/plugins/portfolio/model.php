<?php
class portfolio_model extends appModel {
  public $imageFolder;
  public $sortPortfolio;
  public $sortPortfolioSlides;
  public $sortServices;
  public $sortServiceSubs;
  public $sortServiceSubItems;

  function __construct() {
    parent::__construct();

    include(dirname(__file__)."/config.php");

    foreach($aPluginInfo["config"] as $sKey => $sValue) {
      $this->$sKey = $sValue;
    }
  }

  function getClients($sRandom = false, $sAll = false, $sRecursive = false) {
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
    $sSort = explode("-", $this->sortPortfolio);
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
      $aClient = $this->_getClientInfo($aClient, $sRecursive);
    }

    return $aClients;
  }
  function getClient($sId, $sAll = false, $sRecursive = false, $sTag = null) {
    if(!empty($sTag)) {
      $sWhere = " WHERE `tag` = ".$this->dbQuote($sTag, "text");
    } else {
      $sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
    }

    if($sAll == false)
      $sWhere .= " AND `active` = 1";

    $aClient = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}portfolio`"
        .$sWhere
        ." LIMIT 1"
      ,"row"
    );

    $aClient = $this->_getClientInfo($aClient, $sRecursive);

    return $aClient;
  }
  private function _getClientInfo($aClient, $sRecursive = false) {
    if(!empty($aClient)) {
      $aClient["name"] = htmlspecialchars(stripslashes($aClient["name"]));
      $aClient["logo_url"] = $this->imageFolder.$aClient["logo"];
      $aClient["listing_image_url"] = $this->imageFolder.$aClient["listing_image"];

      if(!empty($aClient["quotes"])) {
        $aClient["quotes"] = json_decode($aClient["quotes"], true);
      } else {
        $aClient["quotes"] = array();
      }

      if($sRecursive === true) {
        $aClient["services"] = array();
        $aClientServices = $this->dbQuery(
          "SELECT * FROM `{dbPrefix}portfolio_services_assign`"
            ." WHERE `clientid` = ".$aClient['id']
          ,'all'
        );

        foreach($aClientServices as $aService) {
          $aClient["services"][] = $this->getServicesSub($aService['serviceid'], false);
        }

        $aClient["slides"] = $this->getClientSlides($aClient['id']);
      }
    }

    return $aClient;
  }

  /* ########################
      Portfolio Slides
     ######################## */
  public function getClientSlides($sPortfolio = null) {
    $aWhere = array();

    if(!empty($sPortfolio)) {
      $aWhere[] = "`portfolioid` = ".$sPortfolio;
    }

    // Combine filters if atleast one was added
    if(!empty($aWhere)) {
      $sWhere = " WHERE ".implode(" AND ", $aWhere);
    }

    // Check if sort direction is set, and clean it up for SQL use
    $sSort = explode("-", $this->sortPortfolioSlides);
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

    $aSlides = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}portfolio_views`"
        .$sWhere
        .$sOrderBy
      ,"all"
    );

    foreach($aSlides as &$aSlide) {
      $aSlide = $this->_getClientSlideInfo($aSlide);
    }

    return $aSlides;
  }
  public function getClientSlide($sId) {
    $aSlide = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}portfolio_views`"
        ." WHERE `id` = ".$sId
      ,"row"
    );

    $aSlide = $this->_getClientSlideInfo($aSlide);

    return $aSlide;
  }
  private function _getClientSlideInfo($aSlide) {
    if(!empty($aSlide)) {
      $images = array("listing_image", "desktop_image", "tablet_image", "phone_image");
      foreach($images as $image) {
        if($aSlide[$image]) {
          $aSlide[$image."_url"] = $this->imageFolder.$aSlide[$image];
        }
      }
    }

    return $aSlide;
  }

  /* ########################
      Services
     ######################## */
  public function getServices($sRecursive = false) {
    // Check if sort direction is set, and clean it up for SQL use
    $sSort = explode("-", $this->sortServices);
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

    $aServices = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}services`"
        .$sOrderBy
      ,"all"
    );

    foreach($aServices as &$aService) {
      $aService = $this->_getServiceInfo($aService);

      if($sRecursive == true) {
        $aService['subs'] = $this->getServicesSubs($aService['id'], true);
      }
    }

    return $aServices;
  }
  public function getService($sId, $sTag = null, $sRecursive = false) {
    if(!empty($sTag)) {
      $aService = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services`"
          ." WHERE `tag` = ".$this->dbQuote($sTag, 'text')
        ,"row"
      );
    } else {
      $aService = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services`"
          ." WHERE `id` = ".$this->dbQuote($sId, 'integer')
        ,"row"
      );
    }

    $aService = $this->_getServiceInfo($aService);

    if($sRecursive == true) {
      $aService['subs'] = $this->getServicesSubs($aService['id'], true);
    }

    return $aService;
  }
  private function _getServiceInfo($aService) {
    if(!empty($aService)) {
      $aService["name"] = htmlspecialchars(stripslashes($aService["name"]));
      $aService["subtitle"] = htmlspecialchars(stripslashes($aService["subtitle"]));
      $aService["description"] = stripslashes($aService["description"]);
    }

    return $aService;
  }

  /* ########################
      Services Subs
     ######################## */
  public function getServicesSubs($sService = null, $sRecursive = false) {
    $sWhere = '';

    if(!empty($sService)) {
      $sWhere = ' WHERE `serviceid` = '.$sService;
    }

    // Check if sort direction is set, and clean it up for SQL use
    $sSort = explode("-", $this->sortServiceSubs);
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

    $aServicesSubs = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}services_sub`"
        .$sWhere
        .$sOrderBy
      ,"all"
    );

    foreach($aServicesSubs as &$aServicesSub) {
      $aServicesSub = $this->_getServicesSubInfo($aServicesSub);

      if($sRecursive == true) {
        $aServicesSub['items'] = $this->getServicesSubsItems($aServicesSub['id'], true);

        $length = count($aServicesSub['items']);
        $aServicesSub['first_half_items'] = array_slice($aServicesSub['items'], 0, round($length / 2));
        $aServicesSub['second_half_items'] = array_slice($aServicesSub['items'], round($length / 2));
      }
    }

    return $aServicesSubs;
  }
  public function getServicesSub($sId) {
    $aServiceSub = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}services_sub`"
        ." WHERE `id` = ".$sId
      ,"row"
    );

    $aServiceSub = $this->_getServicesSubInfo($aServiceSub);

    return $aServiceSub;
  }
  private function _getServicesSubInfo($aServiceSub) {
    if(!empty($aServiceSub)) {
      $aServiceSub["name"] = htmlspecialchars(stripslashes($aServiceSub["name"]));
      $aServiceSub["subtitle"] = htmlspecialchars(stripslashes($aServiceSub["subtitle"]));
      $aServiceSub["description"] = stripslashes($aServiceSub["description"]);
      $aServiceSub["quote"] = htmlspecialchars(nl2br(stripslashes($aServiceSub["quote"])));
      $aServiceSub["quote_attribution"] = htmlspecialchars(stripslashes($aServiceSub["quote_attribution"]));
    }

    return $aServiceSub;
  }

  /* ########################
      Services Subs Items
     ######################## */
  public function getServicesSubsItems($sServiceSub = null) {
    $sWhere = '';

    if(!empty($sServiceSub)) {
      $sWhere = ' WHERE `servicesubid` = '.$sServiceSub;
    }

    // Check if sort direction is set, and clean it up for SQL use
    $sSort = explode("-", $this->sortServiceSubItems);
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

    $aServicesSubItems = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}services_sub_items`"
        .$sWhere
        .$sOrderBy
      ,"all"
    );

    foreach($aServicesSubItems as &$aServicesSubItem) {
      $aServicesSubItem = $this->_getServicesSubsItemInfo($aServicesSubItem);
    }

    return $aServicesSubItems;
  }
  public function getServicesSubsItem($sId) {
    $aServiceSubItem = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}services_sub_items`"
        ." WHERE `id` = ".$sId
      ,"row"
    );

    $aServiceSubItem = $this->_getServicesSubsItemInfo($aServiceSubItem);

    return $aServiceSubItem;
  }
  private function _getServicesSubsItemInfo($aServiceSubItem) {
    if(!empty($aServiceSubItem)) {
      $aServiceSubItem["name"] = htmlspecialchars(stripslashes($aServiceSubItem["name"]));
      $aServiceSubItem["description"] = stripslashes($aServiceSubItem["description"]);
    }

    return $aServiceSubItem;
  }
}
