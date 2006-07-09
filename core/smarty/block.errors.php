<?php

function smarty_block_errors ($params, $content, &$smarty, &$repeat) {
	static $keys = array();
	$var = array_pop_assoc($params, 'all');
	$key = array_pop_assoc($params, 'key', 'errorkey');
	if (isset($content)) {
		$smarty->restoreVariables();
		$_key = array_shift($keys);
		if ($repeat = isset($_key)) {
			$_var = HypModule::error($_key);
			$smarty->saveVariables(array($key => $_key, $var => $_var));
		}
		return $content;
	} else {
		if (isset($var)) {
			$keys = array_keys(HypModule::errors());
			$_key = array_shift($keys);
			if ($repeat = isset($_key)) {
				$_var = HypModule::error($_key);
				$smarty->saveVariables(array($key => $_key, $var => $_var));
			}
		} else if ($repeat) {
			if ($repeat = HypModule::hasError()) {
				$smarty->saveVariables(HypModule::errors());
			}
		}
	}
}

?>