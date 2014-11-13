<?php
class admin_galleries extends adminController {
	function __construct() {
		parent::__construct("galleries");

		$this->menuPermission("galleries");
	}

	### DISPLAY ######################
	function index() {
		// Clear saved form info
		$_SESSION["admin"]["admin_gallery"] = null;

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sCategory", $_GET["category"]);
		$this->tplAssign("aGalleries", $this->model->getGalleries($_GET["category"], true));
		$this->tplAssign("maxsort", $this->model->getMaxSort());
		$this->tplDisplay("admin/index.php");
	}
	function add() {
		if(!empty($_SESSION["admin"]["admin_gallery"]))
			$this->tplAssign("aGallery", $_SESSION["admin"]["admin_gallery"]);
		else
			$this->tplAssign("aGallery",
				array(
					"active" => 1
					,"categories" => array()
				)
			);

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sUseCategories", $this->model->useCategories);
		$this->tplDisplay("admin/add.php");
	}
	function add_s() {
		if(empty($_POST["name"])) {
			$_SESSION["admin"]["admin_galleries"] = $_POST;
			$this->forward("/admin/galleries/add/?error=".urlencode("Please fill in all required fields!"));
		}

		$sOrder = $this->dbQuery(
			"SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}galleries`"
			,"one"
		);

		if(empty($sOrder))
			$sOrder = 1;

		$sTag = substr(strtolower(str_replace("--","-",preg_replace("/([^a-z0-9_-]+)/i", "", str_replace(" ","-",trim($_POST["name"]))))),0,100);

		$aGalleries = $this->dbQuery(
			"SELECT `tag` FROM `{dbPrefix}galleries`"
				." ORDER BY `tag`"
			,"all"
		);

		if(in_array(array('tag' => $sTag), $aGalleries)) {
			$i = 1;
			do {
				$sTempTag = substr($sTag, 0, 100-(strlen($i)+1)).'-'.$i;
				$i++;
				$checkDuplicate = in_array(array('tag' => $sTempTag), $aGalleries);
			} while ($checkDuplicate);
			$sTag = $sTempTag;
		}

		$sID = $this->dbInsert(
			"galleries",
			array(
				"name" => $_POST["name"]
				,"tag" => $sTag
				,"description" => $_POST["description"]
				,"sort_order" => $sOrder
				,"active" => $this->boolCheck($_POST["active"])
				,"created_datetime" => time()
				,"created_by" => $_SESSION["admin"]["userid"]
				,"updated_datetime" => time()
				,"updated_by" => $_SESSION["admin"]["userid"]
			)
		);

		if(!empty($_POST["categories"])) {
			foreach($_POST["categories"] as $sCategory) {
				$this->dbInsert(
					"galleries_categories_assign",
					array(
						"galleryid" => $sID
						,"categoryid" => $sCategory
					)
				);
			}
		}

		@mkdir($this->settings->rootPublic.substr($this->model->imageFolder, 1).$sID."/", 0777);

		$_SESSION["admin"]["admin_galleries"] = null;

		$this->forward("/admin/galleries/".$sID."/photos/?info=".urlencode("Gallery created successfully!"));
	}
	function edit() {
		if(!empty($_SESSION["admin"]["admin_galleries"])) {
			$aGalleryRow = $this->model->getGallery($this->urlVars->dynamic["id"], null, true);

			$aGallery = $_SESSION["admin"]["admin_galleries"];

			$aGallery["updated_datetime"] = $aGalleryRow["updated_datetime"];
			$aGallery["updated_by"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}users`"
					." WHERE `id` = ".$aGalleryRow["updated_by"]
				,"row"
			);

			$this->tplAssign("aGallery", $aGallery);
		} else {
			$aGallery = $this->model->getGallery($this->urlVars->dynamic["id"], null, true);

			$aGallery["categories"] = $this->dbQuery(
				"SELECT `categories`.`id` FROM `{dbPrefix}galleries_categories` AS `categories`"
					." INNER JOIN `{dbPrefix}galleries_categories_assign` AS `galleries_assign` ON `categories`.`id` = `galleries_assign`.`categoryid`"
					." WHERE `galleries_assign`.`galleryid` = ".$aGallery["id"]
					." GROUP BY `categories`.`id`"
					." ORDER BY `categories`.`name`"
				,"col"
			);

			$aGallery["updated_by"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}users`"
					." WHERE `id` = ".$aGallery["updated_by"]
				,"row"
			);

			$this->tplAssign("aGallery", $aGallery);
		}

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sUseCategories", $this->model->useCategories);
		$this->tplDisplay("admin/edit.php");
	}
	function edit_s() {
		if(empty($_POST["name"])) {
			$_SESSION["admin"]["admin_galleries"] = $_POST;
			$this->forward("/admin/galleries/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
		}

		$this->dbUpdate(
			"galleries",
			array(
				"name" => $_POST["name"]
				,"description" => $_POST["description"]
				,"active" => $this->boolCheck($_POST["active"])
				,"updated_datetime" => time()
				,"updated_by" => $_SESSION["admin"]["userid"]
			),
			$_POST["id"]
		);

		$this->dbDelete("galleries_categories_assign", $_POST["id"], "galleryid");
		foreach($_POST["categories"] as $sCategory) {
			$this->dbInsert(
				"galleries_categories_assign",
				array(
					"galleryid" => $_POST["id"]
					,"categoryid" => $sCategory
				)
			);
		}

		$_SESSION["admin"]["admin_galleries"] = null;

		$this->forward("/admin/galleries/?info=".urlencode("Changes saved successfully!"));
	}
	function delete() {
		$this->dbDelete("galleries", $this->urlVars->dynamic["id"]);

		$aPhotos = $this->dbQuery(
			"SELECT * FROM `{dbPrefix}galleries_photos`"
				." WHERE `galleryid` = ".$this->dbQuote($this->urlVars->dynamic["id"], "integer")
			,"all"
		);

		foreach($aPhotos as $aPhoto) {
			@unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$this->urlVars->dynamic["id"]."/".$aPhoto["photo"]);

			$this->dbDelete("galleries_photos", $aPhoto["id"]);
		}

		@unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$this->urlVars->dynamic["id"]."/");

		$this->forward("/admin/galleries/?info=".urlencode("Gallery removed successfully!"));
	}
	function sort() {
		$aGallery = $this->model->getGallery($this->urlVars->dynamic["id"], null, true);

		if($this->urlVars->dynamic["sort"] == "up")
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries`"
					." WHERE `sort_order` < ".$aGallery["sort_order"]
					." ORDER BY `sort_order` DESC"
				,"row"
			);
		elseif($this->urlVars->dynamic["sort"] == "down")
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries`"
					." WHERE `sort_order` > ".$aGallery["sort_order"]
					." ORDER BY `sort_order` ASC"
				,"row"
			);

		$this->dbUpdate(
			"galleries",
			array(
				"sort_order" => $aOld["sort_order"]
			),
			$aGallery["id"]
		);

		$this->dbUpdate(
			"galleries",
			array(
				"sort_order" => $aGallery["sort_order"]
			),
			$aOld["id"]
		);

		$this->forward("/admin/galleries/?info=".urlencode("Sort order saved successfully!"));
	}

	function categories_index() {
		$_SESSION["admin"]["admin_galleries_categories"] = null;

		$sMinSort = $this->dbQuery(
			"SELECT MIN(`sort_order`) FROM `{dbPrefix}galleries_categories`"
			,"one"
		);
		$sMaxSort = $this->dbQuery(
			"SELECT MAX(`sort_order`) FROM `{dbPrefix}galleries_categories`"
			,"one"
		);

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("aCategoryEdit", $this->model->getCategory($_GET["category"]));
		$this->tplAssign("minSort", $sMinSort);
		$this->tplAssign("maxSort", $sMaxSort);
		$categorySort = explode("-", $this->model->sortCategory);
		$this->tplAssign("sSort", array_shift($categorySort));

		$this->tplDisplay("admin/categories.php");
	}
	function categories_add_s() {
		$sOrder = $this->dbQuery(
			"SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}galleries_categories`"
			,"one"
		);

		if(empty($sOrder))
			$sOrder = 1;

		$this->dbInsert(
			"galleries_categories",
			array(
				"name" => $_POST["name"]
				,"sort_order" => $sOrder
			)
		);

		$this->forward("/admin/galleries/categories/?info=".urlencode("Category created successfully!"));
	}
	function categories_edit_s() {
		$this->dbUpdate(
			"galleries_categories",
			array(
				"name" => $_POST["name"]
			),
			$_POST["id"]
		);

		$this->forward("/admin/galleries/categories/?info=".urlencode("Changes saved successfully!"));
	}
	function categories_delete() {
		$this->dbDelete("galleries_categories", $this->urlVars->dynamic["id"]);
		$this->dbDelete("galleries_categories_assign", $this->urlVars->dynamic["id"], "categoryid");

		$this->forward("/admin/galleries/categories/?info=".urlencode("Category removed successfully!"));
	}
	function categories_sort() {
		$aCategory = $this->model->getCategory($this->urlVars->dynamic["id"]);

		if($this->urlVars->dynamic["sort"] == "up") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries_categories`"
					." WHERE `sort_order` < ".$aCategory["sort_order"]
					." ORDER BY `sort_order` DESC"
				,"row"
			);
		} elseif($this->urlVars->dynamic["sort"] == "down") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries_categories`"
					." WHERE `sort_order` > ".$aCategory["sort_order"]
					." ORDER BY `sort_order` ASC"
				,"row"
			);
		}

		$this->dbUpdate(
			"galleries_categories",
			array(
				"sort_order" => 0
			),
			$aCategory["id"]
		);

		$this->dbUpdate(
			"galleries_categories",
			array(
				"sort_order" => $aCategory["sort_order"]
			),
			$aOld["id"]
		);

		$this->dbUpdate(
			"galleries_categories",
			array(
				"sort_order" => $aOld["sort_order"]
			),
			$aCategory["id"]
		);

		$this->forward("/admin/galleries/categories/?info=".urlencode("Sort order saved successfully!"));
	}

	function photos_index() {
		$aGallery = $this->model->getGallery($this->urlVars->dynamic["gallery"], null, true);

		$sMinSort = $this->dbQuery(
			"SELECT MIN(`sort_order`) FROM `{dbPrefix}galleries_photos`"
				." WHERE `galleryid` = ".$this->dbQuote($this->urlVars->dynamic["gallery"], "integer")
			,"one"
		);
		$sMaxSort = $this->dbQuery(
			"SELECT MAX(`sort_order`) FROM `{dbPrefix}galleries_photos`"
				." WHERE `galleryid` = ".$this->dbQuote($this->urlVars->dynamic["gallery"], "integer")
			,"one"
		);

		$aGallery["categories"] = $this->dbQuery(
			"SELECT `categories`.`id` FROM `{dbPrefix}galleries_categories` AS `categories`"
				." INNER JOIN `{dbPrefix}galleries_categories_assign` AS `galleries_assign` ON `categories`.`id` = `galleries_assign`.`categoryid`"
				." WHERE `galleries_assign`.`galleryid` = ".$this->urlVars->dynamic["gallery"]
				." GROUP BY `categories`.`id`"
				." ORDER BY `categories`.`name`"
			,"col"
		);

		$this->tplAssign("aDefaultPhoto", $this->model->getPhoto($this->urlVars->dynamic["gallery"], true));
		$this->tplAssign("aGallery", $aGallery);
		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sImageFolder", $this->model->imageFolder);
		$this->tplAssign("minsort", $sMinSort);
		$this->tplAssign("maxsort", $sMaxSort);
		$this->tplDisplay("admin/photos/index.php");
	}
	function photos_add() {
		$aGallery = $this->model->getGallery($this->urlVars->dynamic["gallery"], null, true);

		if(!empty($_SESSION["admin"]["admin_gallery_photo"]))
			$this->tplAssign("aPhoto", $_SESSION["admin"]["admin_gallery_photo"]);
		else
			$this->tplAssign("aPhoto",
				array(
					"active" => 1
					,"categories" => array()
				)
			);

		$this->tplAssign("aGallery", $aGallery);
		$this->tplAssign("sImageFolder", $this->model->imageFolder);
		$this->tplDisplay("admin/photos/add.php");
	}
	function photos_add_s() {
		if(empty($_POST["title"]) || $_FILES["photo"]["error"] == 4) {
			$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
			$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/add/?error=".urlencode("Please fill in all required fields!"));
		} elseif($_FILES["photo"]["error"] == 1) {
			$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
			$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/add/?error=".urlencode("File too large!"));
		}

		$sOrder = $this->dbQuery(
			"SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}galleries_photos`"
				." WHERE `galleryid` = ".$this->dbQuote($this->urlVars->dynamic["gallery"], "integer")
			,"one"
		);

		if(empty($sOrder))
			$sOrder = 1;

		$sID = $this->dbInsert(
			"galleries_photos",
			array(
				"galleryid" => $this->urlVars->dynamic["gallery"]
				,"title" => $_POST["title"]
				,"description" => $_POST["description"]
				,"sort_order" => $sOrder
			)
		);

		$upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1).$this->urlVars->dynamic["gallery"]."/";

		if(!is_dir($upload_dir))
			mkdir($upload_dir, 0777);

		$file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
		$upload_file = $sID.".".strtolower($file_ext);

		if(move_uploaded_file($_FILES["photo"]["tmp_name"], $upload_dir.$upload_file))
			$this->dbUpdate(
				"galleries_photos",
				array(
					"photo" => $upload_file
				),
				$sID
			);
		else {
			$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
			$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/add/?error=".urlencode("Failed to move file!"));
		}

		$_SESSION["admin"]["admin_gallery_photo"] = null;

		$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/?success=".urlencode("Photo successfully added!"));
	}
	function photos_edit() {
		$aGallery = $this->model->getGallery($this->urlVars->dynamic["gallery"], null, true);

		if(!empty($_SESSION["admin"]["admin_gallery_photo"])) {
			$aPhotoRow = $this->model->getPhoto($this->urlVars->dynamic["id"], null, true);

			$aPhoto = $_SESSION["admin"]["admin_gallery_photo"];
		} else {
			$aPhoto = $this->model->getPhoto($this->urlVars->dynamic["id"], null, true);
		}

		$this->tplAssign("aPhoto", $aPhoto);
		$this->tplAssign("aGallery", $aGallery);
		$this->tplAssign("sImageFolder", $this->model->imageFolder);
		$this->tplDisplay("admin/photos/edit.php");
	}
	function photos_edit_s() {
		if(empty($_POST["title"])) {
			$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
			$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
		}

		$this->dbUpdate(
			"galleries_photos",
			array(
				"title" => $_POST["title"]
				,"description" => $_POST["description"]
			),
			$_POST["id"]
		);

		if($_FILES['photo']['error'] != 4) {
			if($_FILES['photo']['error'] == 1) {
				$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
				$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/edit/".$_POST['id']."/?error=".urlencode("Failed to move file!"));
			} else {
				$aPhoto = $this->model->getPhoto($_POST['id']);

				$upload_dir = $this->settings->rootPublic.substr($this->model->imageFolder, 1).$this->urlVars->dynamic["gallery"]."/";

				if(!is_dir($upload_dir))
					mkdir($upload_dir, 0777);

				@unlink($upload_dir.$aPhoto['photo']);

				$file_ext = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
				$upload_file = $sID.".".strtolower($file_ext);

				if(move_uploaded_file($_FILES["photo"]["tmp_name"], $upload_dir.$upload_file))
					$this->dbUpdate(
						"galleries_photos",
						array(
							"photo" => $upload_file
						),
						$_POST['id']
					);
				else {
					$_SESSION["admin"]["admin_gallery_photo"] = $_POST;
					$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/edit/".$_POST['id']."/?error=".urlencode("Failed to move file!"));
				}
			}
		}

		$_SESSION["admin"]["admin_gallery_photo"] = null;

		$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/?info=".urlencode("Changes saved successfully!"));
	}
	function photos_delete() {
		$aPhoto = $this->model->getPhoto($this->urlVars->dynamic["id"]);

		@unlink($this->settings->rootPublic.substr($this->model->imageFolder, 1).$this->urlVars->dynamic["gallery"]."/".$aPhoto["photo"]);

		$this->dbDelete("galleries_photos", $aPhoto["id"]);

		if($aPhoto["gallery_default"] == 1) {
			$this->dbUpdate(
				"galleries_photos",
				array(
					"gallery_default" => 1
				),
				$this->urlVars->dynamic["gallery"], "galleryid"
			);
		}

		$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/?info=".urlencode("Photo removed successfully!"));
	}
	function photos_sort() {
		$aPhoto = $this->model->getPhoto($this->urlVars->dynamic["id"]);

		if($this->urlVars->dynamic["sort"] == "up") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries_photos`"
					." WHERE `sort_order` < ".$aPhoto["sort_order"]
					." ORDER BY `sort_order` DESC"
				,"row"
			);
		} elseif($this->urlVars->dynamic["sort"] == "down") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}galleries_photos`"
					." WHERE `sort_order` > ".$aPhoto["sort_order"]
					." ORDER BY `sort_order` ASC"
				,"row"
			);
		}

		$this->dbUpdate(
			"galleries_photos",
			array(
				"sort_order" => 0
			),
			$aPhoto["id"]
		);

		$this->dbUpdate(
			"galleries_photos",
			array(
				"sort_order" => $aPhoto["sort_order"]
			),
			$aOld["id"]
		);

		$this->dbUpdate(
			"galleries_photos",
			array(
				"sort_order" => $aOld["sort_order"]
			),
			$aPhoto["id"]
		);

		$this->forward("/admin/galleries/".$this->urlVars->dynamic["gallery"]."/photos/?info=".urlencode("Sort order saved successfully!"));
	}

	##################################
}
