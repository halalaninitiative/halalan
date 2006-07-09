<?php

/**
 * Formats a timestamp to a date understandable compatible to
 * the Date data type of SQL.
 *
 */
function sqlDate ($timestamp = null) {
	if (func_num_args() < 1) {
		return date('Y-m-d');
	} else {
		return date('Y-m-d', $timestamp);
	}
}

function sqlArray ($data) {
	if (!is_array($data)) {
		$data = array($data);
	}
	foreach ($data as $key => $datum) {
		$data[$key] = addslashes($datum);
	}
	$data_str = "('" . implode("','", $data) . "')";
	return $data_str;
}

?>