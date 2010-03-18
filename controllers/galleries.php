<?php
class galleries extends appController
{
	function index()
	{
		$oGalleries = $this->loadModel("galleries");
		
		## GET CURRENT PAGE GALLERIES
		$sCurrentPage = $_GET["page"];
		if(empty($sCurrentPage))
			$sCurrentPage = 1;
		
		$aGalleryPages = array_chunk($oGalleries->getGalleries($_GET["category"]), $oGalleries->perPage);
		$aGalleries = $aGalleryPages[$sCurrentPage - 1];
		
		$aPaging = array(
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
		
		if($sCurrentPage == count($aGalleryPages) || count($aGalleryPages) == 0)
			$aPaging["next"]["use"] = false;
		#########################

		$this->tplAssign("aCategories", $oGalleries->getCategories());
		$this->tplAssign("aGalleries", $aGalleries);
		$this->tplAssign("aPaging", $aPaging);
		
		if(!empty($_GET["category"]) && $this->tplExists("galleries/category-".$_GET["category"]."tpl"))
			$this->tplDisplay("galleries/category-".$_GET["category"].".tpl");
		elseif(!empty($_GET["category"]) && $this->tplExists("galleries/category.tpl"))
			$this->tplDisplay("galleries/category.tpl");
		else
			$this->tplDisplay("galleries/index.tpl");
	}
	function gallery()
	{
		$oGalleries = $this->loadModel("galleries");
		
		$aGallery = $oGalleries->getGallery($this->_urlVars->dynamic["id"]);
		
		if(empty($aGallery))
			$this->error('404');
		
		$aGallery["photos"] = $oGalleries->getPhotos($this->_urlVars->dynamic["id"]);
		
		$this->tplAssign("aGallery", $aGallery);
	
		if($this->tplExists("galleries/gallery-".$aGallery["id"].".tpl"))
			$this->tplDisplay("galleries/gallery-".$aGallery["id"].".tpl");
		else
			$this->tplDisplay("galleries/gallery.tpl");
	}
}