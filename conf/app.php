<?php


if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
	define('APP_PROTOCOL', 'https');
} else {
	define('APP_PROTOCOL', 'http');
}
define('APP_URI', trim(APP_PROTOCOL . "://$_SERVER[HTTP_HOST]" . dirname($_SERVER['PHP_SELF']), '/'));

define('APP_CORE', APP_ROOT . '/core');
define('APP_MODULES', APP_ROOT . '/modules');
define('APP_LIB', APP_ROOT . '/lib');
define('APP_LOGS', APP_ROOT . '/logs');
define('APP_INCLUDES', APP_URI . '/includes');
define('APP_MOD_DEFAULT', 'Login');

define('APP_MOD_UNAUTHORIZED', 'Login');
define('APP_MOD_FORBIDDEN', 'Forbidden');
define('APP_MOD_MISSING', 'Missing');

define('APP_MOD_URI', '{$MOD}?{$GET}');
// if above doesnt' work
//define('APP_MOD_URI', 'index.php?' . INDEX_GET_MODULE . '={$MOD}&{$GET}');
define('APP_HOOKS', APP_MODULES . '/common/hooks');
define('APP_ADDINS', APP_ROOT . '/addins');
define('APP_DAO', APP_MODULES . '/dao');


?>