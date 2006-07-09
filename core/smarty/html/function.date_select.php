<?php

require_once APP_CORE . "/classes/HypSelect.class.php";

Hypworks::loadAddin('time');

/**
 * A group of Select tags whose input is a date, more specifically, a valid date.
 *
 * This plugin is an improved {html_select_date} that is bundled with Smarty.
 * While {html_select_date} statically creates Select tags, this plugin is
 * dynamically-driven, utilizing JavaScript. If you select October, there will be
 * up to 31 days; if April, 30 days; and if February, there can be either 28 or 29
 * days, depending on what year you choose.
 *
 * @param string names - A comma-separated list of names of each select element (year, month, and day), respectively. Required, unless name is provided.
 * @param string name - If this is provided instead of names, it is just like having a names parameter equal to "name[year], name[month], name[day]".
 * @param string separator - The separator of each select element.
 * @param string cookie
 * @param string callback
 * @param bool hide_callback
 * @param bool disable_empty
 *
 * @see common.date_select.php
 * @see block.date_select_block.php
 *
 */
function smarty_function_date_select ($params, &$smarty) {
	$_block = false;
	require dirname(__FILE__) . "/common.date_select.php";

	$id = array_pop_assoc($params, 'id', Hypworks::generateId());

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

	$javascript = HypSelect::csDateJavaScript($id, $options, $hide_empty, $disable_empty);
	$init = HypSelect::csInit($id, $ids, $cookie, $callback);
	$smarty->addToHtmlHead("<script language='JavaScript' type='text/javascript'>\n$javascript\n</script>");
	$smarty->addHtmlBodyAttribute('onload', $init);

	return $html;
}

?>