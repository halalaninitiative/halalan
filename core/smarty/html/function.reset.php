<?php

/**
 * The reset-typed Input tag.
 *
 */
function smarty_function_reset ($params, &$smarty) {

	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (!empty($value)) {
			$params['value'] = $value;
		}
	}
	$params['type'] = 'reset';
	$attributes = htmlAttributes($params);
	return "<input $attributes/>";
}


?>