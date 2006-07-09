<?php

/**
 * A block of code common to both {@link block.date_select_block.php} and {@link function.date_select.php}
 *
 * @see function.date_select.php
 * @see block.date_select_block.php
 *
 */
$names_str = trim(array_pop_assoc($params, 'names'));
$name_str = trim(array_pop_assoc($params, 'name'));
if (!$_block) {
	$separator = array_pop_assoc($params, 'separator');
}
$cookie = array_pop_assoc($params, 'cookie');
$callback = array_pop_assoc($params, 'callback');
$hide_empty = array_pop_assoc($params, 'hide_empty');
$disable_empty = array_pop_assoc($params, 'disable_empty');
if (empty($names_str) && empty($name_str)) {
	if ($_block) {
		$smarty->trigger_error("block date_select_block: empty 'names' and 'name' parameter, you must provide at least one", E_USER_ERROR);
	} else {
		$smarty->trigger_error("function date_select: empty 'names' and 'name' parameter, you must provide at least one", E_USER_ERROR);
	}
	return;
} else if (empty($names_str)) { // if 'name' is instead given, then simply append it by [year], [month], and [day]
	$names[0] = "{$name_str}[year]";
	$names[1] = "{$name_str}[month]";
	$names[2] = "{$name_str}[day]";
} else {
	$names = explode(',', $names_str, 3);
	foreach ($names as $key => $name) {
		$names[$key] = trim($name);
	}
}

/* The range of the date */
$currYear = date('Y');
$min_date = array_pop_assoc($params, 'min_date', "+0");
if (startsWith($min_date, '+') || (startsWith($min_date, '-') && !strrpos($min_date, '-'))) {
	$min_date = ($min_date + $currYear) . "-1-1";
}
$min_date = timeToArray($min_date);
if (empty($min_date['year'])) {
	$min_date['year'] = $currYear;
}
if (empty($min_date['month'])) {
	$min_date['month'] = 1;
}
if (empty($min_date['day'])) {
	$min_date['day'] = 1;
}
$max_date = array_pop_assoc($params, 'max_date', "+0");
if (startsWith($max_date, '+') || (startsWith($max_date, '-') && !strrpos($max_date, '-'))) {
	$max_date = ($max_date + $currYear) . "-12-31";
}
$max_date = timeToArray($max_date);
if (empty($max_date['year'])) {
	$max_date['year'] = $currYear;
}
if (empty($max_date['month'])) {
	$max_date['month'] = 12;
}
if (empty($max_date['day'])) {
	$max_date['day'] = 31;
}

/* Parse selected time, either through the template or by setting form defaults in the logic */
$time = array_pop_assoc($params, 'selected', time());
if (startsWith($time, '+') || (startsWith($time, '-') && !strrpos($time, '-'))) {
	$time = ($time + $currYear) . "-1-1";
}
$time = timeToArray($time);
if (!empty($name_str)) {
	$_time = $smarty->htmlFormDefault($name_str);
	if (isset($_time)) {
		$time = timeToArray($_time);
	}
} else {
	$year = $smarty->htmlFormDefault($names[0]);
	if (isset($year)) {
		$time['year'] = $year;
	}
	$month = $smarty->htmlFormDefault($names[1]);
	if (isset($month)) {
		$time['month'] = $month;
	}
	$day = $smarty->htmlFormDefault($names[2]);
	if (isset($day)) {
		$time['day'] = $day;
	}
}

/* Nullify the year if it is out of range. */
if (($time['year'] < $min_date['year']) || ($max_date['year'] < $time['year'])) {
	$time['year'] = null;
}

$year_prefix = array_pop_assoc($params, 'year_prefix');
$month_prefix = array_pop_assoc($params, 'month_prefix');
$day_prefix = array_pop_assoc($params, 'day_prefix');

$month_format = array_pop_assoc($params, 'month_format', '%B');
$day_format = array_pop_assoc($params, 'day_format', '%02d');

$options = compact('min_date', 'max_date', 'time', 'year_prefix', 'month_prefix', 'day_prefix', 'month_format', 'day_format');


$smarty->addJavaScript('hypworks/functions.js');
$smarty->addJavaScript('yangxin/chainedselects.js');
$smarty->addJavaScript('hypworks/csdate.js');


?>