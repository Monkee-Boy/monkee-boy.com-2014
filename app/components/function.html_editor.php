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
	$return .= "tinymce.init({\n";
	$return .= "\tmode : 'textareas',\n";
	$return .= "\ttheme : 'modern',\n";
	$return .= "\tplugins: ['advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker', 'searchreplace wordcount visualblocks visualchars code fullscreen media nonbreaking', 'table contextmenu directionality textcolor paste textcolor colorpicker textpattern'],\n";
  $return .= "\ttoolbar_items_size: 'small',\n";
	$return .= "\teditor_selector : '".$name."_editor',\n";
	$return .= "\twidth: '".$width."',\n";
	$return .= "\theight: '".$height."',\n";
	// $return .= "\tconvert_urls: false,\n";
	$return .= "\trelative_urls: false,\n";

	if($theme == "simple") {
		// $return .= "\ttheme_advanced_buttons1 : 'pastetext,pasteword,|,bold,italic,underline,strikethrough,|,numlist,bullist,|,link,unlink,|,undo,redo',\n";
		// $return .= "\ttheme_advanced_buttons2 : '',\n";
		// $return .= "\ttheme_advanced_buttons3 : '',\n";
	} else {
		$return .= "\ttoolbar1: 'formatselect | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist | outdent indent blockquote',
\n";
		$return .= "\tmenu : { // this is the complete default configuration
        edit   : {title : 'Edit'  , items : 'undo redo | cut copy paste pastetext | selectall | searchreplace'},
        insert : {title : 'Insert', items : 'link unlink anchor image media | hr'},
        format : {title : 'Format', items : 'bold italic underline strikethrough superscript subscript | fontsizeselect formats | removeformat'},
        table  : {title : 'Table' , items : 'inserttable tableprops deletetable | cell row column'},
        tools  : {title : 'Tools' , items : 'code'}
    },";
	}
	$return .= "\textended_valid_elements : 'pre,script[src],code,iframe[width|height|src|scrolling]',\n";
	$return .= "\texternal_filemanager_path: '/js/admin/tiny_mce/plugins/filemanager/',\n";
	$return .= "\tfilemanager_title: 'Filemanager',\n";
	$return .= "\texternal_plugins: { 'filemanager': '/js/admin/tiny_mce/plugins/filemanager/plugin.min.js'},\n";
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
