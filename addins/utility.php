<?php


/**
 * A convenience function similar to array_pop.
 *
 * The difference is that you can give a $key for the element
 * you want to pop out. Furthermore, you can also specify a $default
 * value in case the $key didn't exist.
 *
 * @param array $array
 * @param string $key
 * @param mixed $default
 *
 */
function &array_pop_assoc (&$array, $key, $default = null) {
	if (array_key_exists($key, $array)) {
		$value =& $array[$key];
		unset($array[$key]);
		return $value;
	} else {
		return $default;
	}
}

/** See Postgres Documentation for COALESCE */
function &coalesce () {
	$args =& func_get_args();
	foreach (array_keys($args) as $key) {
		if (isset($args[$key]))
			return $args[$key];
	}
	$null = null;
	return $null;
}


/**
 * Converts a two-dimensional array into one dimensional array/map.
 * The two-dimensional array is an array of array with two contents -- a key-value pair.
 */
function &array2dToMap (&$array) {
	$map = array();
	foreach ($array as $key => $row) {
		$_keys = array_keys($row);
		$map[$array[$key][$_keys[0]]] =& $array[$key][$_keys[1]];
	}
	return $map;
}



?>