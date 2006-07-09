<?php

/**
 * Accepts an array of integer.
 *
 * This function returns an integer with a bit positioned at n is turned on (i.e. = 1)
 * for every n in $array.
 *
 * @returns integer
 *
 */
function arrayToIntBitOn ($array) {
	$integer = 0;
	foreach ($array as $int) {
		settype($int, 'integer');
		if ($int <= 0) {
			trigger_error(__FUNCTION__ . "(): parameter must only contain positive integers", E_USER_ERROR);
			return;
		}
		$integer |= (1 << ($int-1));
	}
	return $integer;
}


function intToArrayBitOn ($integer) {
	settype($integer, 'integer');
	if ($integer < 0) {
		trigger_error(__FUNCTION__ . "(): parameter must be non-negative", E_USER_ERROR);
		return;
	}
	$array = array();
	$i = 0;
	while ($integer) {
		$i++;
		if ($integer & 1) {
			$array[] = $i;
		}
		$integer >>= 1;
	}
	return $array;
}

/**
 * TODO: optimize this by making the implementation an iteration instead of recursion
 *
 */
function arrayMaxRecursive ($array, $callback = null) {
	$max = null;
	foreach ($array as $element) {
		if (is_array($element)) {
			$value = arrayMaxRecursive($element, $callback);
		} else if (isset($callback))  {
			$value = call_user_func($callback, $element);
		} else {
			$value = $element;
		}
		if (isset($max)) {
			if ($value > $max) {
				$max = $value;
			}
		} else {
			$max = $value;
		}
	}
	return $max;
}

?>