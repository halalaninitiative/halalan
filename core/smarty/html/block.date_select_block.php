<?php

require_once APP_CORE . "/classes/HypSelect.class.php";

Hypworks::loadAddin('time');

/**
 * The block edition of {date_select} function.
 *
 * As {chained_selects_block} is to {chained_selects}, this plugin
 * provides you the flexibility to position and pass attributes to
 * your <select> tags.
 *
 * @see function.date_select.php
 * @see common.date_select.php
 *
 */
function smarty_block_date_select_block ($params, $content, &$smarty) {
	$_block = true;
	require dirname(__FILE__) . "/common.date_select.php";

	static $id;
	if (!isset($content)) {

		/* Generate IDs */
		$id = array_pop_assoc($params, 'id', Hypworks::generateId());
		$ids = array();
		foreach ($names as $name) {
			$ids[$name] = $id . "_" . $name;
		}

		$smarty->chainedSelectIds = $ids;
		$smarty->chainedSelects = array();

	} else {

		/* Verify if there are enough select elements */
		if (count($smarty->chainedSelectIds) != count($smarty->chainedSelects)) {
			$smarty->trigger_error("block date_select_block: there must be three select elements corresponding to the 'names' or 'name' parameter given", E_USER_ERROR);
			return;
		}

		$javascript = HypSelect::csDateJavaScript($id, $options, $hide_empty, $disable_empty);
		$init = HypSelect::csInit($id, $smarty->chainedSelectIds, $cookie, $callback);
		$smarty->addToHtmlHead("<script language='JavaScript' type='text/javascript'>\n$javascript\n</script>");
		$smarty->addHtmlBodyAttribute('onload', $init);
		$smarty->chainedSelectIds = array();
		$smarty->chainedSelects = array();
		$id = null;
		return $content;
	}
}


?>