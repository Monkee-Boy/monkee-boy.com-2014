<?php
class news_model extends appModel {
	public $useImage, $imageMinWidth, $imageMinHeight, $imageFolder, $useCategories, $perPage, $useComments, $excerptCharacters, $sortCategory;
	public $content;

	function __construct() {
		parent::__construct();

		include(dirname(__file__)."/config.php");

		foreach($aPluginInfo["config"] as $sKey => $sValue) {
			$this->$sKey = $sValue;
		}

		$this->content = getContent(null, 'latest-news');
	}

	/**
	 * Get news from the database.
	 * @param  integer $sCategory Filter only posts assigned to this category.
	 * @param  boolean $sAll      When true returns all posts no matter conditions.
	 * @param  boolean $sPopular  When true sorts posts by `views` instead of publish date.
	 * @return array              Return array of posts.
	 */
	function getArticles($sCategory = null, $sAll = false, $sPopular = false) {
		$aWhere = array();
		$sJoin = "";

		// Filter only posts that are active unless told otherwise.
		if($sAll == false) {
			$aWhere[] = "`news`.`publish_on` < NOW()";
			$aWhere[] = "`news`.`active` = 1";
		}

		// Filter posts in a category, if category provided.
		if(!empty($sCategory)) {
			$aWhere[] = "`categories`.`id` = ".$this->dbQuote($sCategory, "integer");
			$sJoin .= " LEFT JOIN `{dbPrefix}news_categories_assign` AS `news_assign` ON `news`.`id` = `news_assign`.`articleid`";
			$sJoin .= " LEFT JOIN `{dbPrefix}news_categories` AS `categories` ON `news_assign`.`categoryid` = `categories`.`id`";
		}

		// Combine the above filters for sql.
		if(!empty($aWhere)) {
			$sWhere = " WHERE ".implode(" AND ", $aWhere);
		}

		// Sort posts by `views` instead of publish date.
		if($sPopular) {
			$sOrderBy = " ORDER BY `news`.`views` DESC";
		} else {
			$sOrderBy = " ORDER BY `news`.`publish_on` DESC";
		}

		$aArticles = $this->dbQuery(
			"SELECT `news`.* FROM `{dbPrefix}news` AS `news`"
				.$sJoin
				.$sWhere
				." GROUP BY `news`.`id`"
				.$sOrderBy
			,"all"
		);

		// Clean up each post information and get additional info if needed.
		foreach($aArticles as &$aArticle) {
			$this->_getArticleInfo($aArticle);
		}

		// Posts are ready for use.
		return $aArticles;
	}

	/**
	 * Get a single post from the database.
	 * @param  integer $sId  Unique ID for the post or null.
	 * @param  string  $sTag Unique tag for the post or null.
	 * @param  boolean $sAll When true returns result no matter conditions.
	 * @return array         Return the post.
	 */
	function getArticle($sId, $sTag = "", $sAll = false) {
		if(!empty($sId))
			$sWhere = " WHERE `news`.`id` = ".$this->dbQuote($sId, "integer");
		else
			$sWhere = " WHERE `news`.`tag` = ".$this->dbQuote($sTag, "text");

		if($sAll == false) {
			$sWhere .= " AND `news`.`active` = 1";
			$sWhere .= " AND `news`.`publish_on` < NOW()";
		}

		$aArticle = $this->dbQuery(
			"SELECT `news`.* FROM `{dbPrefix}news` AS `news`"
				.$sWhere
			,"row"
		);

		$this->_getArticleInfo($aArticle);

		return $aArticle;
	}

	function getLatest() {
		$aArticle = $this->dbQuery(
			"SELECT `news`.* FROM `{dbPrefix}news` AS `news`"
			." WHERE `news`.`active` = 1"
			." AND `news`.`publish_on` < NOW()"
			." ORDER BY `news`.`publish_on` DESC"
			." LIMIT 1"
			,"row"
		);

		$this->_getArticleInfo($aArticle);

		return $aArticle;
	}

	/**
	 * Clean up post info and get any other data to be returned.
	 * @param  array &$aPost An array of a single post.
	 */
	private function _getArticleInfo(&$aArticle) {
		if(!empty($aArticle)) {
			$aArticle["publish_on"] = strtotime($aArticle["publish_on"]);
			$aArticle["title"] = htmlspecialchars(stripslashes($aArticle["title"]));
			if(!empty($aArticle["excerpt"]))
				$aArticle["excerpt"] = nl2br(htmlspecialchars(stripslashes($aArticle["excerpt"])));
			else
				$aArticle["excerpt"] = (string)substr(nl2br(htmlspecialchars(stripslashes(strip_tags($aArticle["content"])))), 0, $this->excerptCharacters);

			$aArticle["content"] = stripslashes($aArticle["content"]);
			$aArticle["url"] = $this->content['url'].date("Y", $aArticle["publish_on"])."/".date("m", $aArticle["publish_on"])."/".date("d", $aArticle["publish_on"])."/".$aArticle["tag"]."/";

			$aArticle["categories"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}news_categories` AS `categories`"
					." INNER JOIN `{dbPrefix}news_categories_assign` AS `news_assign` ON `news_assign`.`categoryid` = `categories`.`id`"
					." WHERE `news_assign`.`articleid` = ".$aArticle["id"]
				,"all"
			);

			foreach($aArticle["categories"] as &$aCategory) {
				$aCategory["name"] = htmlspecialchars(stripslashes($aCategory["name"]));
			}
		}
	}

	/**
	 * Get a posts URL
	 * @param  integer $sID A posts unique ID.
	 * @return array|false  Return post URL or false.
	 */
	function getURL($sID) {
		$aArticle = $this->getArticle($sID);

		if(!empty($aArticle)) {
			return $aArticle["url"];
		} else {
			return false;
		}
	}

	/**
	 * Get categories from database
	 * @param  boolean $sEmpty When false only returns categories with assigned posts.
	 * @return array           Return array of categories.
	 */
	function getCategories($sEmpty = true) {
		$sJoin = "";

		if($sEmpty == false) {
			$sJoin .= " INNER JOIN `{dbPrefix}news_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`";
		} else {
			$sJoin .= " LEFT JOIN `{dbPrefix}news_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`";
		}

		// Check if sort direction is set, and clean it up for SQL use
		$category = explode("-", $this->sortCategory);
		$sSortDirection = array_pop($category);
		if(empty($sSortDirection) || !in_array(strtolower($sSortDirection), array("asc", "desc"))) {
			$sSortDirection = "ASC";
		} else {
			$sSortDirection = strtoupper($sSortDirection);
		}

		// Choose sort method based on model setting
		switch(array_shift($category)) {
			case "manual":
				$sOrderBy = " ORDER BY `sort_order` ".$sSortDirection;
				break;
			case "items":
				$sOrderBy = " ORDER BY `items` ".$sSortDirection;
				break;
			case "random":
				$sOrderBy = " ORDER BY RAND()";
				break;
			// Default to sort by name
			default:
				$sOrderBy = " ORDER BY `name` ".$sSortDirection;
		}

		$aCategories = $this->dbQuery(
			"SELECT `categories`.* FROM `{dbPrefix}news_categories` AS `categories`"
				.$sJoin
				." GROUP BY `id`"
				.$sOrderBy
			,"all"
		);

		foreach($aCategories as &$aCategory) {
			$this->_getCategoryInfo($aCategory);
		}

		return $aCategories;
	}

	/**
	 * Get a single category from the database.
	 * @param  integer $sId   Unique ID for the category or null.
	 * @param  string  $sName Unique name for the category or null.
	 * @return array          Return the category.
	 */
	function getCategory($sId = null, $sName = null) {
		if(!empty($sId))
			$sWhere = " WHERE `id` = ".$this->dbQuote($sId, "integer");
		elseif(!empty($sName))
			$sWhere = " WHERE `name` LIKE ".$this->dbQuote($sName, "text");
		else
			return false;

		$aCategory = $this->dbQuery(
			"SELECT `categories`.* FROM `{dbPrefix}news_categories` AS `categories`"
				." LEFT JOIN `{dbPrefix}news_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`"
				.$sWhere
			,"row"
		);

		$this->_getCategoryInfo($aCategory);

		return $aCategory;
	}

	/**
	 * Clean up category info and get any other data to be returned.
	 * @param  array &$aPost An array of a single category.
	 */
	private function _getCategoryInfo(&$aCategory) {
		if(!empty($aCategory)) {
			$aCategory["name"] = htmlspecialchars(stripslashes($aCategory["name"]));

			if(!empty($aCategory["parentid"]))
				$aCategory["parent"] = $this->getCategory($aCategory["parentid"]);
		}
	}
}
