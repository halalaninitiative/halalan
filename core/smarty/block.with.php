<?php

function smarty_block_with ($params, $content, &$smarty) {
	$var = array_pop_assoc($params, 'var');
	if (isset($content)) {
		$smarty->restoreVariables();
		return $content;
	} else {
		$smarty->saveVariables($var);
	}
}

?>