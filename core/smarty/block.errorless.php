<?php

function smarty_block_errorless ($params, $content, &$smarty, &$repeat) {
	if (isset($content))
		return $content;
	else
		$repeat = !HypModule::hasError();
}

?>