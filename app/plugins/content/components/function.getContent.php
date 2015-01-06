<?php
function getContent($id, $tag = null) {
	global $oApp;

	if(!empty($tag))
		$aContent = $oApp->dbQuery(
			"SELECT * FROM `{dbPrefix}content`"
				." WHERE `tag` = ".$oApp->dbQuote($tag, "text")
			,"row"
		);
	elseif(!empty($id))
		$aContent = $oApp->dbQuery(
			"SELECT * FROM `{dbPrefix}content`"
				." WHERE `id` = ".$oApp->dbQuote($id, "text")
			,"row"
		);

	if(!empty($aContent)) {
		$aContent["title"] = htmlspecialchars(stripslashes($aContent["title"]));
		$aContent["subtitle"] = htmlspecialchars(stripslashes($aContent["subtitle"]));
		$aContent["content"] = stripslashes($aContent["content"]);
		return $aContent;
	} else {
		return null;
	}
}
