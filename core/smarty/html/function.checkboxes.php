<?php

/**
 * The multiple edition of {{@link function.checkbox.php checkbox}}
 *
 */
function smarty_function_checkboxes ($params, &$smarty) {
	$name = array_pop_assoc($params, 'name');
	$options = array_pop_assoc($params, 'options');
	$optionsasvalues = array_pop_assoc($params, 'optionsasvalues', false);
	$selected = array_pop_assoc($params, 'selected');
	$separator = array_pop_assoc($params, 'separator', '');

	if (empty($options)) {
		$smarty->trigger_error("function checkboxes: empty 'options' parameter", E_USER_ERROR);
		return;
	}

	/* Automatically append "[]" to name if the number of options is greater than 1 */
	if (count($options) > 1) {
		if (isset($name)) {
			if (substr($name, -2) != "[]") {
				$name .= "[]";
			}
		}
	}

	/* The assigned form default in PHP precedes the 'selected' attribute in the Smarty template */
	if (isset($name)) {
		$value = $smarty->htmlFormDefault($name);
		if (isset($value)) {
			$selected = $value;
		}
	}

	if (is_array($selected)) {
		$selected = array_map('strval', $selected);
	} else {
		$selected = array((string)$selected);
	}

	$radios = array();
	foreach ($options as $value => $label) {
		if ($optionsasvalues) {
			$value = (string)$label;
		} else {
			$value = (string)$value;
		}
		$attributes = $params;
		$attributes['type'] = "checkbox";
		$attributes['name'] = $name;
		$attributes['value'] = $value;
		if (in_array($value, $selected, true)) {
			$attributes['checked'] = "checked";
		}
		$attributes = htmlAttributes($attributes);
		$label = htmlentities($label, ENT_QUOTES);
		$radios[] = "<label><input $attributes/>$label</label>";
	}
	$html = implode($separator, $radios);

	return $html;
}


?>