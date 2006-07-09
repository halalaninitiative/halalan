<?php


/**
 * Gets the mime type (e.g. application/x-zip, image/jpeg), given the filename. This utilizes the unix command `file`.
 * NOTE: this function is given because for some strange reason the built-in function mime_content_type is not as much effective as the `file` command.
 */
function mimeType ($filename) {
	$mimeType = explode(':', shell_exec("file -i \"$filename\""));
	return trim($mimeType[count($mimeType) - 1]);
}


/**
 * Checks if $filename has an extension in $exts
 * NOTE: $exts can be an array or a string (it musn't include dot)
 */
function isExtension ($filename, $exts) {
	if (!is_array($exts))
		$exts = array($exts);
	return in_array(strtolower(strLastPart($filename, ".")), $exts);
}

/**
 * Create a directory recursively. NOTE: this function is already provided in PHP 5 (see mkdir())
 *
 * Useful if you want to create a directory even though its parent directories does not exist yet.
 *
 */
function mkdirhier ($dirname) {
	$dirname = rtrim($dirname, '/'); // remove any trailing slashes
	if (file_exists($dirname))
		return false; // nothing else to create;
	$curr = $dirname;
	$components = array();
	while (!file_exists($curr) && $curr) {
		$components[] = basename($curr);
		$curr = dirname($curr);
	}
	while (!empty($components)) {
		$curr .= '/' . array_pop($components);
		if (!mkdir($curr))
			return false;
	}
	return true;
}


?>