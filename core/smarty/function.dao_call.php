<?php

/**
 * Dynamically calls a DAO static function.
 *
 * @param string class - this must be located in the standard dao folder
 * @param string function - the name of the function to be called
 * @param string assign - optional parameter in which the return value of this function can be stored.
 *
 * Other parameters that exists will be used as the arguments to
 * the function. The name is not important, only the order.
 *
 */
function smarty_function_dao_call ($params, &$smarty) {
	$class = array_pop_assoc($params, 'class');
	$function = array_pop_assoc($params, 'function');
	$var = array_pop_assoc($params, 'assign');
	if (empty($class)) {
		$smarty->trigger_error("function dao_call: empty 'class' parameter");
        return;
	} else if (empty($function)) {
		$smarty->trigger_error("function dao_call: empty 'function' parameter");
        return;
	}

	Hypworks::loadDao($class);

	if ($var) {
		$smarty->assign($var, call_user_func_array(array($class, $function), $params));
	} else {
		return call_user_func_array(array($class, $function), $params);
	}
}

?>