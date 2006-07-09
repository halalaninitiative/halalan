<?php

/**
 * Returns a &lt;script&gt;&lt;/script&gt; tag.
 *
 * Parameters:
 *   src - the source of the JavaScript file (required)
 *   absolute - if true, it will be taken as an absolute URI and not relative to APP_INCLUDES (default: false)
 *
 */
function smarty_function_include_js ($params, &$smarty) {
	$src = array_pop_assoc($params, 'src');
	$here = (bool)array_pop_assoc($params, 'here', false);
	$absolute = (bool)array_pop_assoc($params, 'absolute', isAbsUri($src));
	if (empty($src)) {
		$smarty->trigger_error("function include_js: empty 'src' parameter");
		return;
	}
	if (!$absolute)
		$src = APP_INCLUDES . "/$src";

	if (!$here) {
		$smarty->addJavascript($src, $params, true);
		return;
	}

	if (!isset($params['language'])) {
		$params['language'] = 'JavaScript';
	}
	$params['type'] = 'text/javascript';
	$params['src'] = $src;
	$attributes = htmlAttributes($params);
	return "<script $attributes></script>";
}


?>