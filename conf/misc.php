<?php


/* The index in the session to store userid, used by HypModule::restrict() */
define('INDEX_USERID', 'userid');
/* The index in the session to store usertype, used by HypModule::restrict() */
define('INDEX_USERTYPE', 'usertype');


/**
 * The following variables usually doesn't need to be changed, except in extreme circumstances
 * E.g. you intentionally save a variable in the session which conflicts with the indexes here.
 *
 */

/* The index in $_GET to store the module name as fallback if .htaccess is not enabled */
define('INDEX_GET_MODULE', '_mod_');

/* The index in the session to store messages */
define('INDEX_MESSAGE', '_MESSAGE_');
/* The index in the session to store errors */
define('INDEX_ERROR', '_ERROR_');
/* The index in the session to store user input */
define('INDEX_USER_INPUT', '_USER_INPUT_');


/* The action of the html form if there is no given */
define('FORM_METHOD_DEFAULT', 'post');
/* The name of the html form if there is no given */
define('FORM_NAME_DEFAULT', '_FORM_');



?>