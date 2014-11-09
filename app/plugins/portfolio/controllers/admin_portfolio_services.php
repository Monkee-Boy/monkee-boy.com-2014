<?php
class admin_portfolio_services extends adminController {
  function __construct(){
    parent::__construct("portfolio");

    $this->menuPermission("portfolio");
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_services"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}services`"
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}services`"
      ,"one"
    );

    $sSort = explode("-", $this->model->sort);

    $this->tplAssign("aServices", $this->model->getServices(false, true));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/services/index.php");
  }
  function add() {
    if(!empty($_SESSION["admin"]["admin_services"]))
      $this->tplAssign("aService", $_SESSION["admin"]["admin_services"]);
    else {
      $aService = array(
        
      );

      $this->tplAssign("aService", $aService);
    }

    $this->tplDisplay("admin/services/add.php");
  }
  function add_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services"] = $_POST;
      $this->forward("/admin/portfolio/services/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}services`"
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "services",
      array(
        "name" => $_POST["name"],
        "subtitle" => $_POST["subtitle"],
        "description" => $_POST["description"],
        "sort_order" => $sOrder,
        "created_datetime" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    $_SESSION["admin"]["admin_services"] = null;

    $this->forward("/admin/portfolio/services/?info=".urlencode("Service created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_services"])) {
      $aServiceRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services`"
          ." WHERE `id` = ".$this->urlVars->dynamic["id"]
        ,"row"
      );

      $aService = $_SESSION["admin"]["admin_services"];

      $aService["updated_datetime"] = $aServiceRow["updated_datetime"];
      $aService["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aServiceRow["updated_by"]
        ,"row"
      );
    } else {
      $aService = $this->model->getService($this->urlVars->dynamic["id"]);

      $aService["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aService["updated_by"]
        ,"row"
      );
    }

    $this->tplAssign("aService", $aService);

    $this->tplDisplay("admin/services/edit.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services"] = $_POST;
      $this->forward("/admin/portfolio/services/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "services",
      array(
        "name" => $_POST["name"],
        "subtitle" => $_POST["subtitle"],
        "description" => $_POST["description"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    $_SESSION["admin"]["admin_services"] = null;

    $this->forward("/admin/portfolio/services/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $this->dbDelete("services", $this->urlVars->dynamic["id"]);

    $this->forward("/admin/portfolio/services/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aService = $this->model->getService($this->urlVars->dynamic["id"], true);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services`"
          ." WHERE `sort_order` < ".$aService["sort_order"]
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services`"
          ." WHERE `sort_order` > ".$aService["sort_order"]
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "services",
      array(
        "sort_order" => 0
      ),
      $aService["id"]
    );

    $this->dbUpdate(
      "services",
      array(
        "sort_order" => $aService["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "services",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aService["id"]
    );

    $this->forward("/admin/portfolio/services/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
