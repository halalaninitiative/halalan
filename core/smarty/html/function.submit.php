<?php

/**
 * The submit-typed Input tag.
 *
 */
function smarty_function_submit ($params, &$smarty) {

	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (!empty($value)) {
			$params['value'] = $value;
		}
	}
	$params['type'] = 'submit';
	$attributes = htmlAttributes($params);
	return "<input $attributes/>";
}


?>