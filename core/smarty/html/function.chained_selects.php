<?php

require_once APP_CORE . "/classes/HypSelect.class.php";

function smarty_function_chained_selects ($params, &$smarty) {
	$options = array_pop_assoc($params, 'options');
	$names_str = trim(array_pop_assoc($params, 'names'));
	$separator = array_pop_assoc($params, 'separator');
	$cookie = array_pop_assoc($params, 'cookie');
	$callback = array_pop_assoc($params, 'callback');
	$hide_empty = array_pop_assoc($params, 'hide_empty');
	$disable_empty = array_pop_assoc($params, 'disable_empty');
	$id = array_pop_assoc($params, 'id', Hypworks::generateId());
	$_selected = array_pop_assoc($params, 'selected', array());
	if (!isset($options)) {
		$smarty->trigger_error("function chained_selects: empty 'options' parameter");
		return;
	} else if (empty($names_str)) {
		$smarty->trigger_error("function chained_selects: empty 'names' parameter");
		return;
	}
	if (!is_array($_selected)) {
		$smarty->trigger_error("function chained_selects: 'selected' parameter must be an array", E_USER_NOTICE);
		$_selected = array($_selected);
	}
	$names = explode(',', $names_str);
	$selected = array();
	foreach ($names as $key => $name) {
		$names[$key] = trim($name);
		$_value = $smarty->htmlFormDefault($names[$key]);
		if (isset($_value)) {
			$selected[$key] = $_value;
		} else {
			$selected[$key] = isset($_selected[$key]) ? $_selected[$key] : null;
		}
	}

	HypSelect::setHierSelected($options, $selected);

	$smarty->addJavaScript('hypworks/functions.js');
	$smarty->addJavaScript('yangxin/chainedselects.js');

	$attributes = $params;
	$selects = array();
	$ids = array();
	foreach ($names as $name) {
		$_attrs = $attributes;
		$_attrs['id'] = $ids[] = $id . "_" . $name;
		$_attrs['name'] = $name;
		$_attrs = htmlAttributes($_attrs);
		$selects[] = "<select $_attrs>\n</select>";
	}
	$html = implode($separator, $selects);

	$javascript = HypSelect::csJavaScript($id, $options, $hide_empty, $disable_empty);
	$init = HypSelect::csInit($id, $ids, $cookie, $callback);
	$smarty->addToHtmlHead("<script language='JavaScript' type='text/javascript'>\n$javascript\n</script>");
	$smarty->addHtmlBodyAttribute('onload', $init);

	return $html;
}

?>