<?php

/**
 * The file-typed Input tag.
 *
 * @param string label
 *
 */
function smarty_function_file ($params, &$smarty) {
	$label = array_pop_assoc($params, 'label');
	if ($smarty->htmlFormAttribute('enctype') == null) {
		$smarty->setHtmlFormAttributes('enctype', 'multipart/form-data');
	}
	$params['type'] = 'file';
	$attributes = htmlAttributes($params);
	$html = "<input $attributes/>";
	if ($label) {
		$html = "<label>$label$html</label>";
	}
	return $html;
}


?>