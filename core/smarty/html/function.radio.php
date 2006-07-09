<?php

/**
 * The radio-typed Input tag.
 *
 * @param string label
 *
 */
function smarty_function_radio ($params, &$smarty) {
	$label = array_pop_assoc($params, 'label');
	if (isset($params['name'])) {
		$name = $params['name'];
		$value = $smarty->htmlFormDefault($name);
		if (array_key_exists('value', $params)) {
			if ($params['value'] == $value)
				$params['checked'] = 'checked';
			else
				unset($params['checked']);
		} else {
			$smarty->trigger_error("function radio: 'value' parameter is missing", E_USER_NOTICE);
		}
	}
	$params['type'] = 'radio';
	$attributes = htmlAttributes($params);
	$html = "<input $attributes/>";
	if ($label) {
		$html = "<label>$html$label</label>";
	}
	return $html;
}


?>