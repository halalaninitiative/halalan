<?php

/**
 * This is where the necessary code to be executed in loading the Booroonggoo application
 * framework.
 *
 */

require_once APP_CORE . "/Hypworks.class.php";


set_include_path(APP_LIB . '/pear' . PATH_SEPARATOR . get_include_path()); // PEAR root folder
set_include_path(APP_LIB . PATH_SEPARATOR . get_include_path()); // library root folder
set_include_path(APP_MODULES . PATH_SEPARATOR . get_include_path()); // modules root folder

/** Loads the Constants Definition File. */
require_once APP_MODULES . "/constants.php";

/** Loads the common functions file */
require_once APP_CORE . "/functions.php";

/** Parses the Modules Definition File. */
$GLOBALS['MODULES'] = parse_ini_file(APP_MODULES . '/modules.ini', true);


?>