<?php

/* ADODB configuration */
define('ADODB_DEBUG', APP_DEBUG_ENABLED && @$_SESSION['_debug_']);
define('ADODB_ERROR_REPORTING', error_reporting());
define('ADODB_FETCH_MODE', 2); // associative
define('ADODB_FORCE_TYPE', 0); // ADODB_FORCE_IGNORE

if (isset($ADODB_SESS_CONN)) {
	$ADODB_SESS_CONN->debug = ADODB_DEBUG;
}


?>