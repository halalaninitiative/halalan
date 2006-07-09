<?php

/**
 * The Option tag.
 *
 */
function smarty_block_option ($params, $content, &$smarty) {
	if (!array_key_exists('value', $params)) {
		$params['value'] = $content;
	}
	$selected = $smarty->selectedOptions();
	if (in_array($params['value'], $selected)) {
		$params['selected'] = "selected";
	} else if (!empty($selected)) { // $selected is always an array
		unset($params['selected']);
	}
	$attributes = htmlAttributes($params);
	return "<option $attributes>$content</option>";
}


?>