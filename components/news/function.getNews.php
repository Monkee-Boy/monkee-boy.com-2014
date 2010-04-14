<?php
function smarty_function_getNews($aParams, &$oSmarty) {
	$oApp = $oSmarty->get_registered_object("appController");
	
	$oNews = $oApp->loadModel("news");
	
	$aArticlePages = array_chunk($oNews->getArticles($aParams["category"]), $aParams["limit"]);
	$aArticles = $aArticlePages[0];
	
	if($aParams["limit"] == 1) {
		if(!empty($aParams["assign"]))
			$this->SMARTY->assign($aParams["assign"], $aArticles[0]);
		else
			$this->SMARTY->assign("aArticle", $aArticles[0]);
	} else {
		if(!empty($aParams["assign"]))
			$this->SMARTY->assign($aParams["assign"], $aArticles);
		else
			$this->SMARTY->assign("aArticles", $aArticles);
	}
}