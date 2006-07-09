<?php

/**
 * The Form tag.
 *
 * Enclose your form elements using this tag.
 *
 * @param string name - will be used to identify the form within a view module
 * @param bool/string assign - If true, the defaults assigned to this form will be extracted to the scope of this block,
 *			the name of each variable is correspondent to the name of each field.
 *			If a string, the defaults assigned to this form will be assigned to a variable named after this string, whose
 *			scope is only within this block.
 *
 */
function smarty_block_form ($params, $content, &$smarty) {
	$var = array_pop_assoc($params, 'assign');
	if (isset($content)) {
		$params = $smarty->htmlFormAttributes();
		if (empty($params['action'])) {
			$smarty->trigger_error("block form: empty 'action' parameter", E_USER_WARNING);
			$params['action'] = "";
		} else {
			$params['action'] = HypModule::uri($params['action']);
		}
		if (!isset($params['method'])) {
			if (!defined('FORM_METHOD_DEFAULT'))
				$params['method'] = 'post';
			else
				$params['method'] = FORM_METHOD_DEFAULT;
		}
		$attributes = htmlAttributes($params);
		$smarty->clearHtmlFormAttributes();
		if ($var) {
			$smarty->restoreVariables();
		}
		return "<form $attributes>\n$content\n</form>";
	} else {
		if ($smarty->htmlFormAttributes()) {
			$smarty->trigger_error('block form: HTML Forms are not allowed to be nested.');
			return;
		}
		$smarty->setHtmlFormAttributes($params);
		if ($var) {
			if (is_string($var)) {
				$smarty->saveVariables(array($var => $smarty->htmlFormDefaults()));
			} else {
				$smarty->saveVariables($smarty->htmlFormDefaults());
			}
		}
	}
}


?>