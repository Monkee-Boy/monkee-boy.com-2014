<?php
class admin_clients extends adminController {
  function __construct(){
    parent::__construct("clients");

    $this->menuPermission("clients");
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_clients"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}clients`"
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}clients`"
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
    if(!empty($_SESSION["admin"]["admin_clients"]))
      $this->tplAssign("aClient", $_SESSION["admin"]["admin_clients"]);
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
      $_SESSION["admin"]["admin_clients"] = $_POST;
      $this->forward("/admin/clients/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}clients`"
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "clients",
      array(
        "name" => $_POST["name"],
        "website" => $_POST["website"],
        "sort_order" => $sOrder,
        "active" => $this->boolCheck($_POST["active"]),
        "created_datetime" => 'NOW()',
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => 'NOW()',
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    if($_FILES["logo"]["error"] != 4) {
      if($_FILES["logo"]["error"] == 1 || $_FILES["logo"]["error"] == 2) {
        $this->forward("/admin/clients/?error=".urlencode("Logo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $sID.".".strtolower($file_ext);

        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "clients",
            array(
              "logo" => $upload_file
            ),
            $sID
          );
        } else {
          $this->dbUpdate(
            "clients",
            array(
              "active" => 0
            ),
            $sID
          );

          $this->forward("/admin/clients/?info=".urlencode("Failed to upload logo!"));
        }
      }
    }



    if($_FILES["logo_svg"]["error"] != 4) {
      if($_FILES["logo_svg"]["error"] == 1 || $_FILES["logo_svg"]["error"] == 2) {
        $this->forward("/admin/clients/?error=".urlencode("SVG logo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo_svg"]["name"], PATHINFO_EXTENSION);
        $upload_file = 'svg_'.$sID.".".strtolower($file_ext);

        if(move_uploaded_file($_FILES["logo_svg"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "clients",
            array(
              "logo_svg" => $upload_file
            ),
            $sID
          );
        } else {
          $this->dbUpdate(
            "clients",
            array(
              "active" => 0
            ),
            $sID
          );

          $this->forward("/admin/clients/?info=".urlencode("Failed to upload SVG logo!"));
        }
      }
    }

    $_SESSION["admin"]["admin_clients"] = null;

    $this->forward("/admin/clients/?info=".urlencode("Client created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_clients"])) {
      $aClientRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}clients`"
          ." WHERE `id` = ".$this->urlVars->dynamic["id"]
        ,"row"
      );

      $aClient = $_SESSION["admin"]["admin_clients"];

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
      $_SESSION["admin"]["admin_clients"] = $_POST;
      $this->forward("/admin/clients/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "clients",
      array(
        "name" => $_POST["name"],
        "website" => $_POST["website"],
        "sort_order" => $sOrder,
        "active" => $this->boolCheck($_POST["active"]),
        "updated_datetime" => 'NOW()',
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    if($_FILES["logo"]["error"] != 4) {
      if($_FILES["logo"]["error"] == 1 || $_FILES["logo"]["error"] == 2) {
        $this->forward("/admin/clients/?error=".urlencode("Logo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $_POST["id"].".".strtolower($file_ext);

        $sClient = $this->dbQuery(
          "SELECT `logo` FROM `{dbPrefix}clients`"
            ." WHERE `id` = ".$_POST["id"]
          ,"one"
        );
        @unlink($upload_dir.$sClient);

        if(move_uploaded_file($_FILES["logo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "clients",
            array(
              "logo" => $upload_file
            ),
            $_POST["id"]
          );
        } else {
          $this->dbUpdate(
            "clients",
            array(
              "active" => 0
            ),
            $_POST["id"]
          );

          $this->forward("/admin/clients/?error=".urlencode("Failed to upload logo!"));
        }
      }
    }

    if($_FILES["logo_svg"]["error"] != 4) {
      if($_FILES["logo_svg"]["error"] == 1 || $_FILES["logo_svg"]["error"] == 2) {
        $this->forward("/admin/clients/?error=".urlencode("SVG logo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["logo_svg"]["name"], PATHINFO_EXTENSION);
        $upload_file = 'svg_'.$_POST["id"].".".strtolower($file_ext);

        $sClient = $this->dbQuery(
          "SELECT `logo_svg` FROM `{dbPrefix}clients`"
          ." WHERE `id` = ".$_POST["id"]
          ,"one"
        );
        @unlink($upload_dir.$sClient);

        if(move_uploaded_file($_FILES["logo_svg"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "clients",
            array(
              "logo_svg" => $upload_file
            ),
            $_POST["id"]
          );
        } else {
          $this->dbUpdate(
            "clients",
            array(
              "active" => 0
            ),
            $_POST["id"]
          );

          $this->forward("/admin/clients/?error=".urlencode("Failed to upload SVG logo!"));
        }
      }
    }

    $_SESSION["admin"]["admin_clients"] = null;

    $this->forward("/admin/clients/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $aClient = $this->model->getClient($this->urlVars->dynamic["id"], true);

    $this->dbDelete("clients", $this->urlVars->dynamic["id"]);

    @unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$aClient["logo"]);

    $this->forward("/admin/clients/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aClient = $this->model->getClient($this->urlVars->dynamic["id"], true);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}clients`"
          ." WHERE `sort_order` < ".$aClient["sort_order"]
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}clients`"
          ." WHERE `sort_order` > ".$aClient["sort_order"]
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "clients",
      array(
        "sort_order" => 0
      ),
      $aClient["id"]
    );

    $this->dbUpdate(
      "clients",
      array(
        "sort_order" => $aClient["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "clients",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aClient["id"]
    );

    $this->forward("/admin/clients/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
