<?php

/**
 * Sets variables.
 *
 */
function smarty_function_set ($params, &$smarty) {
	settype($params, 'array');
	settype($smarty->_tpl_vars, 'array');
	$smarty->_tpl_vars = $params + $smarty->_tpl_vars;
}

?>