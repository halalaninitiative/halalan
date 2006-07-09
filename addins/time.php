<?php

/**
 * Converts an arbitrary time format to an array time format.
 *
 * @returns associative array that have 'year', 'month', and 'day' indexes
 *
 */
function timeToArray ($time) {

	if (is_array($time)) { // no need to convert, this is already an array
		if (!isset($time['year']))
			$time['year'] = null;
		if (!isset($time['month']))
			$time['month'] = null;
		if (!isset($time['day']))
			$time['day'] = null;
		return $time;
	}

	if (!is_numeric($time)) {
		$matches = array();
		if (preg_match('@([\d]{4})?-([\d]{1,2})?-([\d]{1,2})?@', $time, $matches)) {
			$time = array();
			$time['year'] = @$matches[1];
			$time['month'] = @$matches[2];
			$time['day'] = @$matches[3];
			return $time;
		} else {
			$time = strtotime($time);
			if ($time == -1) { // if not a valid time format
				return array('year' => null, 'month' => null, 'day' => null);
			}
		}
	}

	$_time = $time;
	$time = array();
	$time['year'] = date('Y', $_time);
	$time['month'] = date('n', $_time);
	$time['day'] = date('j', $_time);
	return $time;

}

/**
 * Converts an arbitrary time format to an integer time format (timestamp).
 *
 * @returns integer if valid, null if invalid (e.g. month is not within 1-12)
 *
 */
function timeToInt ($time) {
	$time = timeToArray($time);
	$time = strtotime("$time[year]-$time[month]-$time[day]");
	return ($time == -1) ? null : $time;
}

/**
 * Converts an arbitrary time format to an string time format (YYYY-MM-DD).
 *
 * In contrast to timeArrayToInt(), this function does not validate the $time.
 *
 * @returns string
 *
 */
function timeToStr ($time) {
	$time = timeToArray($time);
	return "$time[year]-$time[month]-$time[day]";
}


?>