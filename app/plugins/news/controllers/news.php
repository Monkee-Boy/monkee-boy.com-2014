<?php
class news extends appController {
	function __construct() {
		// Load model when creating appController
		parent::__construct("news");
	}

	function index() {
		## GET CURRENT PAGE NEWS
		$sCurrentPage = $_GET["page"];
		if(empty($sCurrentPage))
			$sCurrentPage = 1;

		$aArticlePages = array_chunk($this->model->getArticles($_GET["category"]), $this->model->perPage);
		$aPosts = $aArticlePages[$sCurrentPage - 1];

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

		$this->tplAssign("aCategories", $this->model->getCategories(false));
		$this->tplAssign("aPosts", $aPosts);
		$this->tplAssign("aPaging", $aPaging);
		$this->tplAssign("aCategory", $aCategory);

		if(!empty($_GET["category"]) && $this->tplExists("category-".$_GET["category"].".php"))
			$this->tplDisplay("category-".$_GET["category"].".php");
		elseif(!empty($_GET["category"]) && $this->tplExists("category.php"))
			$this->tplDisplay("category.php");
		else
			$this->tplDisplay("index.php");
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
}
