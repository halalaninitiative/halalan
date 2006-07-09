<?php

/**
 * The Select tag.
 *
 * Especially useful in conjunction with {option}/{options}, {chained_selects}/{chained_selects_block}, and {date_select}/{date_select_block}.
 *
 * @param string name
 * @param mixed/array(mixed) selected
 * @param boolean multiple
 * @param string label
 *
 * @see block.option.php
 * @see function.options.php
 *
 */

function smarty_block_select ($params, $content, &$smarty) {
	$name = array_pop_assoc($params, 'name');
	$selected = array_pop_assoc($params, 'selected');
	$multiple = array_pop_assoc($params, 'multiple');
	$prefix = array_pop_assoc($params, 'prefix');
	if (isset($content)) {
		$label = array_pop_assoc($params, 'label');
		$params['name'] = $name;
		if (isset($smarty->chainedSelectIds[$name])) {
			if (empty($params['id'])) {
				$params['id'] = $smarty->chainedSelectIds[$name];
			} else {
				$smarty->chainedSelectIds[$name] = $params['id'];
			}
			$smarty->chainedSelects[$name] = true;
		}
		if ($multiple) {
			$params['multiple'] = "multiple";
			$params['name'] .= "[]"; /// TODO: make this optional? i.e. check first if the name already ends with "[]"
		}
		$smarty->clearSelectedOptions();
		$attributes = htmlAttributes($params);
		if (isset($prefix)) {
			$prefix = htmlentities($prefix, ENT_QUOTES);
			$content = "<option value=''>$prefix</option>$content";
		}
		$html = "<select $attributes>$content</select>";
		if ($label) {
			$html = "<label>$label$html</label>";
		}
		return $html;
	} else {
		$_selected = $smarty->htmlFormDefault($name);
		if (isset($_selected))
			$selected = $_selected;
		if (isset($selected)) {
			$smarty->setSelectedOptions($selected);
		}
	}
}


?>