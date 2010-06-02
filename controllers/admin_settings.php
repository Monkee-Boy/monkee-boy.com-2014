<?php
class admin_settings extends adminController
{
	function __construct() {
		parent::__construct("settings");
		
		$this->menuPermission("settings");
	}
	
	### DISPLAY ######################
	function index() {
		$aSettingsFull = $this->dbResults(
			"SELECT * FROM `settings`"
				." ORDER BY `group`, `sortOrder`, `title`"
			,"all"
		);
		
		$aSettings = array();
		include($this->_settings->root."helpers/Form.php");
		foreach($aSettingsFull as $aSetting) {
			$oField = new Form($aSetting);
			
			$aSettings[$aSetting["group"]][]["html"] = $oField->setting->html();
		}
		
		$this->tplAssign("aSettings", $aSettings);
		$this->tplAssign("curGroup", "");
		$this->tplDisplay("settings/index.tpl");
	}
	function save() {
		$aSettings = $this->dbResults(
			"SELECT * FROM `settings`"
				." ORDER BY `group`, `sortOrder`, `title`"
			,"all"
		);
		
		include($this->_settings->root."helpers/Form.php");
		foreach($aSettings as $aSetting) {
			$oField = new Form($aSetting);	
			$this->dbResults(
				"UPDATE `settings` SET"
					." `value` = '".$oField->setting->save($_POST["settings"][$aSetting["tag"]])."'"
					." WHERE `tag` = ".$this->dbQuote($aSetting["tag"], "text")
			);
		}
		
		$this->forward("/admin/settings/?notice=".urlencode("Settings saved successfully!"));
	}
	function manageIndex() {
		// Clear saved form info
		$_SESSION["admin"]["admin_settings"] = null;
		
		$aSettings = $this->dbResults(
			"SELECT * FROM `settings`"
				." ORDER BY `group`, `sortOrder`, `title`"
			,"all"
		);
		
		$this->tplAssign("aSettings", $aSettings);
		$this->tplDisplay("settings/manage/index.tpl");
	}
	function manageAdd() {
		if(!empty($_SESSION["admin"]["admin_settings"]))
			$this->tplAssign("aSetting", $_SESSION["admin"]["admin_settings"]);
		
		$this->tplDisplay("settings/manage/add.tpl");
	}
	function manageAdd_s() {
		if(empty($_POST["tag"]) || empty($_POST["title"])) {
			$_SESSION["admin"]["admin_settings"] = $_POST;
			$this->forward("/admin/settings/manage/add/?error=".urlencode("Please fill in all required fields!"));
		}
		
		$sID = $this->dbResults(
			"INSERT INTO `settings`"
				." (`group`, `tag`, `title`, `text`, `type`, `sortOrder`)"
				." VALUES"
				." ("
					.$this->dbQuote($_POST["group"], "text")
					.", ".$this->dbQuote($_POST["tag"], "text")
					.", ".$this->dbQuote($_POST["title"], "text")
					.", ".$this->dbQuote($_POST["text"], "text")
					.", ".$this->dbQuote($_POST["type"], "text")
					.", ".$this->dbQuote($_POST["sortorder"], "text")
				.")"
			,"insert"
		);
		
		$_SESSION["admin"]["admin_settings"] = null;
		
		$this->forward("/admin/settings/manage/?notice=".urlencode("Setting created successfully!"));
	}
	function manageEdit() {
		if(!empty($_SESSION["admin"]["admin_settings"])) {
			$aSetting = $_SESSION["admin"]["admin_settings"];
			
			$this->tplAssign("aSetting", $aSetting);
		} else {
			$aSetting = $this->dbResults(
				"SELECT * FROM `settings`"
					." WHERE `id` = ".$this->dbQuote($this->_urlVars->dynamic["id"], "integer")
				,"row"
			);
			
			$this->tplAssign("aSetting", $aSetting);
		}
		
		$this->tplDisplay("settings/manage/edit.tpl");
	}
	function manageEdit_s() {
		if(empty($_POST["tag"]) || empty($_POST["title"])) {
			$_SESSION["admin"]["admin_settings"] = $_POST;
			$this->forward("/admin/settings/manage/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
		}
		
		$this->dbResults(
			"UPDATE `settings` SET"
				." `group` = ".$this->dbQuote($_POST["group"], "text")
				.", `tag` = ".$this->dbQuote($_POST["tag"], "text")
				.", `title` = ".$this->dbQuote($_POST["title"], "text")
				.", `text` = ".$this->dbQuote($_POST["text"], "text")
				.", `sortOrder` = ".$this->dbQuote($_POST["sortorder"], "text")
				." WHERE `id` = ".$this->dbQuote($_POST["id"], "integer")
		);
		
		$_SESSION["admin"]["admin_settings"] = null;
		
		$this->forward("/admin/settings/manage/?notice=".urlencode("Changes saved successfully!"));
	}
	function manageDelete() {
		$this->dbResults(
			"DELETE FROM `settings`"
				." WHERE `id` = ".$this->dbQuote($this->_urlVars->dynamic["id"], "integer")
		);
		
		$this->forward("/admin/settings/manage/?notice=".urlencode("Setting removed successfully!"));
	}
	##################################
}