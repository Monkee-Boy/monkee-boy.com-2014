<?php
class admin_news extends adminController {
	public $errors;

	function __construct() {
		parent::__construct("news");

		$this->menuPermission("news");

		$this->errors = array();
	}

	function index() {
		// Clear saved form info
		$_SESSION["admin"]["admin_news"] = null;

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sCategory", $_GET["category"]);
		$this->tplAssign("aArticles", $this->model->getArticles($_GET["category"], true));

		$this->tplDisplay("admin/index.php");
	}
	function add() {
		if(!empty($_SESSION["admin"]["admin_news"])) {
			$aArticle = $_SESSION["admin"]["admin_news"];
			$aArticle["publish_on"] = strtotime($aArticle["publish_on_date"]." ".$aArticle["publish_on_Hour"].":".$aArticle["publish_on_Minute"]." ".$aArticle["publish_on_Meridian"]);

			$this->tplAssign("aArticle", $aArticle);
		} else
			$this->tplAssign("aArticle",
				array(
					"publish_on_date" => date("l, F d, Y")
					,"active" => 1
					,"categories" => array()
				)
			);

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sUseCategories", $this->model->useCategories);
		$this->tplAssign("sExcerptCharacters", $this->model->excerptCharacters);
		$this->tplAssign("sTwitterConnect", $this->getSetting("twitter_connect"));
		$this->tplAssign("sFacebookConnect", $this->getSetting("facebook_connect"));
		$this->tplDisplay("admin/add.php");
	}
	function add_s() {
		if(empty($_POST["title"]) || empty($_POST["content"])) {
			$_SESSION["admin"]["admin_news"] = $_POST;
			$this->forward("/admin/news/add/?error=".urlencode("Please fill in all required fields!"));
		}

		if($_POST["submit-type"] === "Save Draft")
			$sActive = 0;
		elseif($_POST["submit-type"] === "Publish")
			$sActive = 1;

		$publish_on = strtotime(
			$_POST["publish_on_date"]." "
			.$_POST["publish_on_Hour"].":".$_POST["publish_on_Minute"]." "
			.$_POST["publish_on_Meridian"]
		);
		$publish_on = date('Y-m-d H:i:s', $publish_on);

		$sTag = substr(strtolower(str_replace("--","-",preg_replace("/([^a-z0-9_-]+)/i", "", str_replace(" ","-",trim($_POST["title"]))))),0,100);

		$aArticles = $this->dbQuery(
			"SELECT `tag` FROM `{dbPrefix}news`"
				." ORDER BY `tag`"
			,"all"
		);

		if(in_array(array('tag' => $sTag), $aArticles)) {
			$i = 1;
			do {
				$sTempTag = substr($sTag, 0, 100-(strlen($i)+1)).'-'.$i;
				$i++;
				$checkDuplicate = in_array(array('tag' => $sTempTag), $aArticles);
			} while ($checkDuplicate);
			$sTag = $sTempTag;
		}

		$sID = $this->dbInsert(
			"news",
			array(
				"title" => $_POST["title"]
				,"tag" => $sTag
				,"excerpt" => (string)substr($_POST["excerpt"], 0, $this->model->excerptCharacters)
				,"content" => $_POST["content"]
				,"tags" => $_POST["tags"]
				,"publish_on" => $publish_on
				,"active" => $this->boolCheck($sActive)
				,"seo_title" => $_POST["seo_title"]
				,"seo_description" => $_POST["seo_description"]
				,"seo_keywords" => $_POST["seo_keywords"]
				,"created_datetime" => date('Y-m-d H:i:s')
				,"created_by" => $_SESSION["admin"]["userid"]
				,"updated_datetime" => date('Y-m-d H:i:s')
				,"updated_by" => $_SESSION["admin"]["userid"]
			)
		);

		if(!empty($_POST["categories"])) {
			foreach($_POST["categories"] as $sCategory) {
				$this->dbInsert(
					"news_categories_assign",
					array(
						"articleid" => $sID
						,"categoryid" => $sCategory
					)
				);
			}
		}

		$_SESSION["admin"]["admin_news"] = null;

		// if($_POST["post_twitter"] == 1 && $_POST["active"] == 1) {
		// 	$this->postTwitter($sID);
		// }

		// if($_POST["post_facebook"] == 1 && $_POST["active"] == 1)
		// 	$this->postFacebook($sID);

		$this->forward("/admin/news/?success=".urlencode("Article created successfully!")."&".implode("&", $this->errors));
	}
	function edit() {
		if(!empty($_SESSION["admin"]["admin_news"])) {
			$aArticleRow = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}news`"
					." WHERE `id` = ".$this->dbQuote($this->urlVars->dynamic["id"], "integer")
				,"row"
			);

			$aArticle = $_SESSION["admin"]["admin_news"];

			$aArticle["updated_datetime"] = $aArticleRow["updated_datetime"];
			$aArticle["updated_by"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}users`"
					." WHERE `id` = ".$aArticleRow["updated_by"]
				,"row"
			);

			$this->tplAssign("aArticle", $aArticle);
		} else {
			$aArticle = $this->model->getArticle($this->urlVars->dynamic["id"], null, true);

			$aArticle["categories"] = $this->dbQuery(
				"SELECT `categories`.`id` FROM `{dbPrefix}news_categories` AS `categories`"
					." INNER JOIN `{dbPrefix}news_categories_assign` AS `news_assign` ON `categories`.`id` = `news_assign`.`categoryid`"
					." WHERE `news_assign`.`articleid` = ".$aArticle["id"]
					." GROUP BY `categories`.`id`"
					." ORDER BY `categories`.`name`"
				,"col"
			);

			$aArticle["publish_on_date"] = date("l, F d, Y", $aArticle["publish_on"]);

			$aArticle["updated_by"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}users`"
					." WHERE `id` = ".$aArticle["updated_by"]
				,"row"
			);

			$this->tplAssign("aArticle", $aArticle);
		}

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("sUseCategories", $this->model->useCategories);
		$this->tplAssign("sExcerptCharacters", $this->model->excerptCharacters);
		$this->tplAssign("sTwitterConnect", $this->getSetting("twitter_connect"));
		$this->tplAssign("sFacebookConnect", $this->getSetting("facebook_connect"));
		$this->tplDisplay("admin/edit.php");
	}
	function edit_s() {
		if(empty($_POST["title"]) || empty($_POST["content"])) {
			$_SESSION["admin"]["admin_news"] = $_POST;
			$this->forward("/admin/news/edit/".$_POST["id"]."/?error=".urlencode("Please fill in all required fields!"));
		}

		if($_POST["submit-type"] === "Save Draft") {
			$sActive = 0;
		} elseif($_POST["submit-type"] === "Publish") {
			$sActive = 1;
		} else {
			if($_POST["active"] == 1)
				$sActive = 1;
			else
				$sActive = 0;
		}

		$publish_on = strtotime(
			$_POST["publish_on_date"]." "
			.$_POST["publish_on_Hour"].":".$_POST["publish_on_Minute"]." "
			.$_POST["publish_on_Meridian"]
		);
		$publish_on = date('Y-m-d H:i:s', $publish_on);

		$sTag = substr(strtolower(str_replace("--","-",preg_replace("/([^a-z0-9_-]+)/i", "", str_replace(" ","-",trim($_POST["title"]))))),0,100);

		$aArticles = $this->dbQuery(
			"SELECT `tag` FROM `{dbPrefix}news`"
				." WHERE `id` != ".$this->dbQuote($_POST["id"], "integer")
				." ORDER BY `tag`"
			,"all"
		);

		if(in_array(array('tag' => $sTag), $aArticles)) {
			$i = 1;
			do {
				$sTempTag = substr($sTag, 0, 100-(strlen($i)+1)).'-'.$i;
				$i++;
				$checkDuplicate = in_array(array('tag' => $sTempTag), $aArticles);
			} while ($checkDuplicate);
			$sTag = $sTempTag;
		}

		$this->dbUpdate(
			"news",
			array(
				"title" => $_POST["title"]
				,"excerpt" => (string)substr($_POST["excerpt"], 0, $this->model->excerptCharacters)
				,"content" => $_POST["content"]
				,"tags" => $_POST["tags"]
				,"publish_on" => $publish_on
				,"active" => $this->boolCheck($sActive)
				,"seo_title" => $_POST["seo_title"]
				,"seo_description" => $_POST["seo_description"]
				,"seo_keywords" => $_POST["seo_keywords"]
				,"updated_datetime" => date('Y-m-d H:i:s')
				,"updated_by" => $_SESSION["admin"]["userid"]
			),
			$_POST["id"]
		);

		$this->dbDelete("news_categories_assign", $_POST["id"], "articleid");
		if(!empty($_POST["categories"])) {
			foreach($_POST["categories"] as $sCategory) {
				$this->dbInsert(
					"news_categories_assign",
					array(
						"articleid" => $_POST["id"]
						,"categoryid" => $sCategory
					)
				);
			}
		}

		$_SESSION["admin"]["admin_news"] = null;

		// if($_POST["post_twitter"] == 1 && $_POST["active"] == 1) {
		// 	$this->postTwitter($_POST["id"]);
		// }

		// if($_POST["post_facebook"] == 1 && $_POST["active"] == 1)
		// 	$this->postFacebook($_POST["id"]);

		$this->forward("/admin/news/?success=".urlencode("Changes saved successfully!")."&".implode("&", $this->errors));
	}
	function delete() {
		$this->dbDelete("news", $this->urlVars->dynamic["id"]);
		$this->dbDelete("news_categories_assign", $this->urlVars->dynamic["id"], "articleid");

		$this->forward("/admin/news/?success=".urlencode("Article removed successfully!"));
	}

	function categories_index() {
		$_SESSION["admin"]["admin_news_categories"] = null;

		$sMinSort = $this->dbQuery(
			"SELECT MIN(`sort_order`) FROM `{dbPrefix}news_categories`"
			,"one"
		);
		$sMaxSort = $this->dbQuery(
			"SELECT MAX(`sort_order`) FROM `{dbPrefix}news_categories`"
			,"one"
		);

		$this->tplAssign("aCategories", $this->model->getCategories());
		$this->tplAssign("aCategoryEdit", $this->model->getCategory($_GET["category"]));
		$this->tplAssign("minSort", $sMinSort);
		$this->tplAssign("maxSort", $sMaxSort);
		$category = explode("-", $this->model->sortCategory);
		$this->tplAssign("sSort", array_shift($category));

		$this->tplDisplay("admin/categories.php");
	}
	function categories_add_s() {
		$sOrder = $this->dbQuery(
			"SELECT MAX(`sort_order`) + 1 FROM `{dbPrefix}news_categories`"
			,"one"
		);

		if(empty($sOrder))
			$sOrder = 1;

		$this->dbInsert(
			"news_categories",
			array(
				"name" => $_POST["name"]
				,"parentid" => $_POST["parent"]
				,"sort_order" => $sOrder
			)
		);

		$this->forward("/admin/news/categories/?success=".urlencode("Category created successfully!"));
	}
	function categories_edit_s() {
		$this->dbUpdate(
			"news_categories",
			array(
				"name" => $_POST["name"]
				,"parentid" => $_POST["parent"]
			),
			$_POST["id"]
		);

		$this->forward("/admin/news/categories/?success=".urlencode("Changes saved successfully!"));
	}
	function categories_delete() {
		$this->dbDelete("news_categories", $this->urlVars->dynamic["id"]);
		$this->dbDelete("news_categories_assign", $this->urlVars->dynamic["id"], "categoryid");

		$this->forward("/admin/news/categories/?success=".urlencode("Category removed successfully!"));
	}
	function categories_sort() {
		$aCategory = $this->model->getCategory($this->urlVars->dynamic["id"], "integer");

		if($this->urlVars->dynamic["sort"] == "up") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}news_categories`"
					." WHERE `sort_order` < ".$aCategory["sort_order"]
					." ORDER BY `sort_order` DESC"
				,"row"
			);
		} elseif($this->urlVars->dynamic["sort"] == "down") {
			$aOld = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}news_categories`"
					." WHERE `sort_order` > ".$aCategory["sort_order"]
					." ORDER BY `sort_order` ASC"
				,"row"
			);
		}

		$this->dbUpdate(
			"news_categories",
			array(
				"sort_order" => 0
			),
			$aCategory["id"]
		);

		$this->dbUpdate(
			"news_categories",
			array(
				"sort_order" => $aCategory["sort_order"]
			),
			$aOld["id"]
		);

		$this->dbUpdate(
			"news_categories",
			array(
				"sort_order" => $aOld["sort_order"]
			),
			$aCategory["id"]
		);

		$this->forward("/admin/news/categories/?success=".urlencode("Sort order saved successfully!"));
	}

	/**
	 * Send post to Twitter
	 * @param  integer $sID    Unique post ID.
	 */
	// function postTwitter($sID) {
	// 	$oTwitter = $this->loadTwitter();
	// 	$aPost = $this->model->getPost($sID);
	//
	// 	if($oTwitter != false) {
	// 		$sPrefix = 'http';
	// 		if ($_SERVER["HTTPS"] == "on") {$sPrefix .= "s";}
	// 			$sPrefix .= "://";
	//
	// 		$sUrl = $this->urlShorten($sPrefix.$_SERVER["HTTP_HOST"].$aPost["url"]);
	//
	// 		$aParameters = array("status" => $aPost["title"]." ".$aPost["url"]);
	// 		$status = $oTwitter->post("statuses/update", $aParameters);
	//
	// 		if($oTwitter->http_code != 200) {
	// 			$this->errors[] = "errors[]=".urlencode("Error posting to Twitter. Please try again later.");
	// 		}
	// 	} else {
	// 		$this->errors[] = "errors[]=".urlencode("Unable to connect with Twitter. Please try again later.");
	// 	}
	// }

	/**
	 * Send post to Facebook
	 * @param  integer $sID Unique post ID.
	 */
	// function postFacebook($sID) {
	// 	$aFacebook = $this->loadFacebook();
	// 	$aPost = $this->model->getPost($sID);
	//
	// 	$sPrefix = 'http';
	// 	if ($_SERVER["HTTPS"] == "on") {$sPrefix .= "s";}
	// 		$sPrefix .= "://";
	//
	// 	if($sImage == false)
	// 		$sImage = $sPrefix.$_SERVER["HTTP_HOST"].'/images/facebookConnect.png';
	// 	else
	// 		$sImage = $sPrefix.$_SERVER["HTTP_HOST"].'/image/posts/'.$aPost["id"].'/?width=90';
	//
	// 	try {
	// 		$aFacebook["obj"]->api('/me/feed/', 'post', array("access_token" => $aFacebook["access_token"], "name" => $aPost["title"], "description" => $aPost["excerpt"], "link" => $sPrefix.$_SERVER["HTTP_HOST"].$aPost["url"], "picture" => $aPost["image"]));
	// 	} catch (FacebookApiException $e) {
	// 		error_log($e);
	// 		$this->errors[] = "errors[]=".urlencode("Error posting to Facebook. Please try again later.");
	// 	}
	// }
}
