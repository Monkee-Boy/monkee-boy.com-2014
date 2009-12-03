<?php
class admin_faq extends adminController
{
	### DISPLAY ######################
	function index()
	{
		// Clear saved form info
		$_SESSION["admin"]["admin_faq"] = null;
		
		if(!empty($_GET["category"]))
		{
			$sSQLCategory = " INNER JOIN `faq_categories_assign` AS `assign` ON `faq`.`id` = `assign`.`faqid`";
			$sSQLCategory .= " WHERE `assign`.`categoryid` = ".$this->db_quote($_GET["category"], "integer");
		}
		
		$aQuestions = $this->db_results(
			"SELECT `faq`.* FROM `faq`"
				.$sSQLCategory
				." GROUP BY `faq`.`id`"
				." ORDER BY `faq`.`sort_order`"
			,"admin->faq->index"
			,"all"
		);
		
		$sMaxSort = $this->db_results(
			"SELECT MAX(`sort_order`) FROM `faq`"
			,"admin->faq->maxsort"
			,"one"
		);
		
		$this->tpl_assign("aCategories", $this->get_categories());
		$this->tpl_assign("sCategory", $_GET["category"]);
		$this->tpl_assign("aQuestions", $aQuestions);
		$this->tpl_assign("maxsort", $sMaxSort);
		$this->tpl_display("faq/index.tpl");
	}
	function add()
	{
		if(!empty($_SESSION["admin"]["admin_faq"]))
			$this->tpl_assign("aQuestion", $_SESSION["admin"]["admin_faq"]);
		else
			$this->tpl_assign("aQuestion",
				array(
					"active" => 1
					,"categories" => array()
				)
			);
		
		$this->tpl_assign("aCategories", $this->get_categories());
		$this->tpl_display("faq/add.tpl");
	}
	function add_s()
	{
		if(empty($_POST["question"]) || count($_POST["categories"]) == 0)
		{
			$_SESSION["admin"]["admin_faq"] = $_POST;
			$this->forward("/admin/faq/add/?error=".urlencode("Please fill in all required fields!"));
		}
		
		$sOrder = $this->db_results(
			"SELECT MAX(`sort_order`) + 1 FROM `faq`"
			,"admin->faq->add->max_order"
			,"one"
		);
		
		if(empty($sOrder))
			$sOrder = 1;
		
		if(!empty($_POST["active"]))
			$active = 1;
		else
			$active = 0;
		
		$sID = $this->db_results(
			"INSERT INTO `faq`"
				." (`question`, `answer`, `sort_order`, `active`)"
				." VALUES"
				." ("
					.$this->db_quote($_POST["question"], "text")
					.", ".$this->db_quote($_POST["answer"], "text")
					.", ".$this->db_quote($sOrder, "integer")
					.", ".$this->db_quote($active, "integer")
				.")"
			,"admin->faq->add"
			,"insert"
		);
		
		foreach($_POST["categories"] as $sCategory)
		{
			$this->db_results(
				"INSERT INTO `faq_categories_assign`"
					." (`faqid`, `categoryid`)"
					." VALUES"
					." (".$sID.", ".$sCategory.")"
				,"admin->faq->add->categories"
			);
		}
		
		$_SESSION["admin"]["admin_faq"] = null;
		
		$this->forward("/admin/faq/?notice=".urlencode("Question created successfully!"));
	}
	function sort($aParams)
	{
		$aGallery = $this->db_results(
			"SELECT * FROM `faq`"
				." WHERE `id` = ".$this->db_quote($aParams["id"], "integer")
			,"admin->faq->sort"
			,"row"
		);
		
		if($aParams["sort"] == "up")
		{
			$aOld = $this->db_results(
				"SELECT * FROM `faq`"
					." WHERE `sort_order` < ".$aGallery["sort_order"]
					." ORDER BY `sort_order` DESC"
				,"admin->faq->sort->up->new_pos"
				,"row"
			);
			
			$this->db_results(
				"UPDATE `faq` SET"
					." `sort_order` = ".$this->db_quote($aOld["sort_order"], "text")
					." WHERE `id` = ".$this->db_quote($aGallery["id"], "integer")
				,"admin->faq->sort->up->update_pos1"
			);
			
			$this->db_results(
				"UPDATE `faq` SET"
					." `sort_order` = ".$this->db_quote($aGallery["sort_order"], "text")
					." WHERE `id` = ".$this->db_quote($aOld["id"], "integer")
				,"admin->faq->sort->up->update_pos2"
			);
		}
		elseif($aParams["sort"] == "down")
		{
			$aOld = $this->db_results(
				"SELECT * FROM `faq`"
					." WHERE `sort_order` > ".$aGallery["sort_order"]
					." ORDER BY `sort_order` ASC"
				,"admin->faq->sort->down->new_pos"
				,"row"
			);
			
			$this->db_results(
				"UPDATE `faq` SET"
					." `sort_order` = ".$this->db_quote($aOld["sort_order"], "text")
					." WHERE `id` = ".$this->db_quote($aGallery["id"], "integer")
				,"admin->faq->sort->down->update_pos1"
			);
			
			$this->db_results(
				"UPDATE `faq` SET"
					." `sort_order` = ".$this->db_quote($aGallery["sort_order"], "text")
					." WHERE `id` = ".$this->db_quote($aOld["id"], "integer")
				,"admin->faq->sort->down->update_pos2"
			);
		}
		
		$this->forward("/admin/faq/?notice=".urlencode("Sort order saved successfully!"));
	}
	function edit($aParams)
	{
		if(!empty($_SESSION["admin"]["admin_faq"]))
			$this->tpl_assign("aQuestion", $_SESSION["admin"]["admin_faq"]);
		else
		{
			$aQuestion = $this->db_results(
				"SELECT * FROM `faq`"
					." WHERE `id` = ".$this->db_quote($aParams["id"], "integer")
				,"admin->faq->edit"
				,"row"
			);
			
			$aQuestion["categories"] = $this->db_results(
				"SELECT `categories`.`id` FROM `faq_categories` AS `categories`"
					." INNER JOIN `faq_categories_assign` AS `faq_assign` ON `categories`.`id` = `faq_assign`.`categoryid`"
					." WHERE `faq_assign`.`faqid` = ".$aQuestion["id"]
					." GROUP BY `categories`.`id`"
					." ORDER BY `categories`.`name`"
				,"admin->faq->edit->categories"
				,"col"
			);
			
			$this->tpl_assign("aQuestion", $aQuestion);
		}
		
		$this->tpl_assign("aCategories", $this->get_categories());
		$this->tpl_display("faq/edit.tpl");
	}
	function edit_s()
	{
		if(empty($_POST["question"]) || count($_POST["categories"]) == 0)
		{
			$_SESSION["admin"]["admin_faq"] = $_POST;
			$this->forward("/admin/faq/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
		}
		
		if(!empty($_POST["active"]))
			$active = 1;
		else
			$active = 0;
		
		$this->db_results(
			"UPDATE `faq` SET"
				." `question` = ".$this->db_quote($_POST["question"], "text")
				.", `answer` = ".$this->db_quote($_POST["answer"], "text")
				.", `active` = ".$this->db_quote($active, "integer")
				." WHERE `id` = ".$this->db_quote($_POST["id"], "integer")
			,"admin->faq->edit"
		);
		
		$this->db_results(
			"DELETE FROM `faq_categories_assign`"
				." WHERE `faqid` = ".$this->db_quote($_POST["id"], "integer")
			,"admin->faq->edit->remove_categories"
		);
		foreach($_POST["categories"] as $sCategory)
		{
			$this->db_results(
				"INSERT INTO `faq_categories_assign`"
					." (`faqid`, `categoryid`)"
					." VALUES"
					." (".$this->db_quote($_POST["id"], "integer").", ".$sCategory.")"
				,"admin->faq->edit->categories"
			);
		}
		
		$_SESSION["admin"]["admin_faq"] = null;
		
		$this->forward("/admin/faq/?notice=".urlencode("Changes saved successfully!"));
	}
	function delete($aParams)
	{
		$this->db_results(
			"DELETE FROM `faq`"
				." WHERE `id` = ".$this->db_quote($aParams["id"], "integer")
			,"admin->faq->delete"
		);
		$this->db_results(
			"DELETE FROM `faq_categories_assign`"
				." WHERE `faqid` = ".$this->db_quote($aParams["id"], "integer")
			,"admin->faq->categories_assign_delete"
		);
		
		$this->forward("/admin/faq/?notice=".urlencode("Question removed successfully!"));
	}
	function categories_index()
	{
		$_SESSION["admin"]["admin_faq_categories"] = null;
		
		$aCategories = $this->db_results(
			"SELECT * FROM `faq_categories`"
				." ORDER BY `name`"
			,"admin->faq->categories"
			,"all"
		);
		
		$this->tpl_assign("aCategories", $aCategories);
		$this->tpl_display("faq/categories.tpl");
	}
	function categories_add_s()
	{
		$this->db_results(
			"INSERT INTO `faq_categories`"
				." (`name`)"
				." VALUES"
				." ("
				.$this->db_quote($_POST["name"], "text")
				.")"
			,"admin->faq->category->add_s"
			,"insert"
		);

		echo "/admin/faq/categories/?notice=".urlencode("Category added successfully!");
	}
	function categories_edit_s()
	{
		$this->db_results(
			"UPDATE `faq_categories` SET"
				." `name` = ".$this->db_quote($_POST["name"], "text")
				." WHERE `id` = ".$this->db_quote($_POST["id"], "integer")
			,"admin->faq->categories->edit"
		);

		echo "/admin/faq/categories/?notice=".urlencode("Changes saved successfully!");
	}
	function categories_delete($aParams)
	{
		$this->db_results(
			"DELETE FROM `faq_categories`"
				." WHERE `id` = ".$this->db_quote($aParams["id"], "integer")
			,"admin->faq->category->delete"
		);
		$this->db_results(
			"DELETE FROM `faq_categories_assign`"
				." WHERE `categoryid` = ".$this->db_quote($aParams["id"], "integer")
			,"admin->faq->category->delete_assign"
		);

		$this->forward("/admin/faq/categories/?notice=".urlencode("Category removed successfully!"));
	}
	##################################
	
	### Functions ####################
	private function get_categories()
	{
		$aCategories = $this->db_results(
			"SELECT * FROM `faq_categories`"
				." ORDER BY `name`"
			,"admin->faq->get_categories->categories"
			,"all"
		);
		
		return $aCategories;
	}
	##################################
}