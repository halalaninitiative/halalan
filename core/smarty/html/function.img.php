<?php

/**
 * The Img tag.
 *
 * @param string src - the source of the image file
 * @param boolean absolute - if true, the src parameter will be untouched, else src will be appended by APP_INCLUDES (default: depends on src)
 *
 */
function smarty_function_img ($params, &$smarty) {
	$src = array_pop_assoc($params, 'src');
	$absolute = (bool)array_pop_assoc($params, 'absolute', isAbsUri($src));
	if (empty($src)) {
		$smarty->trigger_error("function img: empty 'src' parameter");
		return;
	}
	if (!$absolute)
		$src = APP_INCLUDES . "/$src";
	$src = htmlentities($src, ENT_QUOTES);

	$attributes = htmlAttributes($params);

	return "<img src=\"$src\" $attributes />";
}


?>