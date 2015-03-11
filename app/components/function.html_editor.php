<?php
function html_editor($content = '', $name = '', $label = '', $class = '', $theme = '', $width = null, $height = null) {
	if(empty($width))
		$width = "100%";

	if(empty($height))
		$height = "500";

	$content = stripslashes($content);

	$return = "{footer}\n";
	$return .= "<script>if(typeof(tinymce) === 'undefined') { document.write('<script src=\"/js/admin/tiny_mce/jquery.tinymce.min.js\"><\/script><script src=\"/js/admin/tiny_mce/tinymce.min.js\"><\/script>'); }</script>\n";
	$return .= "<script>\n";
	$return .= "tinyMCE.init({\n";

	if($_COOKIE[$name."_editor"] == "html")
		$return .= "\tmode : 'none',\n";
	else
		$return .= "\tmode : 'textareas',\n";

	$return .= "\ttheme : 'modern',\n";
	$return .= "\tplugins: ['advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker', 'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking', 'table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern'],\n";
	$return .= "\tmenubar: false,\n";
  $return .= "\ttoolbar_items_size: 'small',\n";
	$return .= "\teditor_selector : '".$name."_editor',\n";
	$return .= "\twidth: '".$width."',\n";
	$return .= "\theight: '".$height."',\n";

	if($theme == "simple") {
		// $return .= "\ttheme_advanced_buttons1 : 'pastetext,pasteword,|,bold,italic,underline,strikethrough,|,numlist,bullist,|,link,unlink,|,undo,redo',\n";
		// $return .= "\ttheme_advanced_buttons2 : '',\n";
		// $return .= "\ttheme_advanced_buttons3 : '',\n";
	} else {
		$return .= "\ttoolbar1: 'newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect',
        toolbar2: 'cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor',
        toolbar3: 'table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft',
\n";
	}
	$return .= "\tvalid_elements : '*[*]',\n";
	$return .= "});\n";
	$return .= "</script>\n";
	$return .= "{/footer}\n";
	$return .= "\t<label class=\"control-label pull-left\" for=\"".$name."_editor\">".$label."</label>\n";
	$return .= "\t<div class=\"controls\">\n";
	$return .= "<div id=\"tinymce_editor_".$name."\" class=\"tinymce_editor\" style=\"clear: both;\">\n";
	$return .= "\t<textarea id='".$name."_editor' name='".$name."' class='".$name."_editor full ".$class."' style=\"width: 98.5%; height: ".($height - 15)."px;\">".$content."</textarea><br>\n";
	$return .= "</div></div>\n";

	return $return;
}
