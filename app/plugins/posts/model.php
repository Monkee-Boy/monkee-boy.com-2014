<?php
class posts_model extends appModel {
	public $useImage, $imageFolder, $useCategories, $perPage, $useComments, $excerptCharacters, $sortCategory;
	public $content;

	function __construct() {
		parent::__construct();

		include(dirname(__file__)."/config.php");

		foreach($aPluginInfo["config"] as $sKey => $sValue) {
			$this->$sKey = $sValue;
		}

		$this->content = getContent(null, 'blog');
	}

	/**
	 * Get posts from the database.
	 * @param  integer $sCategory Filter only posts assigned to this category.
	 * @param  boolean $sAll      When true returns all posts no matter conditions.
	 * @param  boolean $sPopular  When true sorts posts by `views` instead of publish date.
	 * @return array              Return array of posts.
	 */
	function getPosts($sCategory = null, $sAll = false, $sPopular = false, $sExcludePosts = null, $sAuthorId = null, $sLimit = null) {
		$aWhere = array();
		$sJoin = '';

		// Filter only posts that are active unless told otherwise.
		if($sAll == false) {
			$aWhere[] = "`posts`.`publish_on` < NOW()";
			$aWhere[] = "`posts`.`active` = 1";
		}

		// Filter posts in a category, if category provided.
		if(!empty($sCategory)) {
			$aWhere[] = "`categories`.`id` = ".$this->dbQuote($sCategory, "integer");
			$sJoin .= " LEFT JOIN `{dbPrefix}posts_categories_assign` AS `posts_assign` ON `posts`.`id` = `posts_assign`.`postid`";
			$sJoin .= " LEFT JOIN `{dbPrefix}posts_categories` AS `categories` ON `posts_assign`.`categoryid` = `categories`.`id`";
		}

		if(!empty($sExcludePosts)) {
			$aWhere[] = "`posts`.`id` NOT IN (".$this->dbQuote($sExcludePosts, "text").")";
		}

		if(!empty($sAuthorId)) {
			$aWhere[] = "`posts`.`authorid` = ".$this->dbQuote($sAuthorId, "integer");
		}

		// Combine the above filters for sql.
		if(!empty($aWhere)) {
			$sWhere = " WHERE ".implode(" AND ", $aWhere);
		}

		// Sort posts by `views` instead of publish date.
		if($sPopular) {
			$sOrderBy = " ORDER BY `posts`.`views` DESC";
		} else {
			$sOrderBy = "ORDER BY `posts`.`sticky` DESC, `posts`.`publish_on` DESC";
		}

		if(!empty($sLimit)) {
			$sLimit = ' LIMIT '.$this->dbQuote($sLimit, "integer");
		} else {
			$sLimit = '';
		}

		$aPosts = $this->dbQuery(
			"SELECT `posts`.* FROM `{dbPrefix}posts` AS `posts`"
				.$sJoin
				.$sWhere
				." GROUP BY `posts`.`id`"
				.$sOrderBy
				.$sLimit
			,"all"
		);

		// Clean up each post information and get additional info if needed.
		foreach($aPosts as &$aPost) {
			$this->_getPostInfo($aPost);
		}

		// Posts are ready for use.
		return $aPosts;
	}

	/**
	 * Get a single post from the database.
	 * @param  integer $sId  Unique ID for the post or null.
	 * @param  string  $sTag Unique tag for the post or null.
	 * @param  boolean $sAll When true returns result no matter conditions.
	 * @return array         Return the post.
	 */
	function getPost($sId, $sTag = "", $sAll = false) {
		if(!empty($sId))
			$sWhere = " WHERE `posts`.`id` = ".$this->dbQuote($sId, "integer");
		else
			$sWhere = " WHERE `posts`.`tag` = ".$this->dbQuote($sTag, "text");

		if($sAll == false) {
			$sWhere .= " AND `posts`.`active` = 1";
			$sWhere .= " AND `posts`.`publish_on` < NOW()";
		}

		$aPost = $this->dbQuery(
			"SELECT `posts`.* FROM `{dbPrefix}posts` AS `posts`"
				.$sWhere
			,"row"
		);

		$this->_getPostInfo($aPost);

		return $aPost;
	}

	/**
	 * Clean up post info and get any other data to be returned.
	 * @param  array &$aPost An array of a single post.
	 */
	private function _getPostInfo(&$aPost) {
		if(!empty($aPost)) {
			$aPost["title"] = htmlspecialchars(stripslashes($aPost["title"]));
			if(!empty($aPost["excerpt"]))
				$aPost["excerpt"] = stripslashes($aPost["excerpt"]);
			else
				$aPost["excerpt"] = (string)substr(stripslashes($aPost["content"]), 0, $this->excerptCharacters);

			$aPost["content"] = stripslashes($aPost["content"]);

			$aPost["publish_on"] = strtotime($aPost["publish_on"]);
			$aPost["url"] = "/blog/".date("Y", $aPost["publish_on"])."/".date("m", $aPost["publish_on"])."/".$aPost["tag"]."/";

			$aPost["author"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}troop`"
					." WHERE `id` = ".$this->dbQuote($aPost["authorid"], "integer")
					." LIMIT 1"
				,"row"
			);

			if(!empty($aPost['author']['social_accounts'])) {
				$aPost['author']['social_accounts'] = json_decode($aPost['author']['social_accounts'], true);
			}

			$aPost["categories"] = $this->dbQuery(
				"SELECT * FROM `{dbPrefix}posts_categories` AS `categories`"
					." INNER JOIN `{dbPrefix}posts_categories_assign` AS `posts_assign` ON `posts_assign`.`categoryid` = `categories`.`id`"
					." WHERE `posts_assign`.`postid` = ".$aPost["id"]
				,"all"
			);

			foreach($aPost["categories"] as &$aCategory) {
				$aCategory["name"] = htmlspecialchars(stripslashes($aCategory["name"]));
			}

			if(!empty($aPost['galleryid'])) {
				$oGalleries = $this->loadModel('galleries');

				$aPost['gallery'] = $oGalleries->getGallery($aPost['galleryid']);
			}

			if(!empty($aPost['listing_image'])) {
				$aPost['listing_image_url'] = $this->imageFolder.$aPost['listing_image'];
			}

			if(!empty($aPost['featured_image'])) {
				$aPost['featured_image_url'] = $this->imageFolder.$aPost['featured_image'];
			}
		}
	}

	/**
	 * Get a posts URL
	 * @param  integer $sID A posts unique ID.
	 * @return array|false  Return post URL or false.
	 */
	function getURL($sID) {
		$aPost = $this->getPost($sID);

		if(!empty($aPost)) {
			return $aPost["url"];
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
			$sJoin .= " INNER JOIN `{dbPrefix}posts_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`";
		} else {
			$sJoin .= " LEFT JOIN `{dbPrefix}posts_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`";
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
			"SELECT `categories`.* FROM `{dbPrefix}posts_categories` AS `categories`"
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
			"SELECT `categories`.* FROM `{dbPrefix}posts_categories` AS `categories`"
				." LEFT JOIN `{dbPrefix}posts_categories_assign` AS `assign` ON `categories`.`id` = `assign`.`categoryid`"
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
