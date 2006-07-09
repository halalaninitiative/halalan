<?php


/**
 * Encloses a string by $prefix and $suffix if $string is not empty.
 * Otherwise, the string itself (which is empty) will be returned.
 *
 */

function smarty_modifier_enclose ($string, $prefix="", $suffix="") {

	if (!empty($string)) {
		return $prefix . $string . $suffix;
	} else {
		return $string;
	}

}


?>