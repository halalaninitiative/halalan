<?php

/**
 * The multiple edition of {{@link function.radio.php radio}}
 *
 */
function smarty_function_radios ($params, &$smarty) {
	$name = array_pop_assoc($params, 'name');
	$options = array_pop_assoc($params, 'options');
	$optionsasvalues = array_pop_assoc($params, 'optionsasvalues', false);
	$selected = array_pop_assoc($params, 'selected');
	$separator = array_pop_assoc($params, 'separator', '');
	$prefix = array_pop_assoc($params, 'prefix');

	if (empty($options)) {
		$smarty->trigger_error("function radios: empty 'options' parameter", E_USER_ERROR);
		return;
	}

	/* The assigned form default in PHP precedes the 'selected' attribute in the Smarty template */
	if (isset($name)) {
		$value = $smarty->htmlFormDefault($name);
		if (isset($value)) {
			$selected = $value;
		}
	}

	$hasprefix = false;
	if (isset($prefix)) {
		if (!array_key_exists('', $options)) { // only prepend if there is no option with '' value yet
			$options = array('' => $prefix) + $options;
			if (!isset($selected)) {
				$selected = ''; // select this if there is none explicitly set
			}
			$hasprefix = true;
		}
	}

	if (isset($selected)) {
		settype($selected, 'string');
	}

	$radios = array();
	foreach ($options as $value => $label) {
		if ($optionsasvalues && !($value === '' && $hasprefix)) {
			$value = (string)$label;
		} else {
			$value = (string)$value;
		}
		$attributes = $params;
		$attributes['type'] = "radio";
		$attributes['name'] = $name;
		$attributes['value'] = $value;
		if ($value === $selected) {
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