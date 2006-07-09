<?php

/**
 * The hidden-typed Input tag.
 *
 */
function smarty_function_hidden ($params, &$smarty) {
	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (!empty($value)) {
			$params['value'] = $value;
		}
	}
	$params['type'] = 'hidden';
	$attributes = htmlAttributes($params);
	return "<input $attributes/>";
}


?>