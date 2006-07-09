<?php

/**
 * Checks if the given URI is absolute or not.
 *
 */
function isAbsUri ($uri) {
	return (boolean)preg_match('@^[\w]+://@', $uri);
}


/**
 * Converts an associative array into a string ready for
 * inclusion in html as attribute(s).
 *
 */
function htmlAttributes ($params) {
	$attributes = "";
	foreach ($params as $key => $value) {
		$attributes .= "$key=\"" . htmlentities((string)$value, ENT_QUOTES) . "\" ";
	}
	return $attributes;
}


?>