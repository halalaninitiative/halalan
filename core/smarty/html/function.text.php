<?php

/**
 * The text-typed Input tag.
 *
 * @param string label
 *
 */
function smarty_function_text ($params, &$smarty) {
	$label = array_pop_assoc($params, 'label');
	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (!empty($value)) {
			$params['value'] = $value;
		}
	}
	$params['type'] = 'text';
	$attributes = htmlAttributes($params);
	$html = "<input $attributes/>";
	if ($label) {
		$html = "<label>$label$html</label>";
	}
	return $html;
}


?>