<?php
class admin_troop extends adminController {
  function __construct(){
    parent::__construct("troop");

    $this->menuPermission("troop");
  }

  ### DISPLAY ######################
  function index() {
    // Clear saved form info
    $_SESSION["admin"]["admin_troop"] = null;

    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}troop`"
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}troop`"
      ,"one"
    );

    $sSort = explode("-", $this->model->sort);

    $this->tplAssign("aTroop", $this->model->getTroop(false, true));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/index.php");
  }
  function add() {
    if(!empty($_SESSION["admin"]["admin_troop"]))
      $this->tplAssign("aTroop", $_SESSION["admin"]["admin_troop"]);
    else {
      $aTroop = array(
        "menu" => array()
        ,"active" => 1
        ,"social_accounts" => array()
      );

      $this->tplAssign("aTroop", $aTroop);
    }

    $this->tplAssign("aAccounts", $this->model->accounts);

    $this->tplDisplay("admin/add.php");
  }
  function add_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_troop"] = $_POST;
      $this->forward("/admin/troop/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}troop`"
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "troop",
      array(
        "name" => $_POST["name"],
        "who" => $_POST["who"],
        "what" => $_POST["what"],
        "where" => $_POST["where"],
        "quirk" => $_POST["quirk"],
        "quote" => $_POST["quote"],
        "title" => $_POST["title"],
        "social_accounts" => json_encode($_POST["social_accounts"]),
        "sort_order" => $sOrder,
        "active" => $this->boolCheck($_POST["active"]),
        "former_monkee" => $this->boolCheck($_POST["former_monkee"]),
        "created_datetime" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    if($_FILES["photo"]["error"] != 4) {
      if($_FILES["photo"]["error"] == 1 || $_FILES["photo"]["error"] == 2) {
        $this->forward("/admin/troop/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $sID."_main.".strtolower($file_ext);

        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "troop",
            array(
              "photo" => $upload_file
            ),
            $sID
          );
        } else {
          $this->dbUpdate(
            "troop",
            array(
              "active" => 0
            ),
            $sID
          );

          $this->forward("/admin/troop/?info=".urlencode("Failed to upload file!"));
        }
      }
    }

    if($_FILES["photo_over"]["error"] != 4) {
      if($_FILES["photo_over"]["error"] == 1 || $_FILES["photo_over"]["error"] == 2) {
        $this->forward("/admin/troop/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["photo_over"]["name"], PATHINFO_EXTENSION);
        $upload_file = $sID."_over.".strtolower($file_ext);

        if(move_uploaded_file($_FILES["photo_over"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "troop",
            array(
              "photo_over" => $upload_file
            ),
            $sID
          );
        } else {
          $this->dbUpdate(
            "troop",
            array(
              "active" => 0
            ),
            $sID
          );

          $this->forward("/admin/troop/?info=".urlencode("Failed to upload file!"));
        }
      }
    }

    $_SESSION["admin"]["admin_troop"] = null;

    $this->forward("/admin/troop/?info=".urlencode("Employee created successfully!"));
  }
  function edit() {
    if(!empty($_SESSION["admin"]["admin_troop"])) {
      $aEmployeeRow = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}troop`"
          ." WHERE `id` = ".$this->dbQuote($this->urlVars->dynamic["id"], "integer")
        ,"row"
      );

      $aEmployee = $_SESSION["admin"]["admin_troop"];

      $aEmployee["updated_datetime"] = $aEmployeeRow["updated_datetime"];
      $aEmployee["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aEmployeeRow["updated_by"]
        ,"row"
      );
    } else {
      $aEmployee = $this->model->getEmployee($this->urlVars->dynamic["id"], true);

      $aEmployee["updated_by"] = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}users`"
          ." WHERE `id` = ".$aEmployee["updated_by"]
        ,"row"
      );
    }

    $this->tplAssign("aEmployee", $aEmployee);
    $this->tplAssign("aAccounts", $this->model->accounts);

    $this->tplDisplay("admin/edit.php");
  }
  function edit_s() {
    if(empty($_POST["name"])) {
      $_SESSION["admin"]["admin_troop"] = $_POST;
      $this->forward("/admin/troop/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
    }

    $this->dbUpdate(
      "troop",
      array(
        "name" => $_POST["name"],
        "who" => $_POST["who"],
        "what" => $_POST["what"],
        "where" => $_POST["where"],
        "quirk" => $_POST["quirk"],
        "quote" => $_POST["quote"],
        "title" => $_POST["title"],
        "social_accounts" => json_encode($_POST["social_accounts"]),
        "active" => $this->boolCheck($_POST["active"]),
        "former_monkee" => $this->boolCheck($_POST["former_monkee"]),
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    if($_FILES["photo"]["error"] != 4) {
      if($_FILES["photo"]["error"] == 1 || $_FILES["photo"]["error"] == 2) {
        $this->forward("/admin/troop/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $upload_file = $_POST["id"]."_main.".strtolower($file_ext);

        $sEmployee = $this->dbQuery(
          "SELECT `photo` FROM `{dbPrefix}troop`"
            ." WHERE `id` = ".$_POST["id"]
          ,"one"
        );
        @unlink($upload_dir.$sEmployee);

        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "troop",
            array(
              "photo" => $upload_file
            ),
            $_POST["id"]
          );
        } else {
          $this->dbUpdate(
            "troop",
            array(
              "active" => 0
            ),
            $_POST["id"]
          );

          $this->forward("/admin/troop/?error=".urlencode("Failed to upload file!"));
        }
      }
    }

    if($_FILES["photo_over"]["error"] != 4) {
      if($_FILES["photo_over"]["error"] == 1 || $_FILES["photo_over"]["error"] == 2) {
        $this->forward("/admin/troop/?error=".urlencode("Photo file size was too large!"));
      } else {
        $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
        $file_ext = pathinfo($_FILES["photo_over"]["name"], PATHINFO_EXTENSION);
        $upload_file = $_POST["id"]."_over.".strtolower($file_ext);

        $sEmployee = $this->dbQuery(
          "SELECT `photo_over` FROM `{dbPrefix}troop`"
            ." WHERE `id` = ".$_POST["id"]
          ,"one"
        );
        @unlink($upload_dir.$sEmployee);

        if(move_uploaded_file($_FILES["photo_over"]["tmp_name"], $upload_dir.$upload_file)) {
          $this->dbUpdate(
            "troop",
            array(
              "photo_over" => $upload_file
            ),
            $_POST["id"]
          );
        } else {
          $this->dbUpdate(
            "troop",
            array(
              "active" => 0
            ),
            $_POST["id"]
          );

          $this->forward("/admin/troop/?error=".urlencode("Failed to upload file!"));
        }
      }
    }

    $_SESSION["admin"]["admin_troop"] = null;

    $this->forward("/admin/troop/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $aEmployee = $this->model->getEmployee($this->urlVars->dynamic["id"], true);

    $this->dbDelete("troop", $this->urlVars->dynamic["id"]);

    @unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$aEmployee["photo"]);
    @unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$aEmployee["photo_hover"]);

    $this->forward("/admin/troop/?info=".urlencode("Employee removed successfully!"));
  }
  function sort() {
    $aTroop = $this->model->getEmployee($this->urlVars->dynamic["id"], true);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}troop`"
          ." WHERE `sort_order` < ".$aTroop["sort_order"]
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}troop`"
          ." WHERE `sort_order` > ".$aTroop["sort_order"]
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "troop",
      array(
        "sort_order" => 0
      ),
      $aTroop["id"]
    );

    $this->dbUpdate(
      "troop",
      array(
        "sort_order" => $aTroop["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "troop",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aTroop["id"]
    );

    $this->forward("/admin/troop/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
