<?php

/**
 * The Head tag.
 *
 * Useful in 'body templates' for inserting additional content in the head
 * part of the HTML. For example, inserting JavaScript codes. Note that you can have
 * as many {head} blocks as you want (as long as it is within an {html} block).
 * That is, you can use {head} in the middle of your body template, but still,
 * the contents of this block will be put in the head.
 *
 */
function smarty_block_head ($params, $content, &$smarty) {
	if (isset($content)) {
		$smarty->addToHtmlHead($content);
		$smarty->addHtmlHeadAttributes($params);
	}
}

?>