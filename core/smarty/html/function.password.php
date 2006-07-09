<?php

/**
 * The password-typed Input tag.
 *
 * @param string label
 *
 */
function smarty_function_password ($params, &$smarty) {
	$label = array_pop_assoc($params, 'label');
	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (!empty($value)) {
			$params['value'] = $value;
		}
	}
	$params['type'] = 'password';
	$attributes = htmlAttributes($params);
	$html = "<input $attributes/>";
	if ($label) {
		$html = "<label>$label$html</label>";
	}
	return $html;
}


?>