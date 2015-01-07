<?php
class admin_quote extends adminController {
  function __construct(){
    parent::__construct("quote");

    $this->menuPermission("quote");
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $this->tplAssign("aQuotes", $this->model->getQuotes(null, false, true));
    $this->tplDisplay("admin/index.php");
  }
  function view() {
    $this->tplAssign("aQuote", $this->model->getQuote($this->urlVars->dynamic["id"]));
    $this->tplDisplay("admin/view.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_quote"] = $_POST;
      $this->forward("/admin/work_with_us/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "work_with_us",
      array(
        "status" => $_POST["status"]
        ,"updated_datetime" => time()
        ,"updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    $this->forward("/admin/work_with_us/?info=".urlencode("Status updated successfully!"));
  }
  function delete() {
    $this->dbDelete("work_with_us", $this->urlVars->dynamic["id"]);

    $this->forward("/admin/work_with_us/?info=".urlencode("Quote removed successfully!"));
  }
  ##################################
}
