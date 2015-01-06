<?php
class news extends appController {
	function __construct() {
		// Load model when creating appController
		parent::__construct("news");

		$this->tplAssign('aContent', $this->model->content);
	}

	function index() {
		// $this->import();
		## GET CURRENT PAGE NEWS
		$sCurrentPage = $_GET["page"];
		if(empty($sCurrentPage))
			$sCurrentPage = 1;

		$aArticlePages = array_chunk($this->model->getArticles($_GET["category"]), $this->model->perPage);
		$aArticles = $aArticlePages[$sCurrentPage - 1];

		$aPaging = array(
			"total" => count($aArticlePages),
			"current" => $sCurrentPage,
			"back" => array(
				"page" => $sCurrentPage - 1,
				"use" => true
			),
			"next" => array(
				"page" => $sCurrentPage + 1,
				"use" => true
			)
		);

		if(($sCurrentPage - 1) < 1 || $sCurrentPage == 1)
			$aPaging["back"]["use"] = false;

		if($sCurrentPage == count($aArticlePages) || count($aArticlePages) == 0)
			$aPaging["next"]["use"] = false;
		#########################

		if(!empty($_GET["category"]))
			$aCategory = $this->model->getCategory($_GET["category"]);

		if(!empty($aArticles)) {
			$aTopArticle = array_shift($aArticles);
		}

		$this->tplAssign("aCategories", $this->model->getCategories(true));
		$this->tplAssign("aTopArticle", $aTopArticle);
		$this->tplAssign("aArticles", $aArticles);
		$this->tplAssign("aPaging", $aPaging);
		$this->tplAssign("aCategory", $aCategory);

		if(!empty($_GET["category"]) && $this->tplExists("category-".$_GET["category"].".php"))
			$this->tplDisplay("category-".$_GET["category"].".php");
		elseif(!empty($_GET["category"]) && $this->tplExists("category.php"))
			$this->tplDisplay("category.php");
		else
			$this->tplDisplay("index.php");
	}
	function ajax_load() {
		$sCurrentPage = $_GET["page"];
		if(empty($sCurrentPage))
			$sCurrentPage = 1;

		$aArticlePages = array_chunk($this->model->getArticles($_GET["category"]), $this->model->perPage);

		if($sCurrentPage > count($aArticlePages)) {
			$sCurrentPage = count($aArticlePages);
		}

		$aArticles = $aArticlePages[$sCurrentPage - 1];

		foreach($aArticles as &$aArticle) {
			$aArticle['publish_on_month'] = date("m", $aArticle['publish_on']);
			$aArticle['publish_on_day'] = date("d", $aArticle['publish_on']);
			$aArticle['publish_on_year'] = date("Y", $aArticle['publish_on']);

			// Minimize traffic size. Also content throws UTF8 error when encoding to JSON.
			unset($aArticle['tag'], $aArticle['excerpt'], $aArticle['content'], $aArticle['tags'], $aArticle['publish_on'], $aArticle['active'], $aArticle['views'], $aArticle['created_datetime'], $aArticle['created_by'], $aArticle['updated_datetime'], $aArticle['updated_by'], $aArticle['categories']);
		}

		$aData = array(
			"articles" => $aArticles,
			"pages" => count($aArticlePages)
		);

		echo json_encode($aData);
	}
	function article() {
		$aArticle = $this->model->getArticle(null, $this->urlVars->dynamic["tag"]);

		if(empty($aArticle))
			$this->error('404');

		$this->dbUpdate("news", array("views" => ($aArticle["views"] + 1)), $aArticle["id"]);
		$this->tplAssign("aArticle", $aArticle);

		if($this->tplExists("article-".$aPost["id"].".php"))
			$this->tplDisplay("article-".$aPost["id"].".php");
		else
			$this->tplDisplay("article.php");
	}
	function rss() {
		$aArticles = array_slice($this->model->getArticles($_GET["category"]), 0, 15);

		$this->tplAssign("domain", $_SERVER["SERVER_NAME"]);
		$this->tplAssign("aArticles", $aArticles);

		header("Content-Type: application/rss+xml");
		$this->tplDisplay("rss.php");
	}
	function import() {
		$this->dbQuery("TRUNCATE TABLE `{dbPrefix}news`");

		$aData = $this->dbQuery(
			"SELECT * FROM `mw_news` ORDER BY `mw_news_date`",
			"all"
		);

		foreach($aData as $aRow) {
			$aArticle = array();
			$aArticle['title'] = $aRow['mw_news_title'];
			$aArticle['tag'] = substr(strtolower(str_replace("--","-",preg_replace("/([^a-z0-9_-]+)/i", "", str_replace(" ","-",trim($aRow['mw_news_title']))))),0,100);
			$aArticle['excerpt'] = $aRow['mw_news_smdesc'];
			$aArticle['content'] = $aRow['mw_news_body'];
			$aArticle['tags'] = '';
			$aArticle['publish_on'] = date('Y-m-d H:i:s', strtotime($aRow['mw_news_date']));
			$aArticle['active'] = 1;
			$aArticle['views'] = 0;
			$aArticle['created_datetime'] = date('Y-m-d H:i:s');
			$aArticle['created_by'] = 1;
			$aArticle['updated_datetime'] = date('Y-m-d H:i:s');
			$aArticle['updated_by'] = 1;

			$aArticles = $this->dbQuery(
				"SELECT `tag` FROM `{dbPrefix}news`"
				." ORDER BY `tag`"
				,"all"
			);

			if(in_array(array('tag' => $aArticle['tag']), $aArticles)) {
				$i = 1;
				do {
					$sTempTag = substr($aArticle['tag'], 0, 100-(strlen($i)+1)).'-'.$i;
					$i++;
					$checkDuplicate = in_array(array('tag' => $sTempTag), $aArticles);
				} while ($checkDuplicate);
				$aArticle['tag'] = $sTempTag;
			}

			$this->dbInsert("news", $aArticle);
		}

		// echo "<pre>";
		// print_r($aData);
		// echo "</pre>";
		die;
	}
}
