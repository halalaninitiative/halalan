<?php

/**
 * Returns a &lt;link /&gt; tag.
 *
 * Parameters:
 *   src - the source of the Cascading Style Sheet file (required)
 *   absolute - if true, it will be taken as an absolute URI and not relative to APP_INCLUDES (default: false)
 *
 */
function smarty_function_include_css ($params, &$smarty) {
	$src = array_pop_assoc($params, 'src');
	$here = (bool)array_pop_assoc($params, 'here', false);
	$absolute = (bool)array_pop_assoc($params, 'absolute', isAbsUri($src));
	if (empty($src)) {
		$smarty->trigger_error("function include_css: empty 'src' parameter");
		return;
	}
	if (!$absolute)
		$src = APP_INCLUDES . "/$src";

	$params['rel'] = 'stylesheet';
	$params['type'] = 'text/css';
	if (!$here) {
		$smarty->addLink($src, $params, true);
		return;
	}

	$params['href'] = $src;
	$attributes = htmlAttributes($params);
	return "<link $attributes/>";
}


?>