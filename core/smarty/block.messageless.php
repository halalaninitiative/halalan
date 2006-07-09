<?php

function smarty_block_messageless ($params, $content, &$smarty, &$repeat) {
	if (isset($content))
		return $content;
	else
		$repeat = !HypModule::hasMessage();
}

?>