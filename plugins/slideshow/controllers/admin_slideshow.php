<?php
class admin_slideshow extends adminController
{
	function __construct() {
		parent::__construct("slideshow");
		
		$this->menuPermission("slideshow");
	}	
	### DISPLAY ######################
	function index() {
		$oSlideshow = $this->loadModel("slideshow");

		$this->tplAssign("aImages", $oSlideshow->getSlides(true));
		$this->tplAssign("imageMinWidth", $oSlideshow->imageMinWidth);
		$this->tplAssign("imageMinHeight", $oSlideshow->imageMinHeight);
		$this->tplDisplay("admin/index.tpl");
	}
	function add() {
		$oSlideshow = $this->loadModel("slideshow");
		
		if(!empty($_SESSION["admin"]["admin_slideshow"])) {
			$aImage = $_SESSION["admin"]["admin_slideshow"];
			
			$this->tplAssign("aImage", $aImage);
		} else
			$this->tplAssign("aImage",
				array(
					"active" => 1
				)
			);
		
		$this->tplAssign("useDescription", $oSlideshow->useDescription);
		$this->tplAssign("imageMinWidth", $oSlideshow->imageMinWidth);
		$this->tplAssign("imageMinHeight", $oSlideshow->imageMinHeight);
		$this->tplAssign("sShortContentCount", $oSlideshow->shortContentCharacters);
		$this->tplDisplay("admin/add.tpl");
	}
	function add_s() {
		$oSlideshow = $this->loadModel("slideshow");
		
		if(empty($_POST["title"]) || empty($_FILES["image"]["type"])) {
			$_SESSION["admin"]["admin_slideshow"] = $_POST;
			$this->forward("/admin/slideshow/add/?error=".urlencode("Please fill in all required fields!"));
		}
		
		$sID = $this->dbInsert(
			"slideshow",
			array(
				"title" => $_POST["title"]
				,"description" => (string)substr($_POST["description"], 0, $oSlideshow->shortContentCharacters)
				,"active" => $this->boolCheck($_POST["active"])
			)
		);
		
		$_SESSION["admin"]["admin_slideshow"] = null;
		
		$_POST["id"] = $sID;
		$this->image_upload_s();
	}
	function edit() {
		$oSlideshow = $this->loadModel("slideshow");

		$this->tplAssign("aImage", $oSlideshow->getSlide($this->urlVars->dynamic["id"]));
		$this->tplAssign("useDescription", $oSlideshow->useDescription);
		$this->tplAssign("imageMinWidth", $oSlideshow->imageMinWidth);
		$this->tplAssign("imageMinHeight", $oSlideshow->imageMinHeight);
		$this->tplAssign("sShortContentCount", $oSlideshow->shortContentCharacters);
		$this->tplDisplay("admin/edit.tpl");
	}
	function edit_s() {		
		$this->dbUpdate(
			"slideshow",
			array(
				"title" => $_POST["title"]
				,"description" => $_POST["description"]
				,"active" => $this->boolCheck($_POST["active"])
			),
			$_POST["id"]
		);
		
		if(!empty($_FILES["image"]["type"]))
			$this->image_upload_s();
		else {
			if($_POST["submit"] == "Save Changes")
				$this->forward("/admin/slideshow/?notice=".urlencode("Changes saved successfully!"));
			elseif($_POST["submit"] == "edit")
				$this->forward("/admin/slideshow/image/".$_POST["id"]."/edit/");
		}
		
		$this->forward("/admin/slideshow/?notice=".urlencode("Changes saved successfully!"));
	}
	function delete() {
		$this->dbDelete("slideshow", $this->urlVars->dynamic["id"]);
		@unlink($this->settings->rootPublic."uploads/slideshow/".$this->urlVars->dynamic["id"].".jpg");
		
		$this->forward("/admin/slideshow/?notice=".urlencode("Image removed successfully!"));
	}
	function image_upload_s() {
		$oSlideshow = $this->loadModel("slideshow");
				
		if(!is_dir($this->settings->rootPublic.substr($oSlideshow->imageFolder, 1)))
			mkdir($this->settings->rootPublic.substr($oSlideshow->imageFolder, 1), 0777);

		if($_FILES["image"]["type"] == "image/jpeg"
		 || $_FILES["image"]["type"] == "image/jpg"
		 || $_FILES["image"]["type"] == "image/pjpeg"
		) {
			$sFile = $this->settings->rootPublic.substr($oSlideshow->imageFolder, 1).$_POST["id"].".jpg";
			
			$aImageSize = getimagesize($_FILES["image"]["tmp_name"]);
			if($aImageSize[0] < $oSlideshow->imageMinWidth || $aImageSize[1] < $oSlideshow->imageMinHeight) {
				$this->forward("/admin/slideshow/image/".$_POST["id"]."/edit/?error=".urlencode("Image does not meet the minimum width and height requirements."));
			}
			
			if(move_uploaded_file($_FILES["image"]["tmp_name"], $sFile)) {			
				$this->dbUpdate(
					"slideshow",
					array(
						"photo_x1" => 0
						,"photo_y1" => 0
						,"photo_x2" => $oSlideshow->imageMinWidth
						,"photo_y2" => $oSlideshow->imageMinHeight
						,"photo_width" => $oSlideshow->imageMinWidth
						,"photo_height" => $oSlideshow->imageMinHeight
					),
					$_POST["id"]
				);
				
				$this->forward("/admin/slideshow/image/".$_POST["id"]."/edit/");
			} else
				$this->forward("/admin/slideshow/image/".$_POST["id"]."/edit/?error=".urlencode("Unable to upload image."));
		} else
			$this->forward("/admin/slideshow/image/".$_POST["id"]."/edit/?error=".urlencode("Image not a jpg. Image is (".$_FILES["file"]["type"].")."));
	}
	function image_edit() {
		$oSlideshow = $this->loadModel("slideshow");
		
		// Preview Size
		if($oSlideshow->imageMinWidth < 300) {
			$sPreviewWidth = $oSlideshow->imageMinWidth;
			$sPreviewHeight = $oSlideshow->imageMinHeight;
		} else {
			$sPreviewWidth = 300;
			$sPreviewHeight = ceil($oSlideshow->imageMinHeight * (300 / $oSlideshow->imageMinWidth));
		}
		
		$this->tplAssign("aImage", $oSlideshow->getSlide($this->urlVars->dynamic["id"], true));
		$this->tplAssign("sFolder", $oSlideshow->imageFolder);
		$this->tplAssign("imageMinWidth", $oSlideshow->imageMinWidth);
		$this->tplAssign("imageMinHeight", $oSlideshow->imageMinHeight);
		$this->tplAssign("previewWidth", $sPreviewWidth);
		$this->tplAssign("previewHeight", $sPreviewHeight);
		$this->tplDisplay("admin/image.tpl");
	}
	function image_edit_s() {
		$this->dbUpdate(
			"slideshow",
			array(
				"photo_x1" => $_POST["x1"]
				,"photo_y1" => $_POST["y1"]
				,"photo_x2" => $_POST["x2"]
				,"photo_y2" => $_POST["y2"]
				,"photo_width" => $_POST["width"]
				,"photo_height" => $_POST["height"]
			),
			$_POST["id"]
		);

		$this->forward("/admin/slideshow/?notice=".urlencode("Image cropped successfully!"));
	}
	##################################
}