<?php
class admin_portfolio_services_sub_item extends adminController {
  public $service;
  public $servicesub;

  function __construct(){
    parent::__construct("portfolio");

    $this->menuPermission("portfolio");

    $this->service = $this->model->getService($this->urlVars->dynamic['service']);
    $this->tplAssign('aService', $this->service);

    $this->servicesub = $this->model->getServicesSub($this->urlVars->dynamic['servicesub']);
    $this->tplAssign('aServiceSub', $this->servicesub);
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_services_sub_item"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}services_sub_items`"
      ." WHERE `servicesubid` = ".$this->servicesub['id']
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}services_sub_items`"
      ." WHERE `servicesubid` = ".$this->servicesub['id']
      ,"one"
    );

    $sSort = explode("-", $this->model->sortServiceSubItems);

    $this->tplAssign("aServicesSubItems", $this->model->getServicesSubsItems($this->servicesub['id']));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/services_sub_item/index.php");
  }
  function add() {
    if(!empty($_SESSION["admin"]["admin_services_sub_item"]))
      $this->tplAssign("aServiceSubItem", $_SESSION["admin"]["admin_services_sub_item"]);
    else {
      $aServiceSubItem = array();

      $this->tplAssign("aServiceSubItem", $aServiceSubItem);
    }

    $this->tplDisplay("admin/services_sub_item/add.php");
  }
  function add_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services_sub_item"] = $_POST;
      $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}services_sub_items`"
        ." WHERE `servicesubid` = ".$this->servicesub['id']
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "services_sub_items",
      array(
        "servicesubid" => $this->servicesub['id'],
        "name" => $_POST["name"],
        "description" => $_POST["description"],
        "sort_order" => $sOrder,
        "created_datetime" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    $_SESSION["admin"]["admin_services_sub_item"] = null;

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/?info=".urlencode("Service created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_services_sub_item"])) {
      $aServiceSubItemRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub_items`"
          ." WHERE `id` = ".$this->urlVars->dynamic["id"]
        ,"row"
      );

      $aServiceSubItem = $_SESSION["admin"]["admin_services_sub_item"];

      $aServiceSubItem["updated_datetime"] = $aServiceSubItemRow["updated_datetime"];
      $aServiceSubItem["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aServiceSubItemRow["updated_by"]
        ,"row"
      );
    } else {
      $aServiceSubItem = $this->model->getServicesSubsItem($this->urlVars->dynamic["id"]);

      $aServiceSubItem["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aServiceSub["updated_by"]
        ,"row"
      );
    }

    $this->tplAssign("aServiceSubItem", $aServiceSubItem);

    $this->tplDisplay("admin/services_sub_item/edit.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_services_sub_item"] = $_POST;
      $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "services_sub_items",
      array(
        "name" => $_POST["name"],
        "description" => $_POST["description"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    $_SESSION["admin"]["admin_services_sub_item"] = null;

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $this->dbDelete("services_sub_items", $this->urlVars->dynamic["id"]);

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aService = $this->model->getServicesSubsItem($this->urlVars->dynamic["id"]);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub_items`"
          ." WHERE `sort_order` < ".$aService["sort_order"]
          ." AND `servicesubid` = ".$this->servicesub['id']
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}services_sub_items`"
          ." WHERE `sort_order` > ".$aService["sort_order"]
          ." AND `servicesubid` = ".$this->servicesub['id']
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "services_sub_items",
      array(
        "sort_order" => 0
      ),
      $aService["id"]
    );

    $this->dbUpdate(
      "services_sub_items",
      array(
        "sort_order" => $aService["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "services_sub_items",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aService["id"]
    );

    $this->forward("/admin/portfolio/services/".$this->service['id']."/sub/".$this->servicesub['id']."/item/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
