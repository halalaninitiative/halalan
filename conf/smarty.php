<?php

/* Smarty-specific configuration */
define('SMARTY_PATH', APP_LIB . '/smarty');
define('SMARTY_CACHING', false);
define('SMARTY_CACHE_LIFETIME', 24*60*60);
define('SMARTY_USE_SUB_DIRS', true);
define('SMARTY_COMPILE_CHECK', true); // turn this off for production websites
define('TEMPLATES_PATH', APP_ROOT . '/templates');
define('TEMPLATES_COMPILED_PATH', APP_ROOT . '/templates/.compiled');
define('TEMPLATES_CACHE_PATH', APP_ROOT . '/templates/.cache');
define('TEMPLATES_DEFAULT', 'main.tpl');
$SMARTY_PLUGINS_PATH[] = APP_MODULES . '/smarty';
$SMARTY_PLUGINS_PATH[] = APP_CORE . '/smarty';
$SMARTY_PLUGINS_PATH[] = APP_CORE . '/smarty/html';
$SMARTY_PLUGINS_PATH[] = APP_LIB . '/smarty_plugins';
//$SMARTY_PLUGINS_PATH[] = APP_LIB . '/smarty_plugins/smartyvalidate';
define('SMARTY_ERROR_REPORTING', false);
define('SMARTY_DEBUG', APP_DEBUG_ENABLED && @$_SESSION['_debug_']);


?>