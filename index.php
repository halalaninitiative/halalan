<?php

require_once 'config.php';

require_once APP_CORE . "/common.php";

if (!empty($_SERVER['REDIRECT_MODULE'])) {
	$MODULE = $_SERVER['REDIRECT_MODULE'];
} else if (!empty($_GET[INDEX_GET_MODULE])) {
	$MODULE = $_GET[INDEX_GET_MODULE];
} else {
	$MODULE = APP_MOD_DEFAULT;
}
unset($_GET[INDEX_GET_MODULE]); // do not use no matter what

/**
 * Loads the appropriate module.
 * NOTE: module names are case insensitive, so if "Login" is requested,
 * 		"login" or "Login" will be served. The modules defined in the Modules Definition File
 * 		in effect must also be case-insensitive. If in a case that "Login" and "login"
 * 		are both defined in the configuration file, the first defined module will be served.
 *
 */
$PARAMS = explode('/', $MODULE);
define('MODULE_FULLNAME', $MODULE);
foreach (array_keys($MODULES) as $name) {

	$name = strtolower($name);
	$mod_parts = $PARAMS;
	$name_parts = explode('/', $name);
	foreach ($name_parts as $name_part) {
		if (strtolower(array_shift($mod_parts)) != $name_part) {
			unset($name_part);
			break;
		}
	}
	if (empty($name_part)) {
		continue;
	}
	$PARAMS = $mod_parts;

	if (endsWith(@$MODULES[$name]['path'], '.action.php')) {
		require_once APP_CORE . "/HypAction.class.php";
		$module =  new HypAction($name);
	} else {
		require_once APP_CORE . "/HypView.class.php";
		$module = new HypView($name);
	}
	$module->execute();
	exit();
}

/**
 * What to do if no module was found?
 *
 */
require_once APP_CORE . "/HypView.class.php";
HypModule::missing();


?>