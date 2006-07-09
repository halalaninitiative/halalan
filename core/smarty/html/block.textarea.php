<?php

/**
 * The Textarea tag.
 *
 * @param string label
 *
 */
function smarty_block_textarea ($params, $content, &$smarty) {
	if (isset($content)) {
		$label = array_pop_assoc($params, 'label');
		$trim = array_pop_assoc($params, 'trim', true);
		if (isset($params['name'])) {
			$name = $params['name'];
			$value = $smarty->htmlFormDefault($name);
			if (isset($value)) {
				$content = $value;
				$trim = false; // do not trim if it is a form default
			}
		}
		if ($trim) {
			$content = trim($content);
		}

		$attributes = htmlAttributes($params);
		$content = htmlentities($content, ENT_QUOTES);
		$html = "<textarea $attributes>\n$content</textarea>"; // there is a newline, because leading new lines are ignored
		if ($label) {
			$html = "<label>$label$html</label>";
		}
		return $html;
	}
}

?>