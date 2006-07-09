<?php


/**
 * Given a string and a substring, this function returns true if string starts with the substring.
 */
function startsWith ($str, $sub, $case_sensitive = true) {
	if ($case_sensitive) {
		return (substr($str, 0, strlen($sub)) == $sub);
	} else {
		return (boolean)!strcasecmp(substr($str, 0, strlen($sub)), strtolower($sub));
	}
}

/**
 * Given a string and a substring, this function returns true if string ends with the substring.
 */
function endsWith ($str, $sub, $case_sensitive = true) {
	if ($case_sensitive) {
		return (substr($str, strlen($str) - strlen($sub)) == $sub);
	} else {
		return (boolean)!strcasecmp(substr($str, strlen($str) - strlen($sub)), $sub);
	}
}

/**
 * Given a string and a delimiter, this function returns the first partition parted by the delimiter.
 */
function strFirstPart ($str, $delimiter) {
	$parts = explode($delimiter, $str);
	return $parts[0];
}

/**
 * Given a string and a delimiter, this function returns the last partition parted by the delimiter.
 * For extracting the base filename from a path, use the built-in function basename().
 */
function strLastPart ($str, $delimiter) {
	$parts = explode($delimiter, $str);
	return $parts[count($parts)-1];
}


function strRemoveFirst ($str, $delimiter) {
	$parts = explode($delimiter, $str);
	unset($parts[0]); // remove the first component
	return implode($delimiter, $parts);
}

function strRemoveLast ($str, $delimiter) {
	$parts = explode($delimiter, $str);
	unset($parts[count($parts)-1]); // remove the last component
	return implode($delimiter, $parts);
}

/**
 * Basically, this function simply works just like explode,
 * except that all the strings in the array are trimmed.
 */
function strToArray ($str, $delimiter = ",", $limit = null) {
	if (func_get_args() >= 3) {
		$parts = explode($delimiter, $str, $limit);
	} else {
		$parts = explode($delimiter, $str);
	}
	foreach ($parts as $key => $part) {
		$parts[$key] = trim($part);
	}
	return $parts;
}


?>