<?php
class admin_portfolio_services_sub extends adminController {
  public $service;

  function __construct(){
    parent::__construct("portfolio");

    $this->menuPermission("portfolio");

    $this->service = $this->model->getService($this->urlVars->dynamic['service']);
    $this->tplAssign('aService', $this->service);
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_services_sub"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}services_sub`"
        ." WHERE `serviceid` = ".$this->service['id']
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}services_sub`"
        ." WHERE `serviceid` = ".$this->service['id']
      ,"one"
    );

    $sSort = explode("-", $this->model->sortServiceSubs);

    $this->tplAssign("aServicesSubs", $this->model->getServicesSubs($this->service['id']));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/services_sub/index.php");
  }
  function add() {
    if(!empty($_SESSION["admin"]["admin_services_sub"]))
      $this->tplAssign("aServiceSub", $_SESSION["admin"]["admin_services_sub"]);
    else {
      $aServiceSub = array();

      $this->tplAssign("aServiceSub", $aServiceSub);
    }

    $this->tplDisplay("admin/services_sub/add.php");
  }
  function add_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services_sub"] = $_POST;
      $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}services_sub`"
        ." WHERE `serviceid` = ".$this->service['id']
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "services_sub",
      array(
        "serviceid" => $this->service['id'],
        "name" => $_POST["name"],
        "subtitle" => $_POST["subtitle"],
        "description" => $_POST["description"],
        "intro" => $_POST["intro"],
        "quote" => $_POST["quote"],
        "quote_attribution" => $_POST["quote_attribution"],
        "sort_order" => $sOrder,
        "created_datetime" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    $_SESSION["admin"]["admin_services_sub"] = null;

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/?info=".urlencode("Service created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_services_sub"])) {
      $aServiceSubRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub`"
          ." WHERE `id` = ".$this->urlVars->dynamic["id"]
        ,"row"
      );

      $aServiceSub = $_SESSION["admin"]["admin_services_sub"];

      $aServiceSub["updated_datetime"] = $aServiceSubRow["updated_datetime"];
      $aServiceSub["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aServiceSubRow["updated_by"]
        ,"row"
      );
    } else {
      $aServiceSub = $this->model->getServicesSub($this->urlVars->dynamic["id"]);

      $aServiceSub["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aServiceSub["updated_by"]
        ,"row"
      );
    }

    $this->tplAssign("aServiceSub", $aServiceSub);

    $this->tplDisplay("admin/services_sub/edit.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services_sub"] = $_POST;
      $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "services_sub",
      array(
        "name" => $_POST["name"],
        "subtitle" => $_POST["subtitle"],
        "description" => $_POST["description"],
        "intro" => $_POST["intro"],
        "quote" => $_POST["quote"],
        "quote_attribution" => $_POST["quote_attribution"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    $_SESSION["admin"]["admin_services_sub"] = null;

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $this->dbDelete("services_sub", $this->urlVars->dynamic["id"]);
    $this->dbDelete("portfolio_services_assign", $this->urlVars->dynamic["id"], 'servicesubid');

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aService = $this->model->getServicesSub($this->urlVars->dynamic["id"]);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub`"
          ." WHERE `sort_order` < ".$aService["sort_order"]
          ." AND `serviceid` = ".$this->service['id']
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub`"
          ." WHERE `sort_order` > ".$aService["sort_order"]
          ." AND `serviceid` = ".$this->service['id']
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "services_sub",
      array(
        "sort_order" => 0
      ),
      $aService["id"]
    );

    $this->dbUpdate(
      "services_sub",
      array(
        "sort_order" => $aService["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "services_sub",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aService["id"]
    );

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
