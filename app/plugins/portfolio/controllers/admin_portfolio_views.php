<?php
class admin_portfolio_views extends adminController {
  public $client;

  function __construct(){
    parent::__construct("portfolio");

    $this->menuPermission("portfolio");

    $this->client = $this->model->getClient($this->urlVars->dynamic['client']);
    $this->tplAssign('aClient', $this->client);
  }

  ### DISPLAY ######################
  function index() {
    $sMinSort = $this->dbQuery(
      "SELECT MIN(`sort_order`) FROM `{dbPrefix}portfolio_views`"
        ." WHERE `portfolioid` = ".$this->client['id']
      ,"one"
    );
    $sMaxSort = $this->dbQuery(
      "SELECT MAX(`sort_order`) FROM `{dbPrefix}portfolio_views`"
        ." WHERE `portfolioid` = ".$this->client['id']
      ,"one"
    );

    $sSort = explode("-", $this->model->sortPortfolioSlides);

    $this->tplAssign("aSlides", $this->model->getClientSlides(false, true));
    $this->tplAssign("minSort", $sMinSort);
    $this->tplAssign("maxSort", $sMaxSort);
    $this->tplAssign("sSort", array_shift($sSort));
    $this->tplDisplay("admin/slides/index.php");
  }
  function add() {
    $aSlide = array();
    $this->tplAssign("aSlide", $aSlide);

    $this->tplDisplay("admin/slides/add.php");
  }
  function add_s() {
    if($_FILES["listing_image"]["error"] == 4) {
      $this->forward("/admin/portfolio/".$this->client['id']."/slides/add/?error=".urlencode("Please fill in all required fields!"));
    }

    $sOrder = $this->dbQuery(
      "SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}portfolio_views`"
        ." WHERE `portfolioid` = ".$this->client['id']
      ,"one"
    );

    if(empty($sOrder))
      $sOrder = 1;

    $sID = $this->dbInsert(
      "portfolio_views",
      array(
        "portfolioid" => $this->client['id'],
        "sort_order" => $sOrder,
        "created_datetime" => date('Y-m-d H:i:s'),
        "created_by" => $_SESSION["admin"]["userid"],
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      )
    );

    $images = array("listing_image", "desktop_image", "tablet_image", "phone_image");
    foreach($images as $image) {
      if($_FILES[$image]["error"] != 4) {
        if($_FILES[$image]["error"] == 1 || $_FILES[$image]["error"] == 2) {
          $this->forward("/admin/portfolio/".$this->client['id']."/slides/?error=".urlencode($image." file size was too large!"));
        } else {
          $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
          $file_ext = pathinfo($_FILES[$image]["name"], PATHINFO_EXTENSION);
          $upload_file = $image."_".$sID.".".strtolower($file_ext);

          if(move_uploaded_file($_FILES[$image]["tmp_name"], $upload_dir.$upload_file)) {
            $this->dbUpdate(
              "portfolio_views",
              array(
                $image => $upload_file
              ),
              $sID
            );
          } else {
            $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Failed to upload ".$image."!"));
          }
        }
      }
    }

    $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Slide created successfully!"));
  }
  function edit() {
    $aSlide = $this->model->getClientSlide($this->urlVars->dynamic["id"], true, true);

    $aSlide["updated_by"] = $this->dbQuery(
      "SELECT * FROM `{dbPrefix}users`"
        ." WHERE `id` = ".$aSlide["updated_by"]
      ,"row"
    );

    $this->tplAssign("aSlide", $aSlide);

    $this->tplDisplay("admin/slides/edit.php");
  }
  function edit_s() {
    $this->dbUpdate(
      "portfolio_views",
      array(
        "updated_datetime" => date('Y-m-d H:i:s'),
        "updated_by" => $_SESSION["admin"]["userid"]
      ),
      $_POST["id"]
    );

    $images = array("listing_image", "desktop_image", "tablet_image", "phone_image");
    foreach($images as $image) {
      if($_FILES[$image]["error"] != 4) {
        if($_FILES[$image]["error"] == 1 || $_FILES[$image]["error"] == 2) {
          $this->forward("/admin/portfolio/".$this->client['id']."/slides/?error=".urlencode($image." file size was too large!"));
        } else {
          $upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1);
          $file_ext = pathinfo($_FILES[$image]["name"], PATHINFO_EXTENSION);
          $upload_file = $image."_".$_POST['id'].".".strtolower($file_ext);

          $aSlide = $this->dbQuery(
            "SELECT `".$image."` FROM `{dbPrefix}portfolio_views`"
              ." WHERE `id` = ".$_POST["id"]
            ,"one"
          );
          @unlink($upload_dir.$aSlide);

          if(move_uploaded_file($_FILES[$image]["tmp_name"], $upload_dir.$upload_file)) {
            $this->dbUpdate(
              "portfolio_views",
              array(
                $image => $upload_file
              ),
              $_POST['id']
            );
          } else {
            $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Failed to upload ".$image."!"));
          }
        }
      }
    }

    $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Changes saved successfully!"));
  }
  function delete() {
    $aSlide = $this->model->getClientSlide($this->urlVars->dynamic["id"], true);

    $this->dbDelete("portfolio_views", $this->urlVars->dynamic["id"]);

    $images = array("listing_image", "desktop_image", "tablet_image", "phone_image");
    foreach($images as $image) {
      @unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$aSlide[$image]);
    }

    $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Client removed successfully!"));
  }
  function sort() {
    $aSlide = $this->model->getClientSlide($this->urlVars->dynamic["id"], true);

    if($this->urlVars->dynamic["sort"] == "up") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}portfolio_views`"
          ." WHERE `sort_order` < ".$aSlide["sort_order"]
          ." AND `portfolioid` = ".$this->client['id']
          ." ORDER BY `sort_order` DESC"
        ,"row"
      );
    } elseif($this->urlVars->dynamic["sort"] == "down") {
      $aOld = $this->dbQuery(
        "SELECT * FROM `{dbPrefix}portfolio_views`"
          ." WHERE `sort_order` > ".$aSlide["sort_order"]
          ." AND `portfolioid` = ".$this->client['id']
          ." ORDER BY `sort_order` ASC"
        ,"row"
      );
    }

    $this->dbUpdate(
      "portfolio_views",
      array(
        "sort_order" => 0
      ),
      $aSlide["id"]
    );

    $this->dbUpdate(
      "portfolio_views",
      array(
        "sort_order" => $aSlide["sort_order"]
      ),
      $aOld["id"]
    );

    $this->dbUpdate(
      "portfolio_views",
      array(
        "sort_order" => $aOld["sort_order"]
      ),
      $aSlide["id"]
    );

    $this->forward("/admin/portfolio/".$this->client['id']."/slides/?info=".urlencode("Sort order saved successfully!"));
  }
  ##################################
}
