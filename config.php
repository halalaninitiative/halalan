<?php

/** NOTE: DON'T FORGET TO SET ERROR_REPORTING TO 0 IF THIS APPLICATION WILL BE DEPLOYED */
error_reporting(E_ALL);
//error_reporting(0);
/** NOTE: DON'T FORGET TO SET ERROR_REPORTING TO 0 IF THIS APPLICATION WILL BE DEPLOYED */


define('APP_NAME', 'Halalan');
define('APP_EMAIL', 'kahitsino@kahitsaan.com');
define('APP_ROOT', dirname(__FILE__));
define('APP_CONF', APP_ROOT . '/conf');

/* Miscellaneous / Unclassified */
require_once APP_CONF . "/misc.php";

require_once APP_CONF . "/app.php";

/* Database configuration */
//require_once APP_LIB . '/adodb/adodb.inc.php';
require_once APP_CONF . "/db.php";

/* Session Management */
//require_once('lib/adodb/session/adodb-session.php');
//ini_set('session.gc_probability', '1');
//ini_set('session.gc_divisor', '1');
//ini_set('session.gc_maxlifetime', 5*60);
session_start();

/* Debugging Configuration */
define('APP_DEBUG_ENABLED', true && error_reporting()); // error_reporting must not be zero, too
if (strtolower(@$_GET['debug']) == "on") {
	$_SESSION['_debug_'] = true;
} else if (strtolower(@$_GET['debug']) == "off") {
	unset($_SESSION['_debug_']);
}

/* Smarty-specific configuration */
require_once APP_CONF . "/smarty.php";

/* ADODB configuration */
require_once APP_CONF . "/adodb.php";

/* the current URI (this is almost the same as what is in a browser's location bar) */
define('URI', APP_PROTOCOL . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");

/*
 * When adding configuration constant, its name must be all uppercase.
 * It is very much advised that the constant name be PRECEDED BY A MODULE that uses it.
 * And PLEASE USE UNDERSCORES.
 * If you feel like modularizing it, do so, and place your configuration module in APP_CONF and include it here
 *
 * See the example below.
 */
define('ELECTION_NAME', 'Engineering Student Council 2007-2008');
define('ELECTION_STATUS', 'inactive'); // active or inactive
define('ELECTION_RESULT', 'show'); // show or hide
define('ELECTION_PIN_PASSWORD_GENERATION', 'web'); // web or email
define('ELECTION_PIN_PASSWORD_CHARS', 'abcdefghijklmnopqrstuvwxyz0123456789');
define('ELECTION_PIN_LENGTH', 6);
define('ELECTION_PASSWORD_LENGTH', 6);
// if this is disabled, election pin will not be used
define('ELECTION_CAPTCHA', 'disable'); // enable or disable
define('ELECTION_PICTURE', 'disable'); // enable or disable
// this is voter-dependent position
define('ELECTION_UNIT', 'enable'); // enable or disable

// The following constant defines the upload path
define('UPLOAD_PATH', APP_ROOT . '/files');

// The following constants define the pagination parameter (in voters only for now)
define('PAGE_LIMIT', 10); // number of displays per page
$DISPLAYS = array(1, 10, 20, 50, 100); // different displays

// The following constants define the CAPTCHA generated
define('FONT_SIZE', 24);
define('FONT_PATH', APP_ROOT . '/includes/fonts/');
define('FONT_FILE', 'Vera.ttf');
define('CAPTCHA_WIDTH', 200);
define('CAPTCHA_HEIGHT', 100);

// The following constants define the Mailer
// Please fill up with your mail server configuration
define('MAIL_FROM', 'halalan@uplug.org');
define('MAIL_FROM_NAME', 'Halalan');
define('MAIL_HOST', ''); // fill this is up
define('MAIL_PORT', 25);
define('MAIL_MAILER', 'smtp');
define('MAIL_SMTPAUTH', true);
define('MAIL_USERNAME', ''); // fill this is up
define('MAIL_PASSWORD', ''); // fill this is up

// The following constants define the SMS configuration
define('SMS_SERVER', ''); // fill this is up
define('SMS_KEYWORD', 'HALALAN');
define('SMS_REGISTER', 'REG');
define('SMS_VOTE', 'BOTO');
define('SMS_RESULT', 'RESULTA');
define('SMS_DEFAULT_MESSAGE', 'maling paraan ng paggamit');

/** NOTE: FOR NON-CONFIGURABLE CONSTANTS (I.E. APPLICATION-SPECIFIC CONSTANTS), PLEASE USE "APP_MODULES/constants.php" */


?>