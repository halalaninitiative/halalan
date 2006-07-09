<?php

/**
 * The multiple edition of {{@link function.option.php option}}
 *
 * This function utilizes the built-in {html_options} Smarty plugin.
 *
 * @link http://smarty.php.net/manual/en/language.function.html.options.php
 *
 */
function smarty_function_options ($params, &$smarty) {
	$plugin_file = $smarty->_get_plugin_filepath('function', 'html_options');
	if (empty($plugin_file)) {
		$smarty->trigger_error("function options: 'html_options' plugin not found!", E_USER_ERROR);
		return;
	}
	require_once $plugin_file;

	if ($selected = $smarty->selectedOptions()) {
		$params['selected'] = $selected;
	}
	return smarty_function_html_options($params, $smarty);
}


?>