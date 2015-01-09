<?php
function getContent($id, $tag = null) {
	global $oApp;

	$oContent = $oApp->loadModel('content');
	return $oContent->getPage($id, $tag);
}
