<?php

/**
 * Extracts the contents of an associative variable in the scope.
 *
 */
function smarty_function_extract ($params, &$smarty) {
	$array = array_pop_assoc($params, 'array', array());
	$smarty->_tpl_vars = $array + $smarty->_tpl_vars;
}

?>