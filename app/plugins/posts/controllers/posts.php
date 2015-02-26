<?php
class posts extends appController {
	function __construct() {
		// Load model when creating appController
		parent::__construct("posts");

		$this->tplAssign('aContent', $this->model->content);
	}

	function index() {
		if(!empty($_GET["category"])) {
			$aCategory = $this->model->getCategory($_GET["category"]);
		}

		$aLatestPost = $this->model->getPosts(null, false, false, null, null, 1);

		$aPostPages = array_chunk($this->model->getPosts($_GET["category"], false, false, $aLatestPost[0]['id']), $this->model->perPage);
		$aPosts = $aPostPages[0];

		if(!empty($aPostPages[1])) {
			$this->tplAssign('load_more', true);
		}

		$this->tplAssign("aCategories", $this->model->getCategories(false));
		$this->tplAssign('aLatestPost', $aLatestPost[0]);
		$this->tplAssign("aPosts", $aPosts);
		$this->tplAssign("aPaging", $aPaging);
		$this->tplAssign("aCategory", $aCategory);

		$this->tplDisplay("index.php");
	}

	function post() {
		$aPost = $this->model->getPost(null, $this->urlVars->dynamic["tag"]);

		if(empty($aPost)) {
			$this->error('404');
		}

		$aPost['author']['more_posts'] = $this->model->getPosts(null, false, false, $aPost['id'], $aPost['author']['id'], 5);

		$this->dbUpdate("posts", array("views" => ($aPost["views"] + 1)), $aPost["id"]);
		$this->tplAssign("aPost", $aPost);

		$aRelatedPosts = $this->model->getPosts($aPost['categories'][0]['id'], false, false, $aPost['id'], null, 2);
		$this->tplAssign('aRelatedPosts', $aRelatedPosts);

		if($this->tplExists("post-".$aPost["id"].".php"))
			$this->tplDisplay("post-".$aPost["id"].".php");
		else
			$this->tplDisplay("post.php");
	}

	function load_more() {
		$aPostPages = array_chunk($this->model->getPosts($_GET["category"], false, false, $_GET['exclude']), $this->model->perPage);
		$aPosts = $aPostPages[$_GET['page']];

		$return = array();
		$return['posts'] = $aPosts;
		$return['next_page'] = $_GET['page']+1;
		if(!empty($aPostPages[$return['next_page']])) {
			$return['load_more'] = true;
		}

		echo json_encode($return);
	}

	function latest_post() {
		$aPost = $this->model->getPosts(null, false, false, null, null, 1);

		$this->forward($aPost[0]['url']);
	}

	function freebie_friday() {
		$aPost = $this->model->getPosts(8, false, false, null, null, 1);

		$this->forward($aPost[0]['url']);
	}

	function rss() {
		$aPosts = array_slice($this->model->getPosts($_GET["category"]), 0, 15);

		$this->tplAssign("domain", $_SERVER["SERVER_NAME"]);
		$this->tplAssign("aPosts", $aPosts);

		header("Content-Type: application/rss+xml");
		$this->tplDisplay("rss.php");
	}
}
