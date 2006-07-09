<?php

/**
 * The Body tag.
 *
 * Basically, you must replace your <body> tag by {body}.
 * This is used internally by Hypworks to pass HTML Body attributes (e.g. onload attribute).
 *
 */
function smarty_block_body ($params, $content, &$smarty) {
	if (isset($content)) {
		foreach ($params as $key => $value) {
			$smarty->addHtmlBodyAttribute($key, $value);
		}
		$attributes = htmlAttributes($smarty->htmlBodyAttributes());
		$smarty->clearHtmlBodyAttributes();
		return "<body $attributes>\n$content\n</body>";
	}
}

?>