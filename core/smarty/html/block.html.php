<?php

/**
 * The root of all HTML tags.
 *
 * You must replace <html> by {html}.
 *
 */

function smarty_block_html ($params, $content, &$smarty) {
	if (isset($content)) {
		$attributes = htmlAttributes($params);
		$html = "<html $attributes>\n";
		$head_attributes = htmlAttributes($smarty->htmlHeadAttributes());
		$smarty->clearHtmlHeadAttributes();
		$html .= "<head $head_attributes>\n" . $smarty->htmlHead() . "\n</head>\n";
		$smarty->clearHtmlHead();
		$html .= $content;
		$html .= "\n</html>";
		return $html;
	}
}

?>