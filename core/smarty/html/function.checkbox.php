<?php

/**
 * The checkbox-typed Input tag.
 *
 * @param string label
 *
 */
function smarty_function_checkbox ($params, &$smarty) {
	$label = array_pop_assoc($params, 'label');
	if (isset($params['name'])) {
		$name = $params['name'];
		if (endsWith($name, "[]")) { // if an array
			$name = substr($name, 0, -2);
		}
		if (!array_key_exists('value', $params)) {
			$params['value'] = 1;
		}
		$value = $smarty->htmlFormDefault($name);
		if (!isset($value)) {
			if (array_pop_assoc($params, 'checked')) {
				$value = array($params['value']);
			} else {
				$value = array();
			}
		} else if (!is_array($value)) {
			$value = array($value);
		}
		if (in_array($params['value'], $value)) {
			$params['checked'] = 'checked';
		} else {
			unset($params['checked']);
		}
	}
	$params['type'] = 'checkbox';
	$attributes = htmlAttributes($params);

	$html = "<input $attributes/>";
	if ($label) {
		$html = "<label>$html$label</label>";
	}
	return $html;
}


?>