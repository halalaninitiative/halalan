<?php

require_once APP_CORE . "/classes/HypSelect.class.php";

/**
 * The block edition of {chained_selects} function.
 *
 * This gives you the flexibility to change attributes, position, etc.
 * of each specific <select> tags that you will use.
 *
 * @see function.chained_selects.php
 *
 */
function smarty_block_chained_selects_block ($params, $content, &$smarty) {
	$options = array_pop_assoc($params, 'options');
	$names_str = trim(array_pop_assoc($params, 'names'));
	$cookie = array_pop_assoc($params, 'cookie');
	$callback = array_pop_assoc($params, 'callback');
	$hide_empty = array_pop_assoc($params, 'hide_empty');
	$disable_empty = array_pop_assoc($params, 'disable_empty');
	$_selected = array_pop_assoc($params, 'selected', array());
	if (!isset($options)) {
		$smarty->trigger_error("block chained_selects_block: empty 'options' parameter");
		return;
	} else if (empty($names_str)) {
		$smarty->trigger_error("block chained_selects_block: empty 'names' parameter");
		return;
	}
	if (!is_array($_selected)) {
		$smarty->trigger_error("block chained_selects_block: 'selected' parameter must be an array", E_USER_NOTICE);
		$_selected = array($_selected);
	}

	$smarty->addJavaScript('hypworks/functions.js');
	$smarty->addJavaScript('yangxin/chainedselects.js');

	static $id;
	static $selected;

	if (!isset($content)) {

		/** Create the $names and $selected variables */
		$names = explode(',', $names_str);
		$selected = array();
		$_has = false;
		foreach ($names as $key => $name) {
			$names[$key] = trim($name);
			$_value = $smarty->htmlFormDefault($names[$key]);
			if (isset($_value)) {
				$_has = true;
				$selected[$key] = $_value;
			} else {
				$selected[$key] = isset($_selected[$key]) ? $_selected[$key] : null;
			}
		}

		/** Generate IDs */
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
			$smarty->trigger_error("block chained_selects_block: the number of names provided doesn't match the actual number of select tags that has name in the given 'names' argument", E_USER_ERROR);
			return;
		}

		/* Overwrite the default options */
		HypSelect::setHierSelected($options, $selected);

		$javascript = HypSelect::csJavaScript($id, $options, $hide_empty, $disable_empty);
		$init = HypSelect::csInit($id, $smarty->chainedSelectIds, $cookie, $callback);
		$smarty->addToHtmlHead("<script language='JavaScript' type='text/javascript'>\n$javascript\n</script>");
		$smarty->addHtmlBodyAttribute('onload', $init);
		$smarty->chainedSelectIds = array();
		$smarty->chainedSelects = array();
		$id = null;
		$selected = null;
		return $content;
	}
}


?>