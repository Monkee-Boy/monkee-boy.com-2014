<?php
class admin_portfolio extends adminController {
  function __construct(){
    parent::__construct("portfolio");

    $this->menuPermission("portfolio");
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_portfolio"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}portfolio`"
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}portfolio`"
      ,"one"
    );

    $sSort = explode("-", $this->model->sort);

    $this->tplAssign("aClients", $this->model->getClients(false, true));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/index.php");
  }
  function add() {
    if(!empty($_SESSION["admin"]["admin_portfolio"]))
      $this->tplAssign("aClient", $_SESSION["admin"]["admin_portfolio"]);
    else {
      $aClient = array(
        "menu" => array()
        ,"active" => 1
      );

      $this->tplAssign("aClient", $aClient);
    }

    $this->tplDisplay("admin/add.php");
  }
  function add_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_portfolio"] = $_POST;
      $this->forward("/admin/portfolio/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}portfolio`"
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "portfolio",
      array(
        "name" => $_POST["name"],
        "website" => $_POST["website"],
        "sort_order" => $sOrder,
        "active" => $this->boolCheck($_POST["active"]),
        "created_datetime" => time(),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => time(),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    if($_FILES["logo"]["error"] != 4) {
      if($_FILES["logo"]["error"] == 1 || $_FILES["logo"]["error"] == 2) {
        $this->forward("/admin/portfolio/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $sID.".".strtolower($file_ext);

        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "portfolio",
            array(
              "logo" => $upload_file
            ),
            $sID
          );
        } else {
          $this->dbUpdate(
            "portfolio",
            array(
              "active" => 0
            ),
            $sID
          );

          $this->forward("/admin/portfolio/?info=".urlencode("Failed to upload file!"));
        }
      }
    }

    $_SESSION["admin"]["admin_portfolio"] = null;

    $this->forward("/admin/portfolio/?info=".urlencode("Client created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_portfolio"])) {
      $aClientRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}portfolio`"
          ." WHERE `id` = ".$this->urlVars->dynamic["id"]
        ,"row"
      );

      $aClient = $_SESSION["admin"]["admin_portfolio"];

      $aClient["updated_datetime"] = $aClientRow["updated_datetime"];
      $aClient["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aClientRow["updated_by"]
        ,"row"
      );
    } else {
      $aClient = $this->model->getClient($this->urlVars->dynamic["id"], true);

      $aClient["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aClient["updated_by"]
        ,"row"
      );
    }

    $this->tplAssign("aClient", $aClient);

    $this->tplDisplay("admin/edit.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_portfolio"] = $_POST;
      $this->forward("/admin/portfolio/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "portfolio",
      array(
        "name" => $_POST["name"],
        "website" => $_POST["website"],
        "sort_order" => $sOrder,
        "active" => $this->boolCheck($_POST["active"]),
        "updated_datetime" => time(),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    if($_FILES["logo"]["error"] != 4) {
      if($_FILES["logo"]["error"] == 1 || $_FILES["logo"]["error"] == 2) {
        $this->forward("/admin/portfolio/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $_POST["id"].".".strtolower($file_ext);

        $sClient = $this->dbQuery(
          "SELECT `logo` FROM `{dbPrefix}portfolio`"
            ." WHERE `id` = ".$_POST["id"]
          ,"one"
        );
        @unlink($upload_dir.$sClient);

        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "portfolio",
            array(
              "logo" => $upload_file
            ),
            $_POST["id"]
          );
        } else {
          $this->dbUpdate(
            "portfolio",
            array(
              "active" => 0
            ),
            $_POST["id"]
          );

          $this->forward("/admin/portfolio/?error=".urlencode("Failed to upload file!"));
        }
      }
    }

    $_SESSION["admin"]["admin_portfolio"] = null;

    $this->forward("/admin/portfolio/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $aClient = $this->model->getClient($this->urlVars->dynamic["id"], true);

    $this->dbDelete("portfolio", $this->urlVars->dynamic["id"]);

    @unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$aClient["logo"]);

    $this->forward("/admin/portfolio/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aClient = $this->model->getClient($this->urlVars->dynamic["id"], true);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}portfolio`"
          ." WHERE `sort_order` < ".$aClient["sort_order"]
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}portfolio`"
          ." WHERE `sort_order` > ".$aClient["sort_order"]
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "portfolio",
      array(
        "sort_order" => 0
      ),
      $aClient["id"]
    );

    $this->dbUpdate(
      "portfolio",
      array(
        "sort_order" => $aClient["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "portfolio",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aClient["id"]
    );

    $this->forward("/admin/portfolio/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
